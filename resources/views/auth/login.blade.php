@extends('layouts.app')

@section('content')

<h1>Login</h1>

<div class="form-container">

    @if ($errors->any())
        <p style="background:#ffdddd; padding:10px; border-left:4px solid #d32f2f;">
            {{ $errors->first() }}
        </p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            value="{{ old('email') }}" 
            required
        >

        <label for="password">Password</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required
        >

        <button type="submit">Login</button>
    </form>

</div>

@endsection
