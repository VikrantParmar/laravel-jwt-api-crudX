@extends('emails.layouts.main')

@section('title', 'Welcome to ' . config('app.name'))

@section('content')
    <h2>Hello, {{ $user->full_name }}!</h2>
    <p>Thank you for registering on our platform. We are excited to have you with us and can't wait for you to explore what {{ config('app.name') }} has to offer.</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p>If you have any questions or need further assistance, feel free to contact us at {{ config('constants.mail.support') }}.</p>
@endsection
