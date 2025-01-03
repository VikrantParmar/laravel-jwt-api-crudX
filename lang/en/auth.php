<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'login_title' => 'Login to Account',
    'form' => [
        'lbl_email' => 'Email address',
        'lbl_password' => 'Password',

        'ph_email' => 'Enter Email Address',
        'ph_password' => 'Enter Password',

        'lbl_current_password' => 'Current Password',
        'lbl_new_password' => 'New Password',
        'lbl_password_confirmation'=>'Confirm Password',

        "lbl_first_name"=> "First Name",
        "lbl_last_name"=> "Last Name",
        "lbl_phone_number" => "Phone Number"
    ],
    'forgot_password_question' =>'Forgot Password?',

    'reset' => 'Your password has been reset!',
    'sent' => 'We have emailed your password reset link!',
    'throttled' => 'Please wait before retrying.',
    'token' => 'This password reset token is invalid.',
    'user' => "We can't find a user with that email address.",
    'msg' => [
    'login_success'=> 'Login Successfully',
    'register_success'=> 'Thank you for registering! You can now log in to your account.',
    'too_many_attempts' => 'Too many login attempts. Please try again in :seconds seconds.',
    'invalid_credentials' => 'Invalid credentials',
    'account_not_active' => 'Your account is not active. Please contact us.',
    'fp_send_reset_link_error' => 'Failed to send reset link',
    'fp_send_reset_link_success' => 'A password reset link has been successfully sent to your registered email address.\n Please check your inbox and follow the instructions to reset your password.\n If you do not receive the email within a few minutes, kindly check your spam or junk folder.\n If you encounter any issues, feel free to contact our support team for further assistance.',
    'password_reset_success' => 'Your password has been reset successfully.',
    'password_reset_error' => 'The reset token is invalid or expired.',
    'token_refreshed_successfully' => 'The token has been refreshed successfully.',
    'token_refresh_error' => 'Unable to refresh the token. Please try again',
    'profile_update_success'=> 'Your profile has been updated.',
    'password_update_success' => 'Your password has been updated successfully.',
    'current_password_invalid'=>'Your current password is incorrect',
]
];
