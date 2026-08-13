<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin · ' . env('PROJECT_NAME', 'The Collective'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/admin/admin.css') }}">
    @stack('styles')

    <!-- Chart.js -->
    @if(request()->routeIs('admin.dashboard'))
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
    @endif
</head>
<body>

{{-- ─── LOADING SPINNER ─── --}}
<div class="admin-loader" id="adminLoader">
    <div class="admin-loader__spinner">
        <div class="admin-loader__ring admin-loader__ring--1"></div>
        <div class="admin-loader__ring admin-loader__ring--2"></div>
        <div class="admin-loader__ring admin-loader__ring--3"></div>
        <span class="admin-loader__text">Loading...</span>
    </div>
</div>

{{-- ─── MAIN CONTENT ─── --}}
<div class="admin-wrapper" id="adminWrapper" style="display: none; opacity: 0;">
    {{-- Sidebar --}}
    @include('admin.components.sidebar')

    {{-- Main Content --}}
    <div class="admin-content">
        {{-- Top Bar --}}
        @include('admin.components.topbar')

        {{-- Page Content --}}
        <main>
            @yield('content')
        </main>
    </div>
</div>

{{-- ─── SCRIPTS ─── --}}
<script src="{{ secure_asset('js/admin.js') }}" defer></script>
@stack('scripts')

{{-- ─── FLASH MESSAGES ─── --}}
@if(session('success'))
    <div class="flash-message flash-message--success" id="flashMessage">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button class="flash-message__close" onclick="this.parentElement.remove()">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="flash-message flash-message--error" id="flashMessage">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button class="flash-message__close" onclick="this.parentElement.remove()">&times;</button>
    </div>
@endif

{{-- ─── CHANGE PASSWORD MODAL ─── --}}
<div class="password-modal-overlay" id="passwordModalOverlay" style="display: none;">
    <div class="password-modal">
        <div class="password-modal__header">
            <h3 class="password-modal__title">
                <i class="fas fa-key" style="color: var(--gold);"></i>
                Change Password
            </h3>
            <button class="password-modal__close" id="passwordModalClose">&times;</button>
        </div>

        <form id="passwordChangeForm">
            @csrf

            <div class="password-modal__body">
                <div class="password-modal__group">
                    <label for="current_password">Current Password <span class="required">*</span></label>
                    <input type="password" name="current_password" id="current_password" placeholder="Enter current password" required autocomplete="current-password">
                    <span class="password-modal__error" id="current_password_error"></span>
                </div>

                <div class="password-modal__group">
                    <label for="new_password">New Password <span class="required">*</span></label>
                    <input type="password" name="new_password" id="new_password" placeholder="Enter new password (min 8 characters)" required autocomplete="new-password">
                    <span class="password-modal__error" id="new_password_error"></span>
                    <span class="password-modal__help">Minimum 8 characters</span>
                </div>

                <div class="password-modal__group">
                    <label for="new_password_confirmation">Confirm New Password <span class="required">*</span></label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm new password" required autocomplete="new-password">
                    <span class="password-modal__error" id="new_password_confirmation_error"></span>
                </div>

                <div id="passwordModalMessage"></div>
            </div>

            <div class="password-modal__footer">
                <button type="button" class="btn btn--secondary" id="passwordModalCancel">Cancel</button>
                <button type="submit" class="btn btn--primary" id="passwordModalSubmit">
                    <span id="passwordBtnText"><i class="fas fa-save"></i> Change Password</span>
                    <span id="passwordBtnLoader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Updating...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* ─── PASSWORD MODAL ─── */
    .password-modal-overlay {
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
        animation: modalFadeIn 0.35s ease forwards;
    }

    .password-modal-overlay--visible {
        opacity: 1;
    }

    .password-modal {
        background: var(--surface);
        border-radius: 20px;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.2);
        transform: scale(0.92) translateY(20px);
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: modalSlideUp 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        overflow: hidden;
    }

    .password-modal__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 28px;
        border-bottom: 1px solid var(--border);
        background: var(--bg);
    }

    .password-modal__title {
        font-family: var(--font-serif);
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .password-modal__close {
        background: none;
        border: none;
        font-size: 1.4rem;
        color: var(--text-muted);
        cursor: pointer;
        padding: 4px 8px;
        transition: all 0.3s ease;
        line-height: 1;
    }

    .password-modal__close:hover {
        color: var(--text);
        transform: rotate(90deg);
    }

    .password-modal__body {
        padding: 28px 28px 20px;
    }

    .password-modal__group {
        margin-bottom: 18px;
    }

    .password-modal__group label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text);
        margin-bottom: 4px;
    }

    .password-modal__group label .required {
        color: #dc3545;
        margin-left: 2px;
    }

    .password-modal__group input {
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

    .password-modal__group input:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px var(--gold-dim);
    }

    .password-modal__group input.error {
        border-color: #dc3545;
    }

    .password-modal__group input.error:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
    }

    .password-modal__error {
        display: block;
        font-size: 0.75rem;
        color: #dc3545;
        margin-top: 4px;
        min-height: 20px;
    }

    .password-modal__help {
        display: block;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .password-modal__footer {
        display: flex;
        gap: 12px;
        padding: 16px 28px 28px;
        border-top: 1px solid var(--border);
        background: var(--bg);
    }

    .password-modal__footer .btn {
        flex: 1;
        justify-content: center;
        padding: 12px 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    #passwordModalMessage {
        margin-top: 8px;
    }

    .password-modal__success {
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

    .password-modal__error-msg {
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
        .password-modal {
            border-radius: 16px;
        }

        .password-modal__header {
            padding: 16px 20px;
        }

        .password-modal__body {
            padding: 20px 20px 16px;
        }

        .password-modal__footer {
            padding: 12px 20px 20px;
            flex-direction: column;
        }

        .password-modal__footer .btn {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── CHANGE PASSWORD MODAL ───
        const passwordLink = document.getElementById('changePasswordLink');
        const passwordModal = document.getElementById('passwordModalOverlay');
        const passwordClose = document.getElementById('passwordModalClose');
        const passwordCancel = document.getElementById('passwordModalCancel');
        const passwordForm = document.getElementById('passwordChangeForm');
        const passwordSubmit = document.getElementById('passwordModalSubmit');
        const passwordBtnText = document.getElementById('passwordBtnText');
        const passwordBtnLoader = document.getElementById('passwordBtnLoader');
        const passwordMessage = document.getElementById('passwordModalMessage');

        // ─── SHOW MODAL ───
        if (passwordLink) {
            passwordLink.addEventListener('click', function(e) {
                e.preventDefault();
                passwordModal.style.display = 'flex';
                setTimeout(function() {
                    passwordModal.classList.add('password-modal-overlay--visible');
                }, 10);
                // ─── CLEAR FORM ───
                passwordForm.reset();
                passwordMessage.innerHTML = '';
                document.querySelectorAll('.password-modal__group input').forEach(function(input) {
                    input.classList.remove('error');
                });
                document.querySelectorAll('.password-modal__error').forEach(function(el) {
                    el.textContent = '';
                });
                passwordSubmit.disabled = false;
                passwordBtnText.style.display = 'inline';
                passwordBtnLoader.style.display = 'none';
            });
        }

        // ─── CLOSE MODAL ───
        function closePasswordModal() {
            passwordModal.classList.remove('password-modal-overlay--visible');
            setTimeout(function() {
                passwordModal.style.display = 'none';
            }, 400);
        }

        if (passwordClose) {
            passwordClose.addEventListener('click', closePasswordModal);
        }

        if (passwordCancel) {
            passwordCancel.addEventListener('click', closePasswordModal);
        }

        passwordModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closePasswordModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && passwordModal.style.display === 'flex') {
                closePasswordModal();
            }
        });

        // ─── SUBMIT FORM ───
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // ─── CLEAR PREVIOUS ERRORS ───
                document.querySelectorAll('.password-modal__group input').forEach(function(input) {
                    input.classList.remove('error');
                });
                document.querySelectorAll('.password-modal__error').forEach(function(el) {
                    el.textContent = '';
                });
                passwordMessage.innerHTML = '';

                // ─── SHOW LOADING ───
                passwordSubmit.disabled = true;
                passwordBtnText.style.display = 'none';
                passwordBtnLoader.style.display = 'inline';

                const formData = new FormData(this);

                fetch('{{ route("admin.change-password") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        // ─── SHOW SUCCESS ───
                        passwordMessage.innerHTML = `
                            <div class="password-modal__success">
                                <i class="fas fa-check-circle"></i>
                                ${data.message}
                            </div>
                        `;

                        // ─── RESET FORM ───
                        passwordForm.reset();

                        // ─── REDIRECT TO LOGIN IF LOGOUT REQUIRED ───
                        if (data.logout) {
                            setTimeout(function() {
                                window.location.href = '{{ route("admin.login") }}';
                            }, 1500);
                        } else {
                            setTimeout(function() {
                                closePasswordModal();
                            }, 2000);
                        }
                    } else {
                        // ─── SHOW ERROR ───
                        if (data.errors) {
                            for (const [field, messages] of Object.entries(data.errors)) {
                                const errorEl = document.getElementById(field + '_error');
                                const inputEl = document.getElementById(field);
                                if (errorEl) {
                                    errorEl.textContent = messages[0];
                                }
                                if (inputEl) {
                                    inputEl.classList.add('error');
                                }
                            }
                        } else {
                            passwordMessage.innerHTML = `
                                <div class="password-modal__error-msg">
                                    <i class="fas fa-exclamation-circle"></i>
                                    ${data.message || 'Something went wrong. Please try again.'}
                                </div>
                            `;
                        }

                        // ─── RESET BUTTON ───
                        passwordSubmit.disabled = false;
                        passwordBtnText.style.display = 'inline';
                        passwordBtnLoader.style.display = 'none';
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    passwordMessage.innerHTML = `
                        <div class="password-modal__error-msg">
                            <i class="fas fa-exclamation-circle"></i>
                            An error occurred. Please try again.
                        </div>
                    `;
                    passwordSubmit.disabled = false;
                    passwordBtnText.style.display = 'inline';
                    passwordBtnLoader.style.display = 'none';
                });
            });
        }

        // ─── CLEAR ERROR ON INPUT ───
        document.querySelectorAll('.password-modal__group input').forEach(function(input) {
            input.addEventListener('input', function() {
                this.classList.remove('error');
                const errorEl = document.getElementById(this.id + '_error');
                if (errorEl) {
                    errorEl.textContent = '';
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── HIDE LOADER ───
        const loader = document.getElementById('adminLoader');
        const wrapper = document.getElementById('adminWrapper');

        if (loader && wrapper) {
            // Show wrapper with fade in
            wrapper.style.display = 'flex';
            
            // Wait for all resources to load (images, fonts, etc)
            window.addEventListener('load', function() {
                // Fade in wrapper
                wrapper.style.transition = 'opacity 0.4s ease';
                wrapper.style.opacity = '1';
                
                // Hide loader with animation
                setTimeout(function() {
                    loader.classList.add('admin-loader--hidden');
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 500);
                }, 400);
            });

            // Fallback
            setTimeout(function() {
                if (!loader.classList.contains('admin-loader--hidden')) {
                    wrapper.style.transition = 'opacity 0.4s ease';
                    wrapper.style.opacity = '1';
                    loader.classList.add('admin-loader--hidden');
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 500);
                }
            }, 3000);
        }

        // ─── FLASH MESSAGES ───
        const flash = document.getElementById('flashMessage');
        if (flash) {
            setTimeout(function() {
                flash.classList.add('flash-message--fade-out');
                setTimeout(function() {
                    flash.remove();
                }, 400);
            }, 5000);
        }

        // ─── REAL-TIME SEARCH ───
        const searchInput = document.getElementById('adminSearchInput');
        const searchResults = document.getElementById('adminSearchResults');
        const searchSpinner = document.getElementById('adminSearchSpinner');
        const clearBtn = document.getElementById('adminSearchClear');

        if (searchInput && searchResults) {
            let searchTimeout = null;
            let currentQuery = searchInput.value.trim();

            // ─── PERFORM SEARCH ───
            function performSearch(query) {
                const url = new URL(window.location.href);
                const filter = url.searchParams.get('filter') || '';

                let searchUrl = window.location.pathname + '?';
                if (filter) {
                    searchUrl += 'filter=' + filter + '&';
                }
                if (query) {
                    searchUrl += 'search=' + encodeURIComponent(query);
                }

                // Show spinner
                if (searchSpinner) {
                    searchSpinner.style.display = 'inline-block';
                }

                fetch(searchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function(data) {
                    if (data.html) {
                        searchResults.innerHTML = data.html;
                    }

                    if (data.total !== undefined) {
                        const countEl = document.querySelector('.books-index__filter-count');
                        if (countEl) {
                            countEl.textContent = data.total + ' books';
                        }
                    }

                    // Show/hide clear button
                    if (clearBtn) {
                        if (query.length > 0) {
                            clearBtn.style.display = 'inline-flex';
                        } else {
                            clearBtn.style.display = 'none';
                        }
                    }

                    if (searchSpinner) {
                        searchSpinner.style.display = 'none';
                    }
                })
                .catch(function(error) {
                    console.error('Search error:', error);
                    if (searchSpinner) {
                        searchSpinner.style.display = 'none';
                    }
                });
            }

            // ─── SEARCH INPUT HANDLER ───
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 400);
            });

            // ─── CLEAR SEARCH ───
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    searchInput.value = '';
                    searchInput.focus();
                    performSearch('');
                });
            }

            // ─── KEYBOARD SHORTCUTS ───
            document.addEventListener('keydown', function(e) {
                // Ctrl + / to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                    e.preventDefault();
                    searchInput.focus();
                    searchInput.select();
                }

                // Escape to clear search
                if (e.key === 'Escape') {
                    if (document.activeElement === searchInput) {
                        searchInput.value = '';
                        searchInput.blur();
                        performSearch('');
                    }
                }
            });

            // ─── INITIAL STATE ───
            if (searchInput.value.trim().length > 0 && clearBtn) {
                clearBtn.style.display = 'inline-flex';
            }
        }

        // ─── FORM SUBMIT WITH LOADING ───
        document.querySelectorAll('.form-loading').forEach(function(form) {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

                    setTimeout(function() {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 30000);
                }
            });
        });
    });
</script>

</body>
</html>