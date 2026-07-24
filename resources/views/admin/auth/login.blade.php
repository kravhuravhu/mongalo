<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login · {{ env('PROJECT_NAME', 'The Collective') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/admin/admin.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/admin/auth.css') }}">
</head>
<body class="auth-login">

<div class="login-container">
    <div class="login-logo">
        {{ env('PROJECT_NAME', 'The Collective') }}
        <span>Admin</span>
    </div>
    <p class="login-subtitle">Sign in to manage your content</p>

    @if($errors->any())
        <div class="login-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}" class="login-form">
        @csrf

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="••••••••" required>
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="login-btn">
            <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
    </form>

    <div class="login-footer">
        {{ env('PROJECT_NAME', 'The Collective') }} · <span>Admin</span>
    </div>
</div>

</body>
</html>