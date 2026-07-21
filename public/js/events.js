document.addEventListener('DOMContentLoaded', function() {
    // ─── EVENTS ORBS PARALLAX ───
    const eventsOrbs = document.querySelectorAll('.events__orb');
    if (eventsOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                eventsOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── SCROLL REVEAL FOR UPCOMING EVENTS ───
    const upcomingCards = document.querySelectorAll('.events__upcoming-card');
    if (upcomingCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 100;
                    setTimeout(() => {
                        entry.target.classList.add('events__upcoming-card--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        upcomingCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR PAST EVENTS ───
    const pastCards = document.querySelectorAll('.events__past-card');
    if (pastCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 80;
                    setTimeout(() => {
                        entry.target.classList.add('events__past-card--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        pastCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR INVITE VISUAL ───
    const inviteVisual = document.querySelector('.events__invite-visual');
    if (inviteVisual) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('events__invite-visual--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        observer.observe(inviteVisual);
    }

    // ─── SCROLL REVEAL FOR COMMUNITY CTA ───
    const communitySection = document.querySelector('.events__community-content');
    if (communitySection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('events__community-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        observer.observe(communitySection);
    }

    // ─── COUNTDOWN TIMER — MM : DD : HH : MM : SS ───
    const countdownEl = document.querySelector('.events__countdown');
    if (countdownEl) {
        const eventDate = countdownEl.dataset.eventDate;
        const eventTime = countdownEl.dataset.eventTime;

        function updateCountdown() {
            if (!eventDate || !eventTime) {
                document.getElementById('cd-months').textContent = '00';
                document.getElementById('cd-days').textContent = '00';
                document.getElementById('cd-hours').textContent = '00';
                document.getElementById('cd-minutes').textContent = '00';
                document.getElementById('cd-seconds').textContent = '00';
                return;
            }

            const targetDate = new Date(`${eventDate}T${eventTime}`).getTime();
            if (isNaN(targetDate)) return;

            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                document.getElementById('cd-months').textContent = '00';
                document.getElementById('cd-days').textContent = '00';
                document.getElementById('cd-hours').textContent = '00';
                document.getElementById('cd-minutes').textContent = '00';
                document.getElementById('cd-seconds').textContent = '00';
                return;
            }

            let totalSeconds = Math.floor(distance / 1000);
            let totalMinutes = Math.floor(totalSeconds / 60);
            let totalHours = Math.floor(totalMinutes / 60);
            let totalDays = Math.floor(totalHours / 24);

            const months = Math.floor(totalDays / 30.44);
            const remainingDays = Math.floor(totalDays % 30.44);
            const hours = totalHours % 24;
            const minutes = totalMinutes % 60;
            const seconds = totalSeconds % 60;

            document.getElementById('cd-months').textContent = String(months).padStart(2, '0');
            document.getElementById('cd-days').textContent = String(remainingDays).padStart(2, '0');
            document.getElementById('cd-hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('cd-minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('cd-seconds').textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.events__hero-badge');
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

    // ─── HERO ORBS PARALLAX ───
    const heroOrbs = document.querySelectorAll('.events__hero-orb');
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
                    const speed = 15 + index * 6;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId2 = null;
            });
        }, { passive: true });
    }
});

// ─── EVENT DETAIL SCROLL REVEAL ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── EVENT DETAIL ORBS PARALLAX ───
    const detailOrbs = document.querySelectorAll('.event-detail__orb');
    if (detailOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                detailOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.event-detail__hero-badge');
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

    // ─── HERO ORBS PARALLAX ───
    const heroOrbs = document.querySelectorAll('.event-detail__hero-orb');
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
                    const speed = 15 + index * 6;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId2 = null;
            });
        }, { passive: true });
    }
});