<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;
class GlobalMailProvider extends ServiceProvider
{
    public function register()
    {
        // Register events or services
    }

    public function boot()
    {
        // Listen for the 'MessageSending' event to modify outgoing emails
        Event::listen(MessageSending::class, function ($event) {
            $message = $event->message;

            // Get the CC addresses from config
            $ccAddresses = config('constants.mail.developer');

            // Ensure CC is either a single email or an array of emails
            if (is_array($ccAddresses)) {
                // If it's an array, ensure each email is an instance of Symfony\Component\Mime\Address
                foreach ($ccAddresses as $cc) {
                    $message->cc(new Address($cc));
                }
            } else {
                // If it's a single email, add it directly
                $message->cc(new Address($ccAddresses));
            }
        });
    }
}

