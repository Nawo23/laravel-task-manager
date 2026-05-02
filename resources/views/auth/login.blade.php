@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="container-sm">

    <div class="auth-header">
        <h1>Welcome back</h1>
        <p>Sign in to manage your tasks</p>
    </div>

    <div class="card">

        @if (session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    required
                    autofocus
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
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="display:flex; align-items:center; gap:0.5rem;">
                <input type="checkbox" id="remember" name="remember" style="width:auto; accent-color: var(--accent);">
                <label for="remember" style="margin:0; text-transform:none; font-size:0.9rem; color:var(--text-muted);">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:0.75rem;">
                Sign in
            </button>
        </form>
    </div>

    <p class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}">Create one →</a>
    </p>

</div>
@endsection
