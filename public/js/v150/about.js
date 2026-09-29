// ─── ABOUT PAGE ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── HERO PARTICLES ───
    const particlesContainer = document.getElementById('aboutHeroParticles');

    if (particlesContainer) {
        const particleCount = 30;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('span');
            const size = Math.random() * 3 + 1.5;

            particle.style.position = 'absolute';
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.background = 'rgba(184, 146, 106, 0.4)';
            particle.style.borderRadius = '50%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animation = 'particleFloat ' + (Math.random() * 20 + 15) + 's ease-in-out infinite';
            particle.style.animationDelay = Math.random() * 10 + 's';
            particle.style.pointerEvents = 'none';

            particlesContainer.appendChild(particle);
        }
    }

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.about__story-content, .about__story-visual, .about__timeline-list, .about__top10-grid, .about__mv-grid, .about__values-grid, .about__cta-content'
    );

    if (revealElements.length > 0) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -60px 0px'
        });

        revealElements.forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = 'opacity 1s cubic-bezier(0.34, 1.56, 0.64, 1), transform 1s cubic-bezier(0.34, 1.56, 0.64, 1)';
            observer.observe(el);
        });
    }

    // ─── MOBILE BREAKPOINT HELPER ───
    const mobileQuery = window.matchMedia('(max-width: 820px)');

    // ─── VALUES STAGGER REVEAL (MOBILE ONLY) ───
    const valueCards = document.querySelectorAll('.about__values-card[data-about-value]');

    if (valueCards.length > 0 && 'IntersectionObserver' in window) {
        const valueObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const index = Array.prototype.indexOf.call(valueCards, el);
                    const delay = (index % 6) * 70;

                    setTimeout(function() {
                        el.classList.add('about__values-card--visible');
                    }, delay);

                    valueObserver.unobserve(el);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -40px 0px'
        });

        // ─── Only reveal on mobile; on desktop the cards keep their hover behaviour ───
        const attachValueObserver = function() {
            if (mobileQuery.matches) {
                valueCards.forEach(function(el) {
                    valueObserver.observe(el);
                });
            } else {
                valueCards.forEach(function(el) {
                    el.classList.add('about__values-card--visible');
                    valueObserver.unobserve(el);
                });
            }
        };

        attachValueObserver();

        mobileQuery.addEventListener('change', function() {
            valueCards.forEach(function(el) {
                el.classList.remove('about__values-card--visible');
            });
            attachValueObserver();
        });
    }
});