@extends('layouts.app')

@section('content')

<h1>Create an Account</h1>

<div class="form-container">

    @if ($errors->any())
        <p style="background:#ffdddd; padding:10px; border-left:4px solid #d32f2f;">
            {{ $errors->first() }}
        </p>
    @endif

    {{-- Registration form
         DB column: name → Assignment meaning: username
    --}}
    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <label for="name">Username</label>
        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
            minlength="3"
            maxlength="255"
        >

        <label for="email">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
        >

        <label for="password">Password</label>
        <input
            id="password"
            type="password"
            name="password"
            required
            minlength="8"
        >

        <label for="password_confirmation">Confirm Password</label>
        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            required
            minlength="8"
        >

        <button type="submit">Register</button>
    </form>

</div>

@endsection
