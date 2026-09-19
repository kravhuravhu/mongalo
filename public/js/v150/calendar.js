document.addEventListener('DOMContentLoaded', function() {

    // ─── HERO PARTICLES ───
    const particlesContainer = document.getElementById('calendarHeroParticles');

    if (particlesContainer) {
        const particleCount = 30;

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
            particle.style.animation = 'calendarParticleFloat ' + (Math.random() * 20 + 15) + 's ease-in-out infinite';
            particle.style.animationDelay = Math.random() * 10 + 's';
            particle.style.pointerEvents = 'none';

            particlesContainer.appendChild(particle);
        }
    }

    // ─── ELEMENTS ───
    const gridEl = document.getElementById('calendarGrid');
    const gridWrapEl = document.getElementById('calendarGridWrap');
    const loaderEl = document.getElementById('calendarGridLoader');
    const monthLabelEl = document.getElementById('calendarMonthLabel');
    const emptyHintEl = document.getElementById('calendarEmptyHint');
    const prevBtn = document.getElementById('calendarPrevBtn');
    const nextBtn = document.getElementById('calendarNextBtn');

    let isFetching = false;

    // ─── FETCH MONTH ───
    function fetchMonth(month, year) {
        if (isFetching) return;
        isFetching = true;

        // ─── SHOW LOADER ───
        if (loaderEl) loaderEl.classList.add('event-calendar__grid-loader--visible');
        if (gridEl) gridEl.classList.add('event-calendar__grid--updating');
        if (prevBtn) prevBtn.classList.add('event-calendar__nav-btn--loading');
        if (nextBtn) nextBtn.classList.add('event-calendar__nav-btn--loading');

        fetch('/events/calendar/data?month=' + month + '&year=' + year, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Failed to fetch month data.');
            }
            return response.json();
        })
        .then(function(data) {
            if (!data.success) {
                throw new Error(data.message || 'Something went wrong.');
            }

            // ─── REBUILD GRID ───
            rebuildGrid(data.weeks);

            // ─── UPDATE LABEL ───
            if (monthLabelEl) monthLabelEl.textContent = data.month_label;

            // ─── UPDATE NAV BUTTONS ───
            if (prevBtn) {
                prevBtn.dataset.month = data.prev.month;
                prevBtn.dataset.year = data.prev.year;
            }
            if (nextBtn) {
                nextBtn.dataset.month = data.next.month;
                nextBtn.dataset.year = data.next.year;
            }

            // ─── EMPTY HINT ───
            if (emptyHintEl) {
                if (data.has_events) {
                    emptyHintEl.style.display = 'none';
                } else {
                    emptyHintEl.style.display = 'flex';
                }
            }

            // ─── HIDE LOADER ───
            if (loaderEl) loaderEl.classList.remove('event-calendar__grid-loader--visible');
            if (gridEl) gridEl.classList.remove('event-calendar__grid--updating');
            if (prevBtn) prevBtn.classList.remove('event-calendar__nav-btn--loading');
            if (nextBtn) nextBtn.classList.remove('event-calendar__nav-btn--loading');

            isFetching = false;
        })
        .catch(function(error) {
            console.error('Calendar fetch error:', error);

            // ─── HIDE LOADER ───
            if (loaderEl) loaderEl.classList.remove('event-calendar__grid-loader--visible');
            if (gridEl) gridEl.classList.remove('event-calendar__grid--updating');
            if (prevBtn) prevBtn.classList.remove('event-calendar__nav-btn--loading');
            if (nextBtn) nextBtn.classList.remove('event-calendar__nav-btn--loading');

            isFetching = false;
        });
    }

    // ─── REBUILD GRID DOM ───
    function rebuildGrid(weeks) {
        if (!gridEl) return;

        gridEl.innerHTML = '';

        weeks.forEach(function(week) {
            const weekEl = document.createElement('div');
            weekEl.className = 'event-calendar__week';

            week.forEach(function(day) {
                const dayEl = document.createElement('div');
                dayEl.className = 'event-calendar__day';

                if (day === null) {
                    dayEl.classList.add('event-calendar__day--empty');
                } else {
                    if (day.is_today) dayEl.classList.add('event-calendar__day--today');
                    if (day.is_past) dayEl.classList.add('event-calendar__day--past');
                    if (day.has_events) dayEl.classList.add('event-calendar__day--has-events');

                    dayEl.dataset.date = day.date;
                    dayEl.dataset.events = JSON.stringify(day.events || []);

                    // ─── DAY NUMBER ───
                    const numEl = document.createElement('span');
                    numEl.className = 'event-calendar__day-number';
                    numEl.textContent = day.day;
                    dayEl.appendChild(numEl);

                    // ─── DOT ───
                    if (day.has_events) {
                        const dotEl = document.createElement('span');
                        dotEl.className = 'event-calendar__day-dot';
                        dayEl.appendChild(dotEl);
                    }

                    // ─── COUNT ───
                    if (day.event_count > 1) {
                        const countEl = document.createElement('span');
                        countEl.className = 'event-calendar__day-count';
                        countEl.textContent = '+' + day.event_count;
                        dayEl.appendChild(countEl);
                    }
                }

                weekEl.appendChild(dayEl);
            });

            gridEl.appendChild(weekEl);
        });

        // ─── REBIND CLICK HANDLERS ───
        bindDayClickHandlers();
    }

    // ─── BIND DAY CLICKS ───
    function bindDayClickHandlers() {
        if (!gridEl) return;

        gridEl.querySelectorAll('.event-calendar__day--has-events').forEach(function(day) {
            day.addEventListener('click', function() {
                const date = this.dataset.date;
                const events = JSON.parse(this.dataset.events);
                openCalendarModal(date, events);
            });
        });
    }

    // ─── NAV CLICKS ───
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            fetchMonth(this.dataset.month, this.dataset.year);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            fetchMonth(this.dataset.month, this.dataset.year);
        });
    }

    // ─── INITIAL BIND ───
    bindDayClickHandlers();
});

// ─── MODAL ───
function openCalendarModal(date, events) {
    const modal = document.getElementById('eventModal');
    const body = document.getElementById('eventModalBody');
    const title = document.getElementById('modalDateTitle');

    const dateObj = new Date(date + 'T00:00:00');
    const dateFormatted = dateObj.toLocaleDateString('en-US', {
        weekday: 'long',
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    });

    title.textContent = dateFormatted;

    if (events && events.length > 0) {
        let html = '<div class="event-calendar__modal-list">';

        events.forEach(function(event) {
            const color = event.color || '#a67c4e';
            const isFree = event.is_free ? 'Free' : 'R' + parseFloat(event.price).toFixed(2);

            html += '<div class="event-calendar__modal-event" style="border-left-color: ' + color + ';">';

            html += '<div class="event-calendar__modal-event-header">';
            html += '<h4 class="event-calendar__modal-event-title">' + event.title + '</h4>';
            html += '<span class="event-calendar__modal-event-type" style="background: ' + color + ';">';
            html += (event.type || 'Event');
            html += '</span>';
            html += '</div>';

            html += '<div class="event-calendar__modal-event-meta">';
            if (event.time) {
                html += '<span><i class="fas fa-clock"></i> ' + event.time + '</span>';
            }
            if (event.location) {
                html += '<span><i class="fas fa-map-marker-alt"></i> ' + event.location + '</span>';
            }
            html += '<span><i class="fas fa-tag"></i> ' + isFree + '</span>';
            html += '</div>';

            if (event.description) {
                var desc = event.description.substring(0, 130);
                if (event.description.length > 130) desc += '...';
                html += '<p class="event-calendar__modal-event-desc">' + desc + '</p>';
            }

            html += '<a href="/events/' + event.slug + '" class="event-calendar__modal-event-btn">';
            html += '<span>View Details</span>';
            html += '<i class="fas fa-arrow-right"></i>';
            html += '</a>';

            html += '</div>';
        });

        html += '</div>';
        body.innerHTML = html;
    } else {
        body.innerHTML = '<div class="event-calendar__modal-empty">' +
            '<i class="fas fa-calendar-check"></i>' +
            '<p>No events on this day.</p>' +
            '</div>';
    }

    modal.classList.add('event-calendar__modal--open');
    document.body.style.overflow = 'hidden';
}

function closeCalendarModal() {
    const modal = document.getElementById('eventModal');
    modal.classList.remove('event-calendar__modal--open');
    document.body.style.overflow = '';
}

// ─── ESC TO CLOSE ───
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCalendarModal();
    }
});