<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreatedNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $subject = __('emails.register.subject_user',['app_name' => config('app.name')]);
        try {
            // Check if $notifiable object has the necessary properties
            if (!isset($notifiable->email) || empty($notifiable->email)) {
                throw new \Exception('The user email is missing.');
            }

            // Attempt to send the email
            $mailMessage  = (new MailMessage)
                ->subject($subject)
                ->view('emails.user_created', [
                    'user' => $notifiable,
                ]);
              # ->cc(config('constants.mail.developer'));

            /*// Log the email content for debugging
            \Log::channel('email')->info('Sending email', [
                'to' => $notifiable->email,
                'subject' => $subject,
                'content' => $mailMessage->render(),
            ]);*/
            return $mailMessage;

        } catch (\Exception $e) {
            // Log the exception message and error details
            \Log::channel('email')->info($subject , [
                'error' => $e->getMessage(),
                'to' => $notifiable->email,
                'subject' => $subject,
                //'content' => $mailMessage->render(),
            ]);
            // Optionally, return a fallback or a default message
            return (new MailMessage)
                ->subject('Error sending email')
                ->line('We encountered an issue while sending email. Please try again later.');
        }
    }

}
