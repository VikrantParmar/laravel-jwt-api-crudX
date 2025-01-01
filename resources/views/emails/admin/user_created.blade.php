@extends('emails.layouts.main')

@section('title', 'New User Created  : ' . config('app.name'))


@section('content')
    <h2>Hello, Admin</h2>
    <p>A new user has been created on the platform.</p>
    <p><strong>Full Name:</strong> {{ $user->full_name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
@endsection



