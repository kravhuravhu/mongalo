document.addEventListener('DOMContentLoaded', function() {
    // ─── HOME ORBS PARALLAX ───
    const homeOrbs = document.querySelectorAll('.home__orb');
    if (homeOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                homeOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── SCROLL REVEAL FOR PILLARS ───
    const pillarCards = document.querySelectorAll('.home__pillars-card');
    
    if (pillarCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 100;
                    setTimeout(() => {
                        entry.target.classList.add('home__pillars-card--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        
        pillarCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR COMMUNITY CTA ───
    const communitySection = document.querySelector('.home__community-content');
    
    if (communitySection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('home__community-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        observer.observe(communitySection);
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.home__hero-badge');
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

    // ─── HERO ORBS PARALLAX (from app.css) ───
    const heroOrbs = document.querySelectorAll('.home__hero-orb');
    if (heroOrbs.length > 0 && window.innerWidth > 768) {
        let rafId2 = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId2) {
                cancelAnimationFrame(rafId2);
            }

            rafId2 = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                heroOrbs.forEach((orb, index) => {
                    const speed = 15 + index * 8;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId2 = null;
            });
        }, { passive: true });
    }

    // ─── PARALLAX EFFECT ON FLOATING ICONS ───
    const floatIcons = document.querySelectorAll('.home__hero-float-icon');
    if (floatIcons.length > 0 && window.innerWidth > 768) {
        let rafId3 = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId3) {
                cancelAnimationFrame(rafId3);
            }

            rafId3 = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                floatIcons.forEach((icon, index) => {
                    const speed = 8 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    icon.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId3 = null;
            });
        }, { passive: true });
    }

    // ─── BOOK 3D TILT ON MOUSE MOVE ───
    const bookInner = document.querySelector('.home__hero-book-inner');
    if (bookInner && window.innerWidth > 768) {
        const bookContainer = document.querySelector('.home__hero-book');
        
        if (bookContainer) {
            bookContainer.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;
                
                const rotateY = x * 15;
                const rotateX = -y * 15;
                
                bookInner.style.transform = `rotateY(${rotateY}deg) rotateX(${rotateX}deg)`;
            });
            
            bookContainer.addEventListener('mouseleave', function() {
                bookInner.style.transform = 'rotateY(-18deg) rotateX(5deg)';
            });
        }
    }
});