// ─── EVENTS ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.events__upcoming-card, .events__past-card, .events__invite-grid'
    );

    if (revealElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                } else {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(30px)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });

        revealElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
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

            // Calculate total months, days, hours, minutes, seconds
            let totalSeconds = Math.floor(distance / 1000);
            let totalMinutes = Math.floor(totalSeconds / 60);
            let totalHours = Math.floor(totalMinutes / 60);
            let totalDays = Math.floor(totalHours / 24);

            // Calculate months (approx 30.44 days per month)
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

});