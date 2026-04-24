<?php

namespace App\Providers;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mime\Address;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $bccAddress = config('mail.bcc.address');
        $bccName = config('mail.bcc.name');

        if (filled($bccAddress)) {
            Event::listen(MessageSending::class, static function (MessageSending $event) use ($bccAddress, $bccName): void {
                $event->message->bcc(new Address($bccAddress, $bccName ?: ''));
            });
        }
    }
}
