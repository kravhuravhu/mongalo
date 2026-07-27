@extends('layouts.app')

@section('title', $event->title . ' · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')

<div class="event-detail">

    {{-- EVENT DETAIL FLOATING ORBS --}}
    <div class="event-detail__orbs">
        <div class="event-detail__orb event-detail__orb--1"></div>
        <div class="event-detail__orb event-detail__orb--2"></div>
        <div class="event-detail__orb event-detail__orb--3"></div>
        <div class="event-detail__orb event-detail__orb--4"></div>
        <div class="event-detail__orb event-detail__orb--5"></div>
    </div>

    {{-- HERO --}}
    <section class="event-detail__hero">
        <div class="event-detail__hero-bg">
            <div class="event-detail__hero-orb event-detail__hero-orb--1"></div>
            <div class="event-detail__hero-orb event-detail__hero-orb--2"></div>
            <div class="event-detail__hero-orb event-detail__hero-orb--3"></div>
            <div class="event-detail__hero-particle event-detail__hero-particle--1"></div>
            <div class="event-detail__hero-particle event-detail__hero-particle--2"></div>
            <div class="event-detail__hero-particle event-detail__hero-particle--3"></div>
            <div class="event-detail__hero-particle event-detail__hero-particle--4"></div>
            <div class="event-detail__hero-particle event-detail__hero-particle--5"></div>
            <div class="event-detail__hero-pattern"></div>
        </div>
        <div class="event-detail__hero-tag">REGISTER</div>

        <div class="wrap">
            <div class="event-detail__hero-grid">
                {{-- Event Details --}}
                <div class="event-detail__hero-content">
                    <span class="event-detail__hero-badge">
                        <i class="fas fa-calendar-alt"></i> {{ $event->date->format('l, F d, Y') }}
                    </span>
                    <h1 class="event-detail__hero-title">{{ $event->title }}</h1>
                    <p class="event-detail__hero-text">{{ $event->description }}</p>

                    <div class="event-detail__hero-meta">
                        <div class="event-detail__hero-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                        <div class="event-detail__hero-meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                        </div>
                        @if($event->capacity)
                            <div class="event-detail__hero-meta-item">
                                <i class="fas fa-users"></i>
                                <span>{{ $event->registrations()->count() }}/{{ $event->capacity }} registered</span>
                            </div>
                        @endif
                        @if(!$event->is_free && $event->price > 0)
                            <div class="event-detail__hero-meta-item">
                                <i class="fas fa-tag"></i>
                                <span>R{{ number_format($event->price, 2) }} per person</span>
                            </div>
                        @else
                            <div class="event-detail__hero-meta-item">
                                <i class="fas fa-gift"></i>
                                <span>Free Event</span>
                            </div>
                        @endif
                    </div>

                    <div class="event-detail__hero-features">
                        <span><i class="fas fa-check-circle"></i> Free registration</span>
                        <span><i class="fas fa-check-circle"></i> Bring a friend</span>
                    </div>
                </div>

                {{-- Registration Form --}}
                <div class="event-detail__hero-form">
                    <div class="event-detail__form-card">
                        <h3 class="event-detail__form-title">Register for This Event</h3>
                        <p class="event-detail__form-subtitle">
                            @if(!$event->is_free && $event->price > 0)
                                R{{ number_format($event->price, 2) }} per person
                            @else
                                Free registration
                            @endif
                        </p>

                        <div id="registrationMessage"></div>

                        <form id="eventRegistrationForm" method="POST" action="{{ route('events.register') }}">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                            <div class="event-detail__form-group">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" id="name" placeholder="Thabo Mokoena" required>
                            </div>

                            <div class="event-detail__form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" placeholder="thabo@example.co.za" required>
                            </div>

                            <div class="event-detail__form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" required>
                            </div>

                            <button type="submit" class="btn btn--primary btn--block" id="registerBtn">
                                <span id="registerBtnText">
                                    <i class="fas fa-ticket-alt"></i> Register Now
                                </span>
                                <span id="registerBtnLoader" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Registering...
                                </span>
                            </button>
                        </form>

                        <p class="event-detail__form-note">
                            <i class="fas fa-lock"></i> Your information is safe with us.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- WHAT TO EXPECT --}}
    <section class="event-detail__expect">
        <div class="event-detail__expect-bg">
            <div class="event-detail__expect-shape event-detail__expect-shape--1"></div>
            <div class="event-detail__expect-shape event-detail__expect-shape--2"></div>
        </div>
        <div class="event-detail__expect-tag">EXPECT</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">What to Expect</span>
                <h2 class="section-header__title">A Day of <span>Transformation</span></h2>
                <p class="section-header__subtitle">Every gathering is designed around these four elements. Here is what you can look forward to.</p>
            </div>

            <div class="event-detail__expect-grid">
                <div class="event-detail__expect-item reveal" data-delay="0">
                    <div class="event-detail__expect-icon"><i class="fas fa-praying-hands"></i></div>
                    <h4>Worship</h4>
                    <p>Time set aside to worship freely and encounter God's presence together as one body.</p>
                </div>

                <div class="event-detail__expect-item reveal" data-delay="100">
                    <div class="event-detail__expect-icon"><i class="fas fa-book-open"></i></div>
                    <h4>Teaching</h4>
                    <p>Practical, Scripture-based teaching to strengthen your faith and equip you for daily living.</p>
                </div>

                <div class="event-detail__expect-item reveal" data-delay="200">
                    <div class="event-detail__expect-icon"><i class="fas fa-users"></i></div>
                    <h4>Community</h4>
                    <p>Connect with other believers, share stories, and build relationships that go beyond the event.</p>
                </div>

                <div class="event-detail__expect-item reveal" data-delay="300">
                    <div class="event-detail__expect-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h4>Prayer</h4>
                    <p>Dedicated time for prayer, whether it's for personal breakthrough, healing or intercession for others.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- COMMUNITY CTA --}}
    <section class="event-detail__community">
        <div class="event-detail__community-bg">
            <div class="event-detail__community-shape event-detail__community-shape--1"></div>
            <div class="event-detail__community-shape event-detail__community-shape--2"></div>
        </div>
        <div class="wrap">
            <div class="event-detail__community-content reveal" data-delay="100">
                <div class="event-detail__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="event-detail__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="event-detail__community-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/events.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('eventRegistrationForm');
            const messageDiv = document.getElementById('registrationMessage');
            const submitBtn = document.getElementById('registerBtn');
            const btnText = document.getElementById('registerBtnText');
            const btnLoader = document.getElementById('registerBtnLoader');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // ─── SHOW LOADING ───
                    submitBtn.disabled = true;
                    btnText.style.display = 'none';
                    btnLoader.style.display = 'inline';

                    const formData = new FormData(this);

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(function(response) {
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error('Server returned HTML instead of JSON.');
                        }
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.success) {
                            // ─── BUILD CALENDAR LINK ───
                            const eventDate = new Date(data.event_date + 'T' + data.event_time);
                            const endDate = new Date(eventDate.getTime() + 2 * 60 * 60 * 1000); // 2 hours later
                            
                            const formatDate = function(date) {
                                return date.toISOString().replace(/-|:|\.\d+/g, '');
                            };
                            
                            const googleCalendarUrl = 'https://www.google.com/calendar/render?action=TEMPLATE' +
                                '&text=' + encodeURIComponent(data.event_title) +
                                '&dates=' + formatDate(eventDate) + '/' + formatDate(endDate) +
                                '&details=' + encodeURIComponent(data.event_description || '') +
                                '&location=' + encodeURIComponent(data.event_location || '') +
                                '&sf=true&output=xml';

                            const icsDownload = function() {
                                const icsContent = [
                                    'BEGIN:VCALENDAR',
                                    'VERSION:2.0',
                                    'PRODID:-//The Collective//Event//EN',
                                    'BEGIN:VEVENT',
                                    'UID:' + data.registration_id + '@thecollective.co.za',
                                    'DTSTAMP:' + formatDate(new Date()),
                                    'DTSTART:' + formatDate(eventDate),
                                    'DTEND:' + formatDate(endDate),
                                    'SUMMARY:' + data.event_title,
                                    'DESCRIPTION:' + (data.event_description || ''),
                                    'LOCATION:' + (data.event_location || ''),
                                    'END:VEVENT',
                                    'END:VCALENDAR'
                                ].join('\n');
                                
                                const blob = new Blob([icsContent], { type: 'text/calendar;charset=utf-8' });
                                const link = document.createElement('a');
                                link.href = URL.createObjectURL(blob);
                                link.download = data.event_title.replace(/\s+/g, '_') + '.ics';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                                URL.revokeObjectURL(link.href);
                            };

                            // ─── BUILD SUCCESS HTML ───
                            let html = `
                                <div class="registration-success">
                                    <div class="registration-success__icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <h4 class="registration-success__title">Registration Successful!</h4>
                                    <p class="registration-success__message">${data.message}</p>
                                    <div class="registration-success__id">
                                        <strong>Registration ID:</strong> ${data.registration_id}
                                    </div>
                                    <div class="registration-success__actions">
                                        <a href="${googleCalendarUrl}" target="_blank" class="btn btn--primary btn--sm">
                                            <i class="fas fa-calendar-plus"></i> Add to Google Calendar
                                        </a>
                                        <button onclick="${icsDownload.toString()}(); icsDownload();" class="btn btn--secondary btn--sm">
                                            <i class="fas fa-download"></i> Download .ics
                                        </button>
                                    </div>
                            `;

                            // ─── IF PAID EVENT, SHOW BANKING DETAILS ───
                            if (!data.is_free && data.banking_details) {
                                html += `
                                    <div class="registration-success__banking">
                                        <h5>Banking Details</h5>
                                        <div class="registration-success__banking-grid">
                                            <div>
                                                <span class="label">Bank</span>
                                                <span class="value">${data.banking_details.bank}</span>
                                            </div>
                                            <div>
                                                <span class="label">Account Name</span>
                                                <span class="value">${data.banking_details.account_name}</span>
                                            </div>
                                            <div>
                                                <span class="label">Account Number</span>
                                                <span class="value">${data.banking_details.account_number}</span>
                                            </div>
                                            <div>
                                                <span class="label">Branch Code</span>
                                                <span class="value">${data.banking_details.branch_code}</span>
                                            </div>
                                            <div style="grid-column: 1 / -1;">
                                                <span class="label">Reference</span>
                                                <span class="value" style="font-weight: 700; color: var(--gold);">${data.banking_details.reference}</span>
                                            </div>
                                            <div style="grid-column: 1 / -1; text-align: center; font-weight: 600; font-size: 1.1rem; padding-top: 8px; border-top: 1px solid rgba(21, 87, 36, 0.1);">
                                                Amount: R${data.amount}
                                            </div>
                                        </div>
                                        <p>
                                            <i class="fas fa-info-circle"></i> 
                                            Please use your Registration ID as reference when making payment.
                                        </p>
                                    </div>
                                `;
                            }

                            html += `</div>`;

                            messageDiv.innerHTML = html;
                            form.reset();

                            // ─── HIDE THE FORM ───
                            const formCard = form.closest('.event-detail__form-card');
                            if (formCard) {
                                const fields = formCard.querySelectorAll('.event-detail__form-group');
                                fields.forEach(function(field) {
                                    field.style.display = 'none';
                                });
                                const note = formCard.querySelector('.event-detail__form-note');
                                if (note) note.style.display = 'none';
                                const subtitle = formCard.querySelector('.event-detail__form-subtitle');
                                if (subtitle) subtitle.style.display = 'none';
                                const title = formCard.querySelector('.event-detail__form-title');
                                if (title) title.style.display = 'none';
                                submitBtn.style.display = 'none';
                            }

                            // ─── SHOW WHATSAPP POPUP ───
                            if (data.show_whatsapp) {
                                setTimeout(function() {
                                    const popup = document.getElementById('whatsappPopup');
                                    if (popup) {
                                        popup.classList.add('show');
                                    }
                                }, 1000);
                            }
                        }
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                        messageDiv.innerHTML = `
                            <div class="registration-error">
                                <i class="fas fa-exclamation-circle"></i>
                                Error: ${error.message || 'Something went wrong. Please try again.'}
                            </div>
                        `;
                    })
                    .finally(function() {
                        submitBtn.disabled = false;
                        btnText.style.display = 'inline';
                        btnLoader.style.display = 'none';
                    });
                });
            }
        });
    </script>
@endpush

@endsection