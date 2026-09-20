document.addEventListener('DOMContentLoaded', function() {

    // ─── HERO PARTICLES ───
    const heroCanvas = document.getElementById('inviteHeroCanvas');

    if (heroCanvas) {
        const ctx = heroCanvas.getContext('2d');
        let width = heroCanvas.width = heroCanvas.offsetWidth;
        let height = heroCanvas.height = heroCanvas.offsetHeight;

        function resizeCanvas() {
            width = heroCanvas.width = heroCanvas.offsetWidth;
            height = heroCanvas.height = heroCanvas.offsetHeight;
        }
        window.addEventListener('resize', resizeCanvas);

        const particles = [];
        const particleCount = 35;

        function randomBetween(min, max) {
            return Math.random() * (max - min) + min;
        }

        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: randomBetween(0, width),
                y: randomBetween(0, height),
                radius: randomBetween(1.5, 3.5),
                speedY: randomBetween(-0.4, -0.15),
                speedX: randomBetween(-0.15, 0.15),
                opacity: randomBetween(0.2, 0.5),
                wobble: randomBetween(0, Math.PI * 2),
                wobbleSpeed: randomBetween(0.01, 0.025),
            });
        }

        function animate() {
            ctx.clearRect(0, 0, width, height);

            particles.forEach(function(p) {
                p.y += p.speedY;
                p.x += p.speedX;
                p.wobble += p.wobbleSpeed;
                p.x += Math.sin(p.wobble) * 0.3;

                if (p.y < -20) {
                    p.y = height + 20;
                    p.x = randomBetween(0, width);
                }
                if (p.x < -20) p.x = width + 20;
                if (p.x > width + 20) p.x = -20;

                const gradient = ctx.createRadialGradient(
                    p.x, p.y, 0,
                    p.x, p.y, p.radius * 2
                );

                gradient.addColorStop(0, 'rgba(184, 146, 106, ' + p.opacity + ')');
                gradient.addColorStop(0.6, 'rgba(184, 146, 106, ' + (p.opacity * 0.5) + ')');
                gradient.addColorStop(1, 'rgba(184, 146, 106, 0)');

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius * 2, 0, Math.PI * 2);
                ctx.fillStyle = gradient;
                ctx.fill();
            });

            requestAnimationFrame(animate);
        }

        animate();
    }

    // ─── CTA PARTICLES ───
    const ctaCanvas = document.getElementById('inviteCtaCanvas');

    if (ctaCanvas) {
        const ctx2 = ctaCanvas.getContext('2d');
        let width2 = ctaCanvas.width = ctaCanvas.offsetWidth;
        let height2 = ctaCanvas.height = ctaCanvas.offsetHeight;

        function resizeCanvas2() {
            width2 = ctaCanvas.width = ctaCanvas.offsetWidth;
            height2 = ctaCanvas.height = ctaCanvas.offsetHeight;
        }
        window.addEventListener('resize', resizeCanvas2);

        const particles2 = [];
        const count2 = 25;

        function randomBetween2(min, max) {
            return Math.random() * (max - min) + min;
        }

        for (let i = 0; i < count2; i++) {
            particles2.push({
                x: randomBetween2(0, width2),
                y: randomBetween2(0, height2),
                radius: randomBetween2(1.5, 3),
                speedY: randomBetween2(-0.3, -0.1),
                speedX: randomBetween2(-0.1, 0.1),
                opacity: randomBetween2(0.15, 0.4),
                wobble: randomBetween2(0, Math.PI * 2),
                wobbleSpeed: randomBetween2(0.01, 0.02),
            });
        }

        function animate2() {
            ctx2.clearRect(0, 0, width2, height2);

            particles2.forEach(function(p) {
                p.y += p.speedY;
                p.x += p.speedX;
                p.wobble += p.wobbleSpeed;
                p.x += Math.sin(p.wobble) * 0.3;

                if (p.y < -20) {
                    p.y = height2 + 20;
                    p.x = randomBetween2(0, width2);
                }

                const g = ctx2.createRadialGradient(
                    p.x, p.y, 0,
                    p.x, p.y, p.radius * 2
                );
                g.addColorStop(0, 'rgba(184, 146, 106, ' + p.opacity + ')');
                g.addColorStop(0.6, 'rgba(184, 146, 106, ' + (p.opacity * 0.5) + ')');
                g.addColorStop(1, 'rgba(184, 146, 106, 0)');

                ctx2.beginPath();
                ctx2.arc(p.x, p.y, p.radius * 2, 0, Math.PI * 2);
                ctx2.fillStyle = g;
                ctx2.fill();
            });

            requestAnimationFrame(animate2);
        }

        animate2();
    }

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.invite__topics-grid, .invite__form-grid, .invite__cta-content'
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
            threshold: 0.05,
            rootMargin: '0px 0px -60px 0px'
        });

        revealElements.forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = 'opacity 1s cubic-bezier(0.34, 1.56, 0.64, 1), transform 1s cubic-bezier(0.34, 1.56, 0.64, 1)';
            observer.observe(el);
        });
    }

    // ─── SMOOTH SCROLL FOR #invite-form ───
    document.querySelectorAll('a[href="#invite-form"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.getElementById('invite-form');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});