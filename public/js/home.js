document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.home__pillars-card, ' +
        '.home__books-card, ' +
        '.home__resources-item, ' +
        '.home__events-card, ' +
        '.home__quotes-item, ' +
        '.home__featured-container'
    );

    if (revealElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });

        revealElements.forEach(el => observer.observe(el));
    }

    // ─── STATS COUNTER ───
    const stats = document.querySelectorAll('.home__stats-number');
    
    if (stats.length > 0) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-count'));
                    const duration = 2000;
                    const startTime = performance.now();

                    function updateCounter(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const value = Math.floor(progress * target);
                        el.textContent = value + (target > 100 ? '+' : '');

                        if (progress < 1) {
                            requestAnimationFrame(updateCounter);
                        } else {
                            el.textContent = target + (target > 100 ? '+' : '');
                        }
                    }

                    requestAnimationFrame(updateCounter);
                    statsObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        stats.forEach(el => statsObserver.observe(el));
    }

});