@extends('emails.layouts.main')

@section('title', 'Password Reset Request : ' . config('app.name'))


@section('content')
    <h2>Hello, {{ $user->full_name}}!</h2>
    <p>We received a request to reset your password.</p>
    <p>Please click the button below to reset your password:</p>
    <a href="{{ $resetLink }}" class="email-button">Reset Password</a>
    <hr/>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>If you have any questions or need further assistance, feel free to contact us at {{config('constants.mail.support')}}.</p>
@endsection

