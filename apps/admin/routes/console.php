<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Command\Command;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:setup-admin {--email=} {--name=Administrador PEQ} {--password=}', function (): int {
    $email = strtolower(trim((string) $this->option('email')));
    $name = trim((string) $this->option('name'));
    $password = (string) $this->option('password');

    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $this->error('Invalid --email value.');

        return Command::FAILURE;
    }

    if (strlen($password) < 12) {
        $this->error('Password must be at least 12 characters.');

        return Command::FAILURE;
    }

    if ($name === '') {
        $name = 'Administrador PEQ';
    }

    $user = User::query()->firstOrNew(['email' => $email]);

    $user->name = $name;
    $user->password = Hash::make($password);

    if (Schema::hasColumn('users', 'email_verified_at')) {
        $user->email_verified_at = now();
    }

    $user->save();

    $this->info(sprintf('Admin user ready for %s (id: %d).', $email, $user->id));

    return Command::SUCCESS;
})->purpose('Create or update an admin user safely');
