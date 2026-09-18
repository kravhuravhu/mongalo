// ─── APP SCRIPTS ───
document.addEventListener('DOMContentLoaded', function() {

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