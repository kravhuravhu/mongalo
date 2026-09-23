<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', env('PROJECT_NAME', 'IN.iN') . ' · I am IN Him // He is IN me')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700&family=EB+Garamond:ital@0;1&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/v150/app.css') }}">

    <!-- Page Specific CSS -->
    @stack('styles')
</head>
<body class="@yield('page-class', 'page-default')">

    {{-- ─── LOADING SPINNER ─── --}}
    <div class="app-loader" id="appLoader">
        <div class="app-loader__spinner">
            <div class="app-loader__ring app-loader__ring--1"></div>
            <div class="app-loader__ring app-loader__ring--2"></div>
            <div class="app-loader__ring app-loader__ring--3"></div>
            <span class="app-loader__text">IN.iN</span>
        </div>
    </div>

    {{-- ─── FLASH MESSAGES ─── --}}
    @if(session('success'))
        <div class="flash-toast flash-toast--success" id="flashToast" data-auto-dismiss="8000" role="alert">
            <div class="flash-toast__icon">
                <i class="fas fa-check" aria-hidden="true"></i>
            </div>
            <div class="flash-toast__content">
                <span class="flash-toast__title">Success</span>
                <span class="flash-toast__text">{{ session('success') }}</span>
            </div>
            <button class="flash-toast__close" onclick="closeFlashToast(this)" aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
            <span class="flash-toast__progress"></span>
        </div>
    @endif

    @if(session('error'))
        <div class="flash-toast flash-toast--error" id="flashToast" data-auto-dismiss="8000" role="alert">
            <div class="flash-toast__icon">
                <i class="fas fa-exclamation" aria-hidden="true"></i>
            </div>
            <div class="flash-toast__content">
                <span class="flash-toast__title">Error</span>
                <span class="flash-toast__text">{{ session('error') }}</span>
            </div>
            <button class="flash-toast__close" onclick="closeFlashToast(this)" aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
            <span class="flash-toast__progress"></span>
        </div>
    @endif

    @if(session('warning'))
        <div class="flash-toast flash-toast--warning" id="flashToast" data-auto-dismiss="8000" role="alert">
            <div class="flash-toast__icon">
                <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
            <div class="flash-toast__content">
                <span class="flash-toast__title">Warning</span>
                <span class="flash-toast__text">{{ session('warning') }}</span>
            </div>
            <button class="flash-toast__close" onclick="closeFlashToast(this)" aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
            <span class="flash-toast__progress"></span>
        </div>
    @endif

    @if(session('info'))
        <div class="flash-toast flash-toast--info" id="flashToast" data-auto-dismiss="8000" role="alert">
            <div class="flash-toast__icon">
                <i class="fas fa-info" aria-hidden="true"></i>
            </div>
            <div class="flash-toast__content">
                <span class="flash-toast__title">Info</span>
                <span class="flash-toast__text">{{ session('info') }}</span>
            </div>
            <button class="flash-toast__close" onclick="closeFlashToast(this)" aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
            <span class="flash-toast__progress"></span>
        </div>
    @endif

    {{-- ─── GLOBAL STICKY NAVBAR ─── --}}
    @include('components.v150.navbar')

    <!-- ─── MAIN CONTENT ─── -->
    <main>
        @yield('content')
    </main>

    <!-- ─── FOOTER ─── -->
    @include('components.v150.footer')

    <!-- ─── WHATSAPP POPUP ─── -->
    @include('components.v150.whatsapp-popup')

    <!-- ─── SCROLL TO TOP ─── -->
    @include('components.v150.scroll-top')

    <!-- ─── MAIN JS ─── -->
    <script src="{{ secure_asset('js/v150/app.js') }}"></script>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ─── HIDE LOADER ───
            const loader = document.getElementById('appLoader');
            if (loader) {
                window.addEventListener('load', function() {
                    setTimeout(function() {
                        loader.classList.add('app-loader--hidden');
                        setTimeout(function() {
                            loader.style.display = 'none';
                        }, 500);
                    }, 400);
                });

                setTimeout(function() {
                    if (!loader.classList.contains('app-loader--hidden')) {
                        loader.classList.add('app-loader--hidden');
                        setTimeout(function() {
                            loader.style.display = 'none';
                        }, 500);
                    }
                }, 4500);
            }

            // ─── FLASH TOAST ───
            const toast = document.getElementById('flashToast');

            if (toast) {
                const dismissTime = parseInt(toast.dataset.autoDismiss) || 8000;
                const progressBar = toast.querySelector('.flash-toast__progress');

                // ─── SHOW PROGRESS BAR ANIMATION ───
                if (progressBar) {
                    progressBar.style.animation = 'flashToastProgress ' + dismissTime + 'ms linear forwards';
                }

                // ─── AUTO DISMISS ───
                const autoDismiss = setTimeout(function() {
                    closeFlashToast(toast);
                }, dismissTime);

                // ─── STORE TIMER ON ELEMENT FOR MANUAL CLOSE ───
                toast._autoDismissTimer = autoDismiss;

                // ─── PAUSE ON HOVER ───
                toast.addEventListener('mouseenter', function() {
                    clearTimeout(this._autoDismissTimer);
                    if (progressBar) {
                        progressBar.style.animationPlayState = 'paused';
                    }
                });

                // ─── RESUME ON LEAVE ───
                toast.addEventListener('mouseleave', function() {
                    const remaining = 2000;
                    if (progressBar) {
                        progressBar.style.animationPlayState = 'running';
                    }
                    this._autoDismissTimer = setTimeout(function() {
                        closeFlashToast(toast);
                    }, remaining);
                });
            }

            // ─── FORM SUBMIT WITH BLUR OVERLAY ───
            document.querySelectorAll('.form-loading').forEach(function(form) {
                form.addEventListener('submit', function() {
                    // ─── PREVENT DOUBLE SUBMIT ───
                    if (form.dataset.submitting === 'true') {
                        return false;
                    }
                    form.dataset.submitting = 'true';

                    // ─── CREATE OVERLAY ───
                    const overlay = document.createElement('div');
                    overlay.className = 'form-loading-overlay';
                    overlay.innerHTML =
                        '<div class="form-loading-overlay__spinner">' +
                            '<div class="form-loading-overlay__ring"></div>' +
                            '<div class="form-loading-overlay__ring form-loading-overlay__ring--2"></div>' +
                            '<div class="form-loading-overlay__ring form-loading-overlay__ring--3"></div>' +
                        '</div>' +
                        '<span class="form-loading-overlay__text">Sending…</span>';

                    // ─── FIND THE WRAPPER TO POSITION OVERLAY ───
                    const wrapper = form.closest('.contact__hero-form-wrap, .baptism__contact-form-wrap, .event-detail__form-wrap, .invite__form-wrapper') || form.parentElement;

                    if (wrapper) {
                        // ─── ENSURE WRAPPER IS RELATIVE ───
                        const computedPosition = window.getComputedStyle(wrapper).position;
                        if (computedPosition === 'static') {
                            wrapper.style.position = 'relative';
                        }

                        wrapper.appendChild(overlay);

                        // ─── TRIGGER ANIMATION ───
                        requestAnimationFrame(function() {
                            overlay.classList.add('form-loading-overlay--visible');
                        });
                    }

                    // ─── DISABLE SUBMIT BUTTON ───
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                    }
                });
            });
        });

        // ─── FLASH TOAST CLOSE ───
        function closeFlashToast(element) {
            const toast = element.closest ? element.closest('.flash-toast') : element;

            if (!toast) return;

            if (toast._autoDismissTimer) {
                clearTimeout(toast._autoDismissTimer);
            }

            toast.classList.add('flash-toast--closing');

            setTimeout(function() {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 350);
        }
    </script>

</body>
</html>