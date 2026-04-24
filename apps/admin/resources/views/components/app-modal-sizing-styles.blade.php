<style>
    :root {
        --app-modal-base-max-width: 32rem;
        --app-modal-base-padding: 1.5rem;
        --app-modal-base-radius: 1rem;
    }

    .app-modal-overlay {
        position: fixed;
        inset: 0;
        padding: clamp(0.75rem, 2vw, 1.5rem);
        display: grid;
        place-items: center;
    }

    .app-modal-dialog {
        width: min(var(--app-modal-max-width, var(--app-modal-base-max-width)), calc(100vw - 2rem));
        max-width: var(--app-modal-max-width, var(--app-modal-base-max-width));
        max-height: min(88svh, 52rem);
        min-height: var(--app-modal-min-height, 0);
        border-radius: var(--app-modal-radius, var(--app-modal-base-radius));
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .app-modal-dialog--padded {
        padding: var(--app-modal-padding, var(--app-modal-base-padding));
    }

    .app-modal-scroll {
        min-height: 0;
        overflow-y: auto;
        flex: 1 1 auto;
    }

    .app-modal-dialog--compact {
        --app-modal-max-width: 24rem;
    }

    @media (max-width: 640px) {
        .app-modal-overlay {
            padding: 0.75rem;
        }

        .app-modal-dialog {
            width: calc(100vw - 1.5rem);
            max-height: calc(100svh - 1.5rem);
        }

        .app-modal-dialog--padded {
            padding: 1rem;
        }
    }
</style>
