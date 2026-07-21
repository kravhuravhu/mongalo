document.addEventListener('DOMContentLoaded', function() {
    // ─── INVITE ORBS PARALLAX ───
    const inviteOrbs = document.querySelectorAll('.invite__orb');
    if (inviteOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                inviteOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── SCROLL REVEAL FOR COMMUNITY CTA ───
    const communitySection = document.querySelector('.invite__community-content');
    if (communitySection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('invite__community-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        observer.observe(communitySection);
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.invite__hero-badge');
    if (heroBadge) {
        heroBadge.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(15deg) scale(1.2)';
            }
        });
        heroBadge.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(0deg) scale(1)';
            }
        });
    }

    // ─── HERO SHAPES PARALLAX ───
    const heroShapes = document.querySelectorAll('.invite__hero-shape');
    if (heroShapes.length > 0 && window.innerWidth > 768) {
        let rafId2 = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId2) {
                cancelAnimationFrame(rafId2);
            }

            rafId2 = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                heroShapes.forEach((shape, index) => {
                    const speed = 15 + index * 6;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    shape.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId2 = null;
            });
        }, { passive: true });
    }

    // ─── FORM INPUT FOCUS EFFECT ───
    const formInputs = document.querySelectorAll('.invite__form-group input, .invite__form-group textarea');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.invite__form-group').querySelector('label').style.color = 'var(--gold)';
        });
        input.addEventListener('blur', function() {
            this.closest('.invite__form-group').querySelector('label').style.color = '';
        });
    });
});