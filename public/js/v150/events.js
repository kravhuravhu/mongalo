document.addEventListener('DOMContentLoaded', function() {

    // ─── HERO PARTICLES ───
    const particlesContainer = document.getElementById('eventsHeroParticles');

    if (particlesContainer) {
        const particleCount = 40;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('span');
            const size = Math.random() * 3 + 1.5;

            particle.style.position = 'absolute';
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.background = 'rgba(184, 146, 106, 0.5)';
            particle.style.borderRadius = '50%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animation = 'eventsParticleFloat ' + (Math.random() * 20 + 15) + 's ease-in-out infinite';
            particle.style.animationDelay = Math.random() * 10 + 's';
            particle.style.pointerEvents = 'none';

            particlesContainer.appendChild(particle);
        }
    }

    // ─── GIANT COUNTDOWN ───
    const countdownEl = document.getElementById('eventsCountdown');

    if (countdownEl && countdownEl.dataset.countdownTarget) {
        const targetDate = new Date(countdownEl.dataset.countdownTarget).getTime();

        if (!isNaN(targetDate)) {
            const monthsEl = countdownEl.querySelector('[data-unit="months"]');
            const daysEl = countdownEl.querySelector('[data-unit="days"]');
            const hoursEl = countdownEl.querySelector('[data-unit="hours"]');
            const minutesEl = countdownEl.querySelector('[data-unit="minutes"]');
            const secondsEl = countdownEl.querySelector('[data-unit="seconds"]');

            function pad(num) {
                return String(num).padStart(2, '0');
            }

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    if (monthsEl) monthsEl.textContent = '00';
                    if (daysEl) daysEl.textContent = '00';
                    if (hoursEl) hoursEl.textContent = '00';
                    if (minutesEl) minutesEl.textContent = '00';
                    if (secondsEl) secondsEl.textContent = '00';
                    return;
                }

                const totalSeconds = Math.floor(distance / 1000);
                const totalMinutes = Math.floor(totalSeconds / 60);
                const totalHours = Math.floor(totalMinutes / 60);
                const totalDays = Math.floor(totalHours / 24);

                const months = Math.floor(totalDays / 30.44);
                const remainingDays = Math.floor(totalDays % 30.44);
                const hours = totalHours % 24;
                const minutes = totalMinutes % 60;
                const seconds = totalSeconds % 60;

                if (monthsEl) monthsEl.textContent = pad(months);
                if (daysEl) daysEl.textContent = pad(remainingDays);
                if (hoursEl) hoursEl.textContent = pad(hours);
                if (minutesEl) minutesEl.textContent = pad(minutes);
                if (secondsEl) secondsEl.textContent = pad(seconds);
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
    }

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.events__upcoming-grid, .events__past-grid, .events__invite-content, .events__calendar-cta-content, .events__community-content'
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

// ─── EVENT DETAIL PAGE ───
document.addEventListener('DOMContentLoaded', function() {
    // ─── HERO PARTICLES ───
    const particlesContainer = document.getElementById('eventDetailParticles');

    if (particlesContainer) {
        const particleCount = 40;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('span');
            const size = Math.random() * 3 + 1.5;

            particle.style.position = 'absolute';
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.background = 'rgba(184, 146, 106, 0.5)';
            particle.style.borderRadius = '50%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animation = 'eventDetailParticleFloat ' + (Math.random() * 20 + 15) + 's ease-in-out infinite';
            particle.style.animationDelay = Math.random() * 10 + 's';
            particle.style.pointerEvents = 'none';

            particlesContainer.appendChild(particle);
        }
    }

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.event-detail__expect-grid, .event-detail__other-content, .event-detail__community-content'
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