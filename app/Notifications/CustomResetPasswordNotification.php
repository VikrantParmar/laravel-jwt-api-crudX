<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class CustomResetPasswordNotification extends ResetPasswordNotification
{
    use Queueable;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function toMail($notifiable)
    {
        $resetLink = $this->resetUrl($notifiable);
        $subject = __('emails.forgot_password.subject_user',['app_name' => config('app.name')]);
        // Check if $notifiable object has the necessary properties
        if (!isset($notifiable->email) || empty($notifiable->email)) {
            throw new \Exception('The user email is missing.');
        }

        // Attempt to send the email
        $mailMessage  = (new MailMessage)
            ->subject($subject)
            ->view('emails.user_forgot_password', [
                'user' => $notifiable,
                'resetLink'=>$resetLink
            ])
            ->cc(config('constants.mail.developer'));
        return $mailMessage;


    }

    /**
     * Get the URL for the password reset.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        // Custom URL structure pointing to the frontend app
        // Replace `frontend_app_url` with the actual URL of your React app
        $frontendAppUrl = env('FRONTEND_APP_URL', 'http://localhost:3000'); // Example fallback to local React app URL

        // Generate the reset URL pointing to the React app route for resetting password
        return $frontendAppUrl . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->getEmailForPasswordReset());
    }
}
