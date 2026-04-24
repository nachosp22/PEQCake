#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ENV_FILE="$ROOT_DIR/.env"
ENV_EXAMPLE_FILE="$ROOT_DIR/.env.example"

ADMIN_EMAIL="${ADMIN_EMAIL:-${SETUP_ADMIN_EMAIL:-admin@tienda.com}}"
ADMIN_NAME="${ADMIN_NAME:-${SETUP_ADMIN_NAME:-Administrador PEQ}}"
ADMIN_PASSWORD="${ADMIN_PASSWORD:-${SETUP_ADMIN_PASSWORD:-}}"
GENERATED_PASSWORD=0

require_binary() {
  local name="$1"
  if ! command -v "$name" >/dev/null 2>&1; then
    echo "Error: required binary '$name' not found in PATH." >&2
    exit 1
  fi
}

ensure_env_file() {
  if [[ -f "$ENV_FILE" ]]; then
    return
  fi

  if [[ ! -f "$ENV_EXAMPLE_FILE" ]]; then
    echo "Error: neither .env nor .env.example were found." >&2
    exit 1
  fi

  cp "$ENV_EXAMPLE_FILE" "$ENV_FILE"
  echo "Created .env from .env.example"
}

generate_secure_password() {
  php -r 'echo rtrim(strtr(base64_encode(random_bytes(18)), "+/", "-_"), "=") . "!9aA";'
}

validate_password_strength() {
  local candidate="$1"

  if [[ ${#candidate} -lt 12 ]]; then
    return 1
  fi

  if [[ ! "$candidate" =~ [A-Z] ]]; then
    return 1
  fi

  if [[ ! "$candidate" =~ [a-z] ]]; then
    return 1
  fi

  if [[ ! "$candidate" =~ [0-9] ]]; then
    return 1
  fi

  if [[ ! "$candidate" =~ [^[:alnum:]] ]]; then
    return 1
  fi

  return 0
}

upsert_admin_allowed_emails() {
  local env_file="$1"
  local email="$2"

  php -r '
    $envPath = $argv[1];
    $email = strtolower(trim($argv[2]));

    if ($email === "") {
      fwrite(STDERR, "ADMIN email is empty.\n");
      exit(1);
    }

    $content = file_exists($envPath) ? file_get_contents($envPath) : "";
    if ($content === false) {
      fwrite(STDERR, "Cannot read .env file.\n");
      exit(1);
    }

    $pattern = "/^ADMIN_ALLOWED_EMAILS=(.*)$/m";
    $existing = "";

    if (preg_match($pattern, $content, $matches) === 1) {
      $existing = trim($matches[1]);
    }

    $parts = array_filter(array_map(
      static fn (string $value): string => strtolower(trim($value, " \t\n\r\0\x0B\"")),
      explode(",", $existing)
    ));

    $parts[] = $email;
    $parts = array_values(array_unique($parts));
    $newValue = "ADMIN_ALLOWED_EMAILS=" . implode(",", $parts);

    if (preg_match($pattern, $content) === 1) {
      $content = preg_replace($pattern, $newValue, $content, 1);
    } else {
      $content = rtrim($content) . PHP_EOL . $newValue . PHP_EOL;
    }

    if (file_put_contents($envPath, $content) === false) {
      fwrite(STDERR, "Cannot write .env file.\n");
      exit(1);
    }
  ' "$env_file" "$email"
}

require_binary php
ensure_env_file

if [[ -z "$ADMIN_PASSWORD" ]]; then
  ADMIN_PASSWORD="$(generate_secure_password)"
  GENERATED_PASSWORD=1
fi

if ! validate_password_strength "$ADMIN_PASSWORD"; then
  echo "Error: ADMIN_PASSWORD must be at least 12 chars and include upper/lower/digit/symbol." >&2
  exit 1
fi

if [[ ! "$ADMIN_EMAIL" =~ ^[^[:space:]@]+@[^[:space:]@]+\.[^[:space:]@]+$ ]]; then
  echo "Error: ADMIN_EMAIL is not a valid email." >&2
  exit 1
fi

cd "$ROOT_DIR"

php artisan migrate --force
upsert_admin_allowed_emails "$ENV_FILE" "$ADMIN_EMAIL"
php artisan app:setup-admin --email="$ADMIN_EMAIL" --name="$ADMIN_NAME" --password="$ADMIN_PASSWORD" --no-interaction
php artisan config:clear >/dev/null

echo
echo "Setup completed."
echo "Admin email: $ADMIN_EMAIL"

if [[ "$GENERATED_PASSWORD" -eq 1 ]]; then
  echo "Generated admin password: $ADMIN_PASSWORD"
  echo "Store it securely. It is shown only once."
else
  echo "Admin password: [provided via ADMIN_PASSWORD/SETUP_ADMIN_PASSWORD]"
fi
