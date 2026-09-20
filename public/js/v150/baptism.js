document.addEventListener('DOMContentLoaded', function() {

    // ─── HERO WATER CANVAS ───
    const canvas = document.getElementById('baptismHeroCanvas');

    if (canvas) {
        const ctx = canvas.getContext('2d');
        let width = canvas.width = canvas.offsetWidth;
        let height = canvas.height = canvas.offsetHeight;

        // ─── RESIZE ───
        function resizeCanvas() {
            width = canvas.width = canvas.offsetWidth;
            height = canvas.height = canvas.offsetHeight;
        }

        window.addEventListener('resize', resizeCanvas);

        // ─── PARTICLES ───
        const particles = [];
        const particleCount = 60;

        function randomBetween(min, max) {
            return Math.random() * (max - min) + min;
        }

        // ─── CREATE PARTICLES ───
        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: randomBetween(0, width),
                y: randomBetween(0, height),
                radius: randomBetween(1, 3.5),
                speed: randomBetween(0.2, 0.8),
                drift: randomBetween(-0.3, 0.3),
                opacity: randomBetween(0.2, 0.6),
                wobble: randomBetween(0, Math.PI * 2),
                wobbleSpeed: randomBetween(0.01, 0.03),
            });
        }

        // ─── ANIMATE ───
        function animate() {
            ctx.clearRect(0, 0, width, height);

            particles.forEach(function(p) {
                // ─── UPDATE ───
                p.y -= p.speed;
                p.wobble += p.wobbleSpeed;
                p.x += Math.sin(p.wobble) * 0.3 + p.drift;

                // ─── RESET WHEN OFF TOP ───
                if (p.y < -10) {
                    p.y = height + 10;
                    p.x = randomBetween(0, width);
                }

                // ─── WRAP AROUND SIDES ───
                if (p.x < -10) p.x = width + 10;
                if (p.x > width + 10) p.x = -10;

                // ─── DRAW ───
                const gradient = ctx.createRadialGradient(
                    p.x, p.y, 0,
                    p.x, p.y, p.radius * 2
                );

                gradient.addColorStop(0, 'rgba(200, 235, 245, ' + p.opacity + ')');
                gradient.addColorStop(0.5, 'rgba(124, 197, 217, ' + (p.opacity * 0.5) + ')');
                gradient.addColorStop(1, 'rgba(124, 197, 217, 0)');

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius * 2, 0, Math.PI * 2);
                ctx.fillStyle = gradient;
                ctx.fill();
            });

            requestAnimationFrame(animate);
        }

        animate();
    }

    // ─── FAQ TOGGLE ───
    window.toggleBaptismFaq = function(button) {
        const item = button.closest('.baptism__faq-item');
        const answer = item.querySelector('.baptism__faq-answer');
        const icon = item.querySelector('.baptism__faq-question-icon i');
        const isOpen = item.classList.contains('baptism__faq-item--open');

        // ─── CLOSE ALL ───
        document.querySelectorAll('.baptism__faq-item').forEach(function(otherItem) {
            otherItem.classList.remove('baptism__faq-item--open');
            const otherAnswer = otherItem.querySelector('.baptism__faq-answer');
            const otherIcon = otherItem.querySelector('.baptism__faq-question-icon i');
            if (otherAnswer) otherAnswer.style.display = 'none';
            if (otherIcon) otherIcon.className = 'fas fa-plus';
        });

        // ─── OPEN CURRENT IF IT WAS CLOSED ───
        if (!isOpen) {
            item.classList.add('baptism__faq-item--open');
            if (answer) answer.style.display = 'block';
            if (icon) icon.className = 'fas fa-minus';
        }
    };

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.baptism__two-grid, .baptism__meaning-grid, .baptism__steps-grid, .baptism__scriptures-grid, .baptism__contact-grid, .baptism__faq-list, .baptism__community-content'
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
});