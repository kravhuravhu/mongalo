// ─── APP SCRIPTS ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── APP OVERLAY (global navigation loader) ───
    const overlayHTML =
        '<div class="app-overlay" id="appOverlay">' +
            '<div class="app-overlay__spinner">' +
                '<div class="app-overlay__ring app-overlay__ring--1"></div>' +
                '<div class="app-overlay__ring app-overlay__ring--2"></div>' +
                '<div class="app-overlay__ring app-overlay__ring--3"></div>' +
                '<span class="app-overlay__text">Loading...</span>' +
            '</div>' +
        '</div>';

    if (!document.getElementById('appOverlay')) {
        document.body.insertAdjacentHTML('beforeend', overlayHTML);
    }

    const appOverlay = document.getElementById('appOverlay');

    function showAppOverlay() {
        if (appOverlay) {
            appOverlay.classList.add('app-overlay--visible');
            document.body.style.overflow = 'hidden';
        }
    }

    function hideAppOverlay() {
        if (appOverlay) {
            appOverlay.classList.remove('app-overlay--visible');
            document.body.style.overflow = '';
        }
    }

    window.showAppOverlay = showAppOverlay;
    window.hideAppOverlay = hideAppOverlay;

    // ─── INITIAL PAGE LOAD OVERLAY ───
    showAppOverlay();

    window.addEventListener('load', function() {
        setTimeout(function() {
            hideAppOverlay();
        }, 200);
    });

    setTimeout(function() {
        if (appOverlay && appOverlay.classList.contains('app-overlay--visible')) {
            hideAppOverlay();
        }
    }, 3000);

    window.addEventListener('pageshow', function(e) {
        if (e.persisted) hideAppOverlay();
    });

    // ─── GLOBAL NAVIGATION OVERLAY ───
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[href]');
        if (!link) return;

        const href = link.getAttribute('href');
        const target = link.getAttribute('target');

        if (!href ||
            href.startsWith('#') ||
            href.startsWith('javascript:') ||
            href.startsWith('mailto:') ||
            href.startsWith('tel:') ||
            target === '_blank' ||
            link.hasAttribute('download') ||
            e.ctrlKey || e.metaKey || e.shiftKey || e.altKey ||
            e.button !== 0) {
            return;
        }

        if (href.startsWith('/') || href.startsWith(window.location.origin)) {
            showAppOverlay();
        }
    });

    window.addEventListener('beforeunload', function() {
        showAppOverlay();
    });

    // ─── GLOBAL NAVBAR SCROLL ───
    const navbar = document.getElementById('globalNavbar');

    if (navbar) {
        window.addEventListener('scroll', function() {
            const scrollY = window.scrollY;

            if (scrollY > 100) {
                navbar.classList.add('global-navbar--scrolled');
            } else {
                navbar.classList.remove('global-navbar--scrolled');
            }
        }, { passive: true });

        if (window.scrollY > 100) {
            navbar.classList.add('global-navbar--scrolled');
        }
    }

    // ─── SCROLL TO TOP ───
    const scrollBtn = document.getElementById('scrollTopBtn');
    if (scrollBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 400) {
                scrollBtn.classList.add('scroll-top--visible');
            } else {
                scrollBtn.classList.remove('scroll-top--visible');
            }
        }, { passive: true });

        scrollBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ─── MOBILE NAV TOGGLE ───
    const navToggle = document.getElementById('globalNavToggle');
    const navLeft   = document.querySelector('.global-navbar__links--left');
    const navRight  = document.querySelector('.global-navbar__links--right');

    // ─── INJECT OVERLAY (only once, only if navbar exists) ───
    let navOverlay = document.querySelector('.global-navbar__overlay');
    if (!navOverlay && navToggle && navLeft && navRight) {
        navOverlay = document.createElement('div');
        navOverlay.className = 'global-navbar__overlay';
        document.body.appendChild(navOverlay);
    }

    if (navToggle && navLeft && navRight && navOverlay) {

        function openNav() {
            navToggle.classList.add('global-navbar__toggle--open');
            navLeft.classList.add('global-navbar__links--open');
            navRight.classList.add('global-navbar__links--open');
            navOverlay.classList.add('global-navbar__overlay--visible');

            const navEl = document.querySelector('.global-navbar');
            if (navEl) navEl.classList.add('global-navbar--drawer-open');

            document.body.style.overflow = 'hidden';
            navToggle.setAttribute('aria-expanded', 'true');
        }

        function closeNav() {
            navToggle.classList.remove('global-navbar__toggle--open');
            navLeft.classList.remove('global-navbar__links--open');
            navRight.classList.remove('global-navbar__links--open');
            navOverlay.classList.remove('global-navbar__overlay--visible');

            const navEl = document.querySelector('.global-navbar');
            if (navEl) navEl.classList.remove('global-navbar--drawer-open');

            document.body.style.overflow = '';
            navToggle.setAttribute('aria-expanded', 'false');
        }

        navToggle.addEventListener('click', function() {
            const isOpen = navToggle.classList.contains('global-navbar__toggle--open');
            if (isOpen) {
                closeNav();
            } else {
                openNav();
            }
        });

        // ─── OVERLAY CLICK CLOSES ───
        navOverlay.addEventListener('click', closeNav);

        // ─── LINK CLICK CLOSES ───
        document.querySelectorAll('.global-navbar__link').forEach(function(link) {
            link.addEventListener('click', closeNav);
        });

        // ─── ESC CLOSES ───
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navToggle.classList.contains('global-navbar__toggle--open')) {
                closeNav();
            }
        });

        // ─── RESIZE BACK TO DESKTOP CLOSES ───
        let navResizeTimer = null;
        window.addEventListener('resize', function() {
            if (navResizeTimer) clearTimeout(navResizeTimer);
            navResizeTimer = setTimeout(function() {
                if (window.innerWidth > 1024 && navToggle.classList.contains('global-navbar__toggle--open')) {
                    closeNav();
                }
            }, 120);
        }, { passive: true });
    }
});