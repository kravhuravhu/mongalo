document.addEventListener('DOMContentLoaded', function() {

    // ─── HERO PARTICLES ───
    const canvas = document.getElementById('contactHeroCanvas');

    if (canvas) {
        const ctx = canvas.getContext('2d');
        let width = canvas.width = canvas.offsetWidth;
        let height = canvas.height = canvas.offsetHeight;

        function resizeCanvas() {
            width = canvas.width = canvas.offsetWidth;
            height = canvas.height = canvas.offsetHeight;
        }
        window.addEventListener('resize', resizeCanvas);

        const particles = [];
        const particleCount = 30;

        function randomBetween(min, max) {
            return Math.random() * (max - min) + min;
        }

        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: randomBetween(0, width),
                y: randomBetween(0, height),
                radius: randomBetween(1.5, 3.5),
                speedY: randomBetween(-0.4, -0.15),
                speedX: randomBetween(-0.2, 0.2),
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

    // ─── INFO ITEMS HOVER EFFECT ───
    document.querySelectorAll('.contact__hero-item').forEach(function(item) {
        item.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.contact__hero-item-icon i');
            if (icon) {
                icon.style.transform = 'scale(1.1)';
            }
        });
        item.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.contact__hero-item-icon i');
            if (icon) {
                icon.style.transform = 'scale(1)';
            }
        });
    });
});