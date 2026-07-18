document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.contact__hero-grid, ' +
        '.contact__whatsapp-grid, ' +
        '.contact__location-grid'
    );

    if (revealElements.length > 0) {
        revealElements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                } else {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(40px)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });

        revealElements.forEach(el => observer.observe(el));
    }

});