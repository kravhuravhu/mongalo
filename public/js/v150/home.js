// ─── HOME PAGE ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── HERO PARTICLES ───
    const particlesContainer = document.getElementById('heroParticles');

    if (particlesContainer) {
        const particleCount = 40;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('span');
            const size = Math.random() * 3 + 1.5;

            particle.style.position = 'absolute';
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.background = 'rgba(184, 146, 106, 0.5)';
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
        '.home__vision-content, .home__pillars-grid, .home__pillars-strip, .home__arthur-content'
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
            rootMargin: '0px 0px -50px 0px'
        });

        revealElements.forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.9s cubic-bezier(0.34, 1.56, 0.64, 1), transform 0.9s cubic-bezier(0.34, 1.56, 0.64, 1)';
            observer.observe(el);
        });
    }
});