document.addEventListener('DOMContentLoaded', function() {
    // ─── CONTACT ORBS PARALLAX ───
    const contactOrbs = document.querySelectorAll('.contact__orb');
    if (contactOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                contactOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── SCROLL REVEAL FOR WHATSAPP VISUAL ───
    const whatsappVisual = document.querySelector('.contact__whatsapp-visual');
    if (whatsappVisual) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('contact__whatsapp-visual--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        observer.observe(whatsappVisual);
    }

    // ─── SCROLL REVEAL FOR LOCATION MAP ───
    const locationMap = document.querySelector('.contact__location-map');
    const locationInfo = document.querySelector('.contact__location-info');
    
    if (locationMap && locationInfo) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    locationMap.classList.add('contact__location-map--visible');
                    locationInfo.classList.add('contact__location-info--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        observer.observe(locationMap);
    }

    // ─── SCROLL REVEAL FOR COMMUNITY CTA ───
    const communitySection = document.querySelector('.contact__community-content');
    if (communitySection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('contact__community-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        observer.observe(communitySection);
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.contact__hero-badge');
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
    const heroShapes = document.querySelectorAll('.contact__hero-shape');
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
    const formInputs = document.querySelectorAll('.contact__hero-form-group input, .contact__hero-form-group textarea, .contact__hero-form-group select');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            const label = this.closest('.contact__hero-form-group').querySelector('label');
            if (label) {
                label.style.color = 'var(--gold)';
            }
        });
        input.addEventListener('blur', function() {
            const label = this.closest('.contact__hero-form-group').querySelector('label');
            if (label) {
                label.style.color = '';
            }
        });
    });

    // ─── INFO ITEMS HOVER EFFECT ───
    const infoItems = document.querySelectorAll('.contact__hero-info-item');
    infoItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1.1)';
            }
            const value = this.querySelector('.contact__hero-info-value');
            if (value) {
                value.style.color = 'var(--gold)';
            }
        });
        item.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1)';
            }
            const value = this.querySelector('.contact__hero-info-value');
            if (value) {
                value.style.color = '';
            }
        });
    });
});