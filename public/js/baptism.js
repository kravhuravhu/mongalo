document.addEventListener('DOMContentLoaded', function() {
    // ─── BAPTISM ORBS PARALLAX ───
    const baptismOrbs = document.querySelectorAll('.baptism__orb');
    if (baptismOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                baptismOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── SCROLL REVEAL FOR INFO CARDS ───
    const infoCards = document.querySelectorAll('.baptism__info-card');
    if (infoCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 80;
                    setTimeout(() => {
                        entry.target.classList.add('baptism__info-card--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        infoCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR STORY VISUAL ───
    const storyVisual = document.querySelector('.baptism__story-visual');
    if (storyVisual) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('baptism__story-visual--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        observer.observe(storyVisual);
    }

    // ─── SCROLL REVEAL FOR STEPS CARDS ───
    const stepsCards = document.querySelectorAll('.baptism__steps-card');
    if (stepsCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 100;
                    setTimeout(() => {
                        entry.target.classList.add('baptism__steps-card--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        stepsCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR COMMUNITY CTA ───
    const communitySection = document.querySelector('.baptism__community-content');
    if (communitySection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('baptism__community-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        observer.observe(communitySection);
    }

    // ─── FAQ ACCORDION ───
    const faqItems = document.querySelectorAll('.baptism__faq-item');

    if (faqItems.length > 0) {
        faqItems.forEach((item, index) => {
            const header = item.querySelector('.baptism__faq-item-header');
            const answer = item.querySelector('.baptism__faq-answer');
            const toggle = item.querySelector('.baptism__faq-toggle');

            if (header && answer && toggle) {
                // Open first item by default
                if (index === 0) {
                    answer.classList.add('baptism__faq-answer--open');
                    toggle.classList.add('baptism__faq-toggle--open');
                    toggle.innerHTML = '<i class="fas fa-minus"></i>';
                }

                header.addEventListener('click', function() {
                    const isOpen = answer.classList.contains('baptism__faq-answer--open');

                    // Close all
                    faqItems.forEach(otherItem => {
                        const otherAnswer = otherItem.querySelector('.baptism__faq-answer');
                        const otherToggle = otherItem.querySelector('.baptism__faq-toggle');
                        if (otherAnswer && otherToggle) {
                            otherAnswer.classList.remove('baptism__faq-answer--open');
                            otherToggle.classList.remove('baptism__faq-toggle--open');
                            otherToggle.innerHTML = '<i class="fas fa-plus"></i>';
                        }
                    });

                    // Toggle current
                    if (!isOpen) {
                        answer.classList.add('baptism__faq-answer--open');
                        toggle.classList.add('baptism__faq-toggle--open');
                        toggle.innerHTML = '<i class="fas fa-minus"></i>';
                    }
                });
            }
        });
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.baptism__hero-badge');
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

    // ─── WAVE PARALLAX ON MOUSE MOVE ───
    const waves = document.querySelectorAll('.baptism__hero-wave');
    if (waves.length > 0 && window.innerWidth > 768) {
        let rafId2 = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId2) {
                cancelAnimationFrame(rafId2);
            }

            rafId2 = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                
                waves.forEach((wave, index) => {
                    const speed = 10 + index * 5;
                    const moveX = x * speed;
                    wave.style.transform = `translateX(${moveX}px) translateY(0)`;
                });

                rafId2 = null;
            });
        }, { passive: true });
    }
});