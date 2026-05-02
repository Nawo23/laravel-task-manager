@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container-sm">

    <div class="auth-header">
        <h1>Create account</h1>
        <p>Start managing your tasks today</p>
    </div>

    <div class="card">

        @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Jane Doe"
                    required
                    autofocus
                >
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    required
                >
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="At least 8 characters"
                    required
                >
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Repeat your password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:0.75rem;">
                Create account
            </button>
        </form>
    </div>

    <p class="auth-footer">
        Already have an account? <a href="{{ route('login') }}">Sign in →</a>
    </p>

</div>
@endsection
