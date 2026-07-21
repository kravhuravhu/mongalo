document.addEventListener('DOMContentLoaded', function() {
    // ─── COMMUNITY ORBS PARALLAX ───
    const communityOrbs = document.querySelectorAll('.community__orb');
    if (communityOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                communityOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── SCROLL REVEAL FOR BENEFITS CARDS ───
    const benefitCards = document.querySelectorAll('.community__benefits-card');
    if (benefitCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('community__benefits-card--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        benefitCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR TESTIMONIALS CARDS ───
    const testimonialCards = document.querySelectorAll('.community__testimonials-card');
    if (testimonialCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('community__testimonials-card--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        testimonialCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR COMMUNITY CTA ───
    const communitySection = document.querySelector('.community__cta-content');
    if (communitySection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('community__cta-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        observer.observe(communitySection);
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.community__hero-badge');
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
    const heroShapes = document.querySelectorAll('.community__hero-shape');
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

    // ─── MOCKUP MESSAGES AUTO-SCROLL ───
    const messagesContainer = document.querySelector('.community__hero-mockup-messages');
    if (messagesContainer) {
        let scrollInterval = setInterval(() => {
            if (messagesContainer.scrollTop + messagesContainer.clientHeight >= messagesContainer.scrollHeight) {
                messagesContainer.scrollTop = 0;
            } else {
                messagesContainer.scrollTop += 30;
            }
        }, 3000);

        // Pause on hover
        messagesContainer.addEventListener('mouseenter', () => {
            clearInterval(scrollInterval);
        });
        messagesContainer.addEventListener('mouseleave', () => {
            scrollInterval = setInterval(() => {
                if (messagesContainer.scrollTop + messagesContainer.clientHeight >= messagesContainer.scrollHeight) {
                    messagesContainer.scrollTop = 0;
                } else {
                    messagesContainer.scrollTop += 30;
                }
            }, 3000);
        });
    }
});