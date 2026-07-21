document.addEventListener('DOMContentLoaded', function() {
    // ─── ABOUT ORBS PARALLAX ───
    const aboutOrbs = document.querySelectorAll('.about__orb');
    if (aboutOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                aboutOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── SCROLL REVEAL FOR MISSION ITEMS ───
    const missionItems = document.querySelectorAll('.about__mission-item');
    if (missionItems.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 150;
                    setTimeout(() => {
                        entry.target.classList.add('about__mission-item--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        missionItems.forEach(item => observer.observe(item));
    }

    // ─── SCROLL REVEAL FOR STORY CARD ───
    const storyCard = document.querySelector('.about__story-card');
    if (storyCard) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('about__story-card--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        observer.observe(storyCard);
    }

    // ─── SCROLL REVEAL FOR VALUES CARDS ───
    const valueCards = document.querySelectorAll('.about__values-card');
    if (valueCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 80;
                    setTimeout(() => {
                        entry.target.classList.add('about__values-card--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        valueCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR ARTHUR CARD ───
    const arthurCard = document.querySelector('.about__arthur-card');
    if (arthurCard) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('about__arthur-card--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        observer.observe(arthurCard);
    }

    // ─── SCROLL REVEAL FOR STATS ITEMS ───
    const statsItems = document.querySelectorAll('.about__stats-item');
    if (statsItems.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 100;
                    setTimeout(() => {
                        entry.target.classList.add('about__stats-item--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.3,
            rootMargin: '0px 0px -30px 0px'
        });
        statsItems.forEach(item => observer.observe(item));
    }

    // ─── SCROLL REVEAL FOR COMMUNITY CTA ───
    const communitySection = document.querySelector('.about__community-content');
    if (communitySection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('about__community-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        observer.observe(communitySection);
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

    // ─── BADGE HOVER INTERACTION ───
    const heroBadge = document.querySelector('.about__hero-badge');
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
    const heroShapes = document.querySelectorAll('.about__hero-shape');
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

    // ─── FLOATING ICONS PARALLAX ───
    const floatIcons = document.querySelectorAll('.about__hero-float');
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
                    const speed = 8 + index * 3;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    icon.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId3 = null;
            });
        }, { passive: true });
    }
});