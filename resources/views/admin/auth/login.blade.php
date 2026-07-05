@extends('admin.layouts.admin')

@section('content')
<div class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <span>The <span>Collective</span></span>
            <small>Admin</small>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Sign In</button>
        </form>
    </div>
</div>

<style>
.login-page {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: var(--bg);
}
.login-box {
    background: #fff;
    padding: 40px 36px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    width: 100%;
    max-width: 400px;
    box-shadow: var(--shadow);
}
.login-logo {
    text-align: center;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    font-size: 1.6rem;
    margin-bottom: 28px;
}
.login-logo span {
    color: var(--gold);
}
.login-logo small {
    display: block;
    font-family: var(--font);
    font-weight: 400;
    font-size: 0.8rem;
    color: var(--text-muted);
}
.alert-error {
    background: #f8d7da;
    color: #721c24;
    padding: 12px 16px;
    border-radius: var(--radius-sm);
    margin-bottom: 16px;
    font-size: 0.9rem;
}
</style>
@endsection