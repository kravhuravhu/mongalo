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

    // ─── CTA COMING-SOON MODAL ───
    const ctaModal = document.getElementById('ctaModal');
    if (ctaModal) {
        const ctaLabel = document.getElementById('ctaModalLabel');
        const ctaNoun = document.getElementById('ctaModalNoun');
        function openCtaModal(link) {
            ctaLabel.textContent = link.dataset.ctaLabel || 'there';
            ctaNoun.textContent = link.dataset.ctaNoun || 'page';
            ctaModal.classList.add('cta-modal--open');
            ctaModal.setAttribute('aria-hidden', 'false');
        }

        function closeCtaModal() {
            ctaModal.classList.remove('cta-modal--open');
            ctaModal.setAttribute('aria-hidden', 'true');
        }

        document.addEventListener('click', function(e) {
            const link = e.target.closest('[data-cta-missing]');
            if (!link) return;
            e.preventDefault();
            e.stopPropagation();
            openCtaModal(link);
        }, true);

        document.getElementById('ctaModalClose').addEventListener('click', closeCtaModal);
        document.getElementById('ctaModalOk').addEventListener('click', closeCtaModal);
        ctaModal.addEventListener('click', function(e) {
            if (e.target === ctaModal) closeCtaModal();
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeCtaModal();
        });
    }
});