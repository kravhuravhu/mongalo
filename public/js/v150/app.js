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

    // Inject overlay into body (hidden by default)
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

    // Expose globally so inline handlers and forms can call it
    window.showAppOverlay = showAppOverlay;
    window.hideAppOverlay = hideAppOverlay;

    // ─── INITIAL PAGE LOAD OVERLAY ───
    // Show overlay immediately on every page load, then fade it out once
    // the page is ready. The very first load is already covered by the
    // branded `.app-loader` (from the layout) — this overlay only becomes
    // visible on subsequent internal navigations, and hides cleanly after
    // the current page finishes loading.
    showAppOverlay();

    window.addEventListener('load', function() {
        setTimeout(function() {
            hideAppOverlay();
        }, 200);
    });

    // Safety — never leave overlay stuck
    setTimeout(function() {
        if (appOverlay && appOverlay.classList.contains('app-overlay--visible')) {
            hideAppOverlay();
        }
    }, 3000);

    // If user comes back via bfcache (browser back/forward), hide overlay
    window.addEventListener('pageshow', function(e) {
        if (e.persisted) hideAppOverlay();
    });

    // ─── GLOBAL NAVIGATION OVERLAY ───
    // Intercept any internal link click and show the overlay while the
    // next page loads.
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[href]');
        if (!link) return;

        const href = link.getAttribute('href');
        const target = link.getAttribute('target');

        // Skip conditions
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

        // Only show overlay for same-origin navigation
        if (href.startsWith('/') || href.startsWith(window.location.origin)) {
            showAppOverlay();
        }
    });

    // ─── BACK/FORWARD NAVIGATION ───
    window.addEventListener('beforeunload', function() {
        showAppOverlay();
    });

    // ─── GLOBAL NAVBAR SCROLL ───
    const navbar = document.getElementById('globalNavbar');
    const isHeroPage = document.querySelector('.home__hero');

    if (navbar) {
        window.addEventListener('scroll', function() {
            const scrollY = window.scrollY;

            if (scrollY > 100) {
                navbar.classList.add('global-navbar--scrolled');
            } else {
                navbar.classList.remove('global-navbar--scrolled');
            }
        }, { passive: true });

        // ─── INITIAL STATE ───
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
});