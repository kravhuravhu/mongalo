// ─── ABOUT ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.about__mission-item, ' +
        '.about__values-card, ' +
        '.about__story-card, ' +
        '.about__arthur-card, ' +
        '.about__stats-item'
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

        revealElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    // ─── STATS COUNTER ───
    const stats = document.querySelectorAll('.about__stats-number');
    
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