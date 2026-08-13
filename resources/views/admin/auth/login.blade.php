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

{{-- Loading Spinner --}}
<div class="admin-loader" id="adminLoader">
    <div class="admin-loader__spinner">
        <div class="admin-loader__ring"></div>
        <div class="admin-loader__ring admin-loader__ring--2"></div>
        <div class="admin-loader__ring admin-loader__ring--3"></div>
        <span class="admin-loader__text">Loading...</span>
    </div>
</div>

<div class="login-container" id="loginContainer" style="display: none;">
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

    <form method="POST" action="{{ route('admin.login') }}" class="login-form form-loading">
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

        <div class="form-group">
            <div style="display: flex; justify-content: flex-end;">
                <a href="#" class="forgot-password-link" id="forgotPasswordLink">
                    Forgot Password?
                </a>
            </div>
        </div>

        <button type="submit" class="login-btn">
            <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
    </form>

    <div class="login-footer">
        {{ env('PROJECT_NAME', 'The Collective') }} · <span>Admin</span>
    </div>
</div>

{{-- ─── FORGOT PASSWORD MODAL ─── --}}
<div class="forgot-password-modal-overlay" id="forgotPasswordModal" style="display: none;">
    <div class="forgot-password-modal">
        <div class="forgot-password-modal__header">
            <h3 class="forgot-password-modal__title">
                <i class="fas fa-key" style="color: var(--gold);"></i>
                Reset Password
            </h3>
            <button class="forgot-password-modal__close" id="forgotPasswordClose">&times;</button>
        </div>

        <div class="forgot-password-modal__body">
            <p class="forgot-password-modal__text">
                Enter your email address and we'll send you instructions to reset your password.
            </p>

            <form id="forgotPasswordForm">
                @csrf
                <div class="forgot-password-modal__group">
                    <label for="reset_email">Email Address <span class="required">*</span></label>
                    <input type="email" name="email" id="reset_email" placeholder="admin@example.com" required>
                    <span class="forgot-password-modal__error" id="reset_email_error"></span>
                </div>

                <div id="forgotPasswordMessage"></div>

                <div class="forgot-password-modal__actions">
                    <button type="button" class="btn btn--secondary" id="forgotPasswordCancel">Cancel</button>
                    <button type="submit" class="btn btn--primary" id="forgotPasswordSubmit">
                        <span id="forgotPasswordBtnText"><i class="fas fa-paper-plane"></i> Send Reset Link</span>
                        <span id="forgotPasswordBtnLoader" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sending...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .forgot-password-link {
        font-size: 0.8rem;
        color: var(--gold);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .forgot-password-link:hover {
        color: var(--gold-light);
        text-decoration: underline;
    }

    .forgot-password-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        opacity: 0;
        transition: opacity 0.35s ease;
    }

    .forgot-password-modal-overlay--visible {
        opacity: 1;
    }

    .forgot-password-modal {
        background: var(--surface);
        border-radius: 20px;
        max-width: 440px;
        width: 100%;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.2);
        transform: scale(0.92) translateY(20px);
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow: hidden;
    }

    .forgot-password-modal--visible {
        transform: scale(1) translateY(0);
    }

    .forgot-password-modal__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 28px;
        border-bottom: 1px solid var(--border);
        background: var(--bg);
    }

    .forgot-password-modal__title {
        font-family: var(--font-serif);
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .forgot-password-modal__close {
        background: none;
        border: none;
        font-size: 1.4rem;
        color: var(--text-muted);
        cursor: pointer;
        padding: 4px 8px;
        transition: all 0.3s ease;
        line-height: 1;
    }

    .forgot-password-modal__close:hover {
        color: var(--text);
        transform: rotate(90deg);
    }

    .forgot-password-modal__body {
        padding: 28px 28px 20px;
    }

    .forgot-password-modal__text {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .forgot-password-modal__group {
        margin-bottom: 18px;
    }

    .forgot-password-modal__group label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text);
        margin-bottom: 4px;
    }

    .forgot-password-modal__group label .required {
        color: #dc3545;
        margin-left: 2px;
    }

    .forgot-password-modal__group input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        font-family: var(--font);
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: var(--surface);
        color: var(--text);
    }

    .forgot-password-modal__group input:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px var(--gold-dim);
    }

    .forgot-password-modal__error {
        display: block;
        font-size: 0.75rem;
        color: #dc3545;
        margin-top: 4px;
        min-height: 20px;
    }

    .forgot-password-modal__actions {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }

    .forgot-password-modal__actions .btn {
        flex: 1;
        justify-content: center;
        padding: 12px 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    #forgotPasswordMessage {
        margin-top: 8px;
    }

    .forgot-password-modal__success {
        background: #d4edda;
        color: #155724;
        padding: 12px 16px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        border-left: 4px solid #28a745;
    }

    .forgot-password-modal__error-msg {
        background: #f8d7da;
        color: #721c24;
        padding: 12px 16px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        border-left: 4px solid #dc3545;
    }

    @media (max-width: 540px) {
        .forgot-password-modal {
            border-radius: 16px;
        }

        .forgot-password-modal__header {
            padding: 16px 20px;
        }

        .forgot-password-modal__body {
            padding: 20px 20px 16px;
        }

        .forgot-password-modal__actions {
            flex-direction: column;
        }

        .forgot-password-modal__actions .btn {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── HIDE LOADER ON PAGE LOAD ───
        const loader = document.getElementById('adminLoader');
        const container = document.getElementById('loginContainer');

        if (loader && container) {
            // Show container
            container.style.display = 'block';

            // Hide loader with animation
            setTimeout(function() {
                loader.classList.add('admin-loader--hidden');
                setTimeout(function() {
                    loader.style.display = 'none';
                }, 400);
            }, 300);
        }

        // ─── FORM LOADING STATE ───
        document.querySelectorAll('.form-loading').forEach(function(form) {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing in...';
                }
            });
        });

        // ─── FORGOT PASSWORD MODAL ───
        const forgotPasswordLink = document.getElementById('forgotPasswordLink');
        const forgotModal = document.getElementById('forgotPasswordModal');
        const forgotClose = document.getElementById('forgotPasswordClose');
        const forgotCancel = document.getElementById('forgotPasswordCancel');
        const forgotForm = document.getElementById('forgotPasswordForm');

        if (forgotPasswordLink) {
            forgotPasswordLink.addEventListener('click', function(e) {
                e.preventDefault();
                forgotModal.style.display = 'flex';
                setTimeout(function() {
                    forgotModal.classList.add('forgot-password-modal-overlay--visible');
                    const modal = document.querySelector('.forgot-password-modal');
                    if (modal) {
                        modal.classList.add('forgot-password-modal--visible');
                    }
                }, 10);
                forgotForm.reset();
                document.getElementById('forgotPasswordMessage').innerHTML = '';
            });
        }

        function closeForgotModal() {
            forgotModal.classList.remove('forgot-password-modal-overlay--visible');
            const modal = document.querySelector('.forgot-password-modal');
            if (modal) {
                modal.classList.remove('forgot-password-modal--visible');
            }
            setTimeout(function() {
                forgotModal.style.display = 'none';
            }, 400);
        }

        if (forgotClose) forgotClose.addEventListener('click', closeForgotModal);
        if (forgotCancel) forgotCancel.addEventListener('click', closeForgotModal);

        forgotModal.addEventListener('click', function(e) {
            if (e.target === this) closeForgotModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && forgotModal.style.display === 'flex') {
                closeForgotModal();
            }
        });

        if (forgotForm) {
            forgotForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = document.getElementById('forgotPasswordSubmit');
                const btnText = document.getElementById('forgotPasswordBtnText');
                const btnLoader = document.getElementById('forgotPasswordBtnLoader');
                const messageDiv = document.getElementById('forgotPasswordMessage');
                const emailInput = document.getElementById('reset_email');
                
                submitBtn.disabled = true;
                btnText.style.display = 'none';
                btnLoader.style.display = 'inline';
                messageDiv.innerHTML = '';
                
                const formData = new FormData(this);
                
                fetch('{{ route("admin.forgot-password") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success) {
                        messageDiv.innerHTML = `
                            <div class="forgot-password-modal__success">
                                <i class="fas fa-check-circle"></i>
                                ${data.message}
                            </div>
                        `;
                        setTimeout(closeForgotModal, 3000);
                    } else {
                        if (data.errors && data.errors.email) {
                            document.getElementById('reset_email_error').textContent = data.errors.email[0];
                            emailInput.classList.add('error');
                        } else {
                            messageDiv.innerHTML = `
                                <div class="forgot-password-modal__error-msg">
                                    <i class="fas fa-exclamation-circle"></i>
                                    ${data.message || 'Something went wrong. Please try again.'}
                                </div>
                            `;
                        }
                    }
                    submitBtn.disabled = false;
                    btnText.style.display = 'inline';
                    btnLoader.style.display = 'none';
                })
                .catch(function(error) {
                    messageDiv.innerHTML = `
                        <div class="forgot-password-modal__error-msg">
                            <i class="fas fa-exclamation-circle"></i>
                            An error occurred. Please try again.
                        </div>
                    `;
                    submitBtn.disabled = false;
                    btnText.style.display = 'inline';
                    btnLoader.style.display = 'none';
                });
            });
        }
    });
</script>

</body>
</html>