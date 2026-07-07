// ─── EVENTS ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.events__upcoming-card, ' +
        '.events__past-card, ' +
        '.events__testimonials-card, ' +
        '.events__invite-container'
    );

    if (revealElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
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

    // ─── CALENDAR NAVIGATION ───
    const navBtns = document.querySelectorAll('.events__hero-calendar-nav-btn');
    const monthDisplay = document.querySelector('.events__hero-calendar-month');

    if (navBtns.length > 0 && monthDisplay) {
        // current month & year
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        // Update the month 
        function updateMonthDisplay() {
            const date = new Date(currentYear, currentMonth, 1);
            monthDisplay.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });
        }

        navBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const direction = this.querySelector('.fa-chevron-left') ? -1 : 1;
                currentMonth += direction;

                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                } else if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }

                updateMonthDisplay();
            });
        });
    }

    // ─── ADD TO CALENDAR ───
    window.addToCalendar = function() {
        alert('A calendar invite will be sent to your email after registration.');
    };

});