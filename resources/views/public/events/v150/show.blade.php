@extends('layouts.v150.app')

@section('title', $event->title . ' · ' . env('PROJECT_NAME', 'IN.iN'))

@section('content')

<div class="event-detail">

    {{-- ─── SECTION 1: HERO WITH REGISTRATION ─── --}}
    <section class="event-detail__hero">
        <div class="event-detail__hero-bg">
            <img 
                src="https://images.unsplash.com/photo-1519677100203-a0e668c92439?w=1920&q=80" 
                alt="Event venue with warm lighting"
                class="event-detail__hero-bg-img"
                loading="eager"
            >
            <div class="event-detail__hero-overlay"></div>
            <div class="event-detail__hero-particles" id="eventDetailParticles"></div>
        </div>

        <div class="wrap">
            {{-- ─── BREADCRUMB ─── --}}
            <div class="event-detail__breadcrumb">
                <a href="{{ route('events.index') }}">Events</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $event->title }}</span>
            </div>

            <div class="event-detail__hero-grid">
                {{-- ─── LEFT: INFO ─── --}}
                <div class="event-detail__hero-info">
                    <span class="event-detail__hero-eyebrow">
                        <span class="event-detail__hero-eyebrow-line"></span>
                        {{ $event->date->isFuture() ? 'Upcoming Event' : 'Past Event' }}
                    </span>

                    <h1 class="event-detail__hero-title">
                        {{ $event->title }}
                    </h1>

                    @if($event->description)
                        <p class="event-detail__hero-desc">
                            {{ $event->description }}
                        </p>
                    @endif

                    <div class="event-detail__hero-meta">
                        <div class="event-detail__hero-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $event->date->format('l, F j, Y') }}</span>
                        </div>
                        <div class="event-detail__hero-meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                        </div>
                        <div class="event-detail__hero-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                        @if(!$event->is_free && $event->price > 0)
                            <div class="event-detail__hero-meta-item">
                                <i class="fas fa-tag"></i>
                                <span>R{{ number_format($event->price, 2) }} per person</span>
                            </div>
                        @else
                            <div class="event-detail__hero-meta-item event-detail__hero-meta-item--free">
                                <i class="fas fa-gift"></i>
                                <span>Free Event</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ─── RIGHT: DATE CARD + FORM ─── --}}
                <div class="event-detail__hero-form-col">

                    {{-- ─── COMPACT DATE CARD ─── --}}
                    <div class="event-detail__mini-date">
                        <div class="event-detail__mini-date-inner">
                            <div class="event-detail__mini-date-left">
                                <span class="event-detail__mini-date-month">{{ $event->date->format('M') }}</span>
                                <span class="event-detail__mini-date-day">{{ $event->date->format('d') }}</span>
                            </div>
                            <div class="event-detail__mini-date-divider"></div>
                            <div class="event-detail__mini-date-right">
                                <span class="event-detail__mini-date-time">
                                    {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                </span>
                                <span class="event-detail__mini-date-year">
                                    {{ $event->date->format('Y') }}
                                </span>
                            </div>
                            <span class="event-detail__mini-date-badge">
                                @if($event->is_free)
                                    <i class="fas fa-gift"></i> Free
                                @else
                                    <i class="fas fa-tag"></i> R{{ number_format($event->price, 2) }}
                                @endif
                            </span>
                        </div>
                    </div>

                    {{-- ─── REGISTRATION FORM WRAP ─── --}}
                    <div class="event-detail__form-wrap" id="registrationFormCard">

                        {{-- ─── FORM HEADER ─── --}}
                        <div class="event-detail__form-header">
                            <h3 class="event-detail__form-title">Register Now</h3>
                            <p class="event-detail__form-subtitle">
                                @if($event->is_free)
                                    Free — takes 30 seconds
                                @else
                                    R{{ number_format($event->price, 2) }} per person
                                @endif
                            </p>
                        </div>

                        {{-- ─── MESSAGE CONTAINER ─── --}}
                        <div id="registrationMessage"></div>

                        {{-- ─── FORM ─── --}}
                        <form id="eventRegistrationForm" method="POST" action="{{ route('events.register') }}">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                            <div class="event-detail__form-group">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" id="name" placeholder="Your full name" required>
                            </div>

                            <div class="event-detail__form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" placeholder="your@email.com" required>
                            </div>

                            <div class="event-detail__form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" required>
                            </div>

                            <button type="submit" class="btn btn--primary btn--block" id="registerBtn">
                                <span id="registerBtnText">
                                    <i class="fas fa-ticket-alt" aria-hidden="true"></i>
                                    Register Now
                                </span>
                                <span id="registerBtnLoader" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    Registering...
                                </span>
                            </button>
                        </form>

                        <p class="event-detail__form-note">
                            <i class="fas fa-lock"></i>
                            Your information is safe with us.
                        </p>
                    </div>

                    {{-- ─── PENDING REGISTRATION (HIDDEN BY DEFAULT) ─── --}}
                    <div class="event-detail__pending" id="pendingRegistrationContainer" style="display: none;">
                        <div class="event-detail__pending-header">
                            <div class="event-detail__pending-icon" id="pendingIcon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h4 class="event-detail__pending-title" id="pendingTitle">You're Registered!</h4>
                        </div>

                        <div class="event-detail__pending-details">
                            <div class="event-detail__pending-row">
                                <span class="event-detail__pending-label">Name</span>
                                <span class="event-detail__pending-value" id="pendingName"></span>
                            </div>
                            <div class="event-detail__pending-row">
                                <span class="event-detail__pending-label">Email</span>
                                <span class="event-detail__pending-value" id="pendingEmail"></span>
                            </div>
                            <div class="event-detail__pending-row">
                                <span class="event-detail__pending-label">Phone</span>
                                <span class="event-detail__pending-value" id="pendingPhone"></span>
                            </div>
                            <div class="event-detail__pending-row">
                                <span class="event-detail__pending-label">Registration ID</span>
                                <span class="event-detail__pending-value event-detail__pending-value--highlight" id="pendingRegId"></span>
                            </div>
                            <div class="event-detail__pending-row">
                                <span class="event-detail__pending-label">Status</span>
                                <span id="pendingStatus"></span>
                            </div>
                        </div>

                        {{-- ─── BANKING DETAILS (SHOWN IF PENDING PAYMENT) ─── --}}
                        <div id="pendingBanking" class="event-detail__pending-banking" style="display: none;">
                            <h5 class="event-detail__pending-banking-title">
                                <i class="fas fa-credit-card"></i>
                                Complete Payment
                            </h5>

                            <div class="event-detail__pending-banking-grid">
                                <div>
                                    <span class="event-detail__pending-banking-label">Bank</span>
                                    <span class="event-detail__pending-banking-value" id="pendingBank"></span>
                                </div>
                                <div>
                                    <span class="event-detail__pending-banking-label">Account Name</span>
                                    <span class="event-detail__pending-banking-value" id="pendingAccountName"></span>
                                </div>
                                <div>
                                    <span class="event-detail__pending-banking-label">Account Number</span>
                                    <span class="event-detail__pending-banking-value" id="pendingAccountNumber"></span>
                                </div>
                                <div>
                                    <span class="event-detail__pending-banking-label">Branch Code</span>
                                    <span class="event-detail__pending-banking-value" id="pendingBranchCode"></span>
                                </div>
                                <div class="event-detail__pending-banking-ref">
                                    <span class="event-detail__pending-banking-label">Reference</span>
                                    <span class="event-detail__pending-banking-value event-detail__pending-banking-value--gold" id="pendingReference"></span>
                                </div>
                            </div>

                            <div class="event-detail__pending-banking-note">
                                <i class="fas fa-hourglass-half"></i>
                                Please complete payment within <strong>48 hours</strong>.
                            </div>
                        </div>

                        <div class="event-detail__pending-actions">
                            <a href="{{ route('contact') }}" class="event-detail__pending-btn">
                                <i class="fas fa-envelope"></i>
                                <span>Need Help?</span>
                            </a>

                            <button type="button" onclick="window.print()" class="event-detail__pending-btn">
                                <i class="fas fa-print"></i>
                                <span>Print</span>
                            </button>

                            <form method="POST" action="{{ route('events.clear.registration') }}" style="display: contents;" id="clearRegistrationForm">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="event_slug" value="{{ $event->slug }}">
                                <button type="submit" class="event-detail__pending-btn">
                                    <i class="fas fa-redo"></i>
                                    <span>New Registration</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ─── SCROLL INDICATOR ─── --}}
        <div class="event-detail__hero-scroll">
            <span class="event-detail__hero-scroll-line"></span>
            <span class="event-detail__hero-scroll-text">Scroll</span>
        </div>
    </section>

    {{-- ─── SECTION 2: WHAT TO EXPECT ─── --}}
    <section class="event-detail__expect">
        <div class="event-detail__expect-bg">
            <div class="event-detail__expect-shape event-detail__expect-shape--1"></div>
            <div class="event-detail__expect-shape event-detail__expect-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">A Day of Transformation</span>
                <h2 class="section-header__title">What to <span>Expect</span></h2>
                <p class="section-header__subtitle">
                    Every gathering is designed around these four elements.
                </p>
            </div>

            <div class="event-detail__expect-grid">
                <div class="event-detail__expect-item">
                    <div class="event-detail__expect-icon">
                        <i class="fas fa-praying-hands"></i>
                    </div>
                    <h4 class="event-detail__expect-title">Worship</h4>
                    <p class="event-detail__expect-desc">
                        Time set aside to worship freely and encounter God's presence together.
                    </p>
                </div>

                <div class="event-detail__expect-item">
                    <div class="event-detail__expect-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h4 class="event-detail__expect-title">Teaching</h4>
                    <p class="event-detail__expect-desc">
                        Practical, Scripture-based teaching to strengthen your faith.
                    </p>
                </div>

                <div class="event-detail__expect-item">
                    <div class="event-detail__expect-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 class="event-detail__expect-title">Community</h4>
                    <p class="event-detail__expect-desc">
                        Connect with other believers and build relationships that last.
                    </p>
                </div>

                <div class="event-detail__expect-item">
                    <div class="event-detail__expect-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4 class="event-detail__expect-title">Prayer</h4>
                    <p class="event-detail__expect-desc">
                        Dedicated time for prayer — for breakthrough, healing and intercession.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 3: OTHER EVENTS STRIP ─── --}}
    <section class="event-detail__other">
        <div class="event-detail__other-bg">
            <div class="event-detail__other-shape event-detail__other-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="event-detail__other-content">
                <div class="event-detail__other-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>

                <div class="event-detail__other-text">
                    <h3 class="event-detail__other-title">
                        More <span>gatherings</span>
                    </h3>
                    <p class="event-detail__other-desc">
                        Explore other upcoming events and see what's next.
                    </p>
                </div>

                <a href="{{ route('events.index') }}" class="event-detail__other-btn">
                    <span>All Events</span>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 4: COMMUNITY CTA ─── --}}
    <section class="event-detail__community">
        <div class="event-detail__community-bg">
            <div class="event-detail__community-shape event-detail__community-shape--1"></div>
            <div class="event-detail__community-shape event-detail__community-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="event-detail__community-content">
                <div class="event-detail__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <h2 class="event-detail__community-title">
                    Never miss an <span>event</span>
                </h2>

                <p class="event-detail__community-desc">
                    Join the community and be the first to hear about new events and gatherings.
                </p>

                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    <span>Join on WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/events.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── CONSTANTS ───
        const EVENT_ID = {{ $event->id }};
        const STORAGE_KEY = 'pending_registration_' + EVENT_ID;
        const pendingContainer = document.getElementById('pendingRegistrationContainer');
        const formCard = document.getElementById('registrationFormCard');

        // ─── LOAD PENDING REGISTRATION ───
        function loadPendingRegistration() {
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored) {
                try {
                    const data = JSON.parse(stored);
                    if (data.expires_at && new Date(data.expires_at) < new Date()) {
                        localStorage.removeItem(STORAGE_KEY);
                        return false;
                    }
                    return data;
                } catch (e) {
                    localStorage.removeItem(STORAGE_KEY);
                    return false;
                }
            }
            return false;
        }

        // ─── SHOW PENDING REGISTRATION ───
        function showPendingRegistration(data) {
            if (pendingContainer) pendingContainer.style.display = 'block';
            if (formCard) formCard.style.display = 'none';

            const nameEl = document.getElementById('pendingName');
            const emailEl = document.getElementById('pendingEmail');
            const phoneEl = document.getElementById('pendingPhone');
            const regIdEl = document.getElementById('pendingRegId');
            const statusEl = document.getElementById('pendingStatus');
            const iconEl = document.getElementById('pendingIcon');
            const titleEl = document.getElementById('pendingTitle');

            if (nameEl) nameEl.textContent = data.name;
            if (emailEl) emailEl.textContent = data.email;
            if (phoneEl) phoneEl.textContent = data.phone;
            if (regIdEl) regIdEl.textContent = data.registration_id;

            if (statusEl) {
                if (data.payment_status === 'paid' || data.is_free) {
                    statusEl.innerHTML = '<span class="event-detail__badge event-detail__badge--success">Confirmed</span>';
                    if (iconEl) iconEl.innerHTML = '<i class="fas fa-check-circle"></i>';
                    if (titleEl) titleEl.textContent = "You're Registered!";
                } else {
                    statusEl.innerHTML = '<span class="event-detail__badge event-detail__badge--pending">Pending Payment</span>';
                    if (iconEl) iconEl.innerHTML = '<i class="fas fa-clock"></i>';
                    if (titleEl) titleEl.textContent = 'Payment Pending';
                }
            }

            const bankingEl = document.getElementById('pendingBanking');
            if (bankingEl) {
                if (data.banking_details && !data.is_free && data.payment_status === 'pending') {
                    bankingEl.style.display = 'block';
                    const bankEl = document.getElementById('pendingBank');
                    const accountNameEl = document.getElementById('pendingAccountName');
                    const accountNumberEl = document.getElementById('pendingAccountNumber');
                    const branchCodeEl = document.getElementById('pendingBranchCode');
                    const referenceEl = document.getElementById('pendingReference');

                    if (bankEl) bankEl.textContent = data.banking_details.bank;
                    if (accountNameEl) accountNameEl.textContent = data.banking_details.account_name;
                    if (accountNumberEl) accountNumberEl.textContent = data.banking_details.account_number;
                    if (branchCodeEl) branchCodeEl.textContent = data.banking_details.branch_code;
                    if (referenceEl) referenceEl.textContent = data.banking_details.reference;
                } else {
                    bankingEl.style.display = 'none';
                }
            }
        }

        // ─── CHECK ON LOAD ───
        const pendingData = loadPendingRegistration();
        if (pendingData) {
            showPendingRegistration(pendingData);
        }

        // ─── REGISTRATION FORM ───
        const form = document.getElementById('eventRegistrationForm');
        const messageDiv = document.getElementById('registrationMessage');
        const submitBtn = document.getElementById('registerBtn');
        const btnText = document.getElementById('registerBtnText');
        const btnLoader = document.getElementById('registerBtnLoader');

        if (form && !pendingData) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                submitBtn.disabled = true;
                if (btnText) btnText.style.display = 'none';
                if (btnLoader) btnLoader.style.display = 'inline';

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
                        localStorage.setItem(STORAGE_KEY, JSON.stringify(data.registration_data));

                        // ─── BUILD SUCCESS HTML ───
                        let html = '<div class="event-detail__success">';
                        html += '<div class="event-detail__success-icon"><i class="fas fa-check-circle"></i></div>';
                        html += '<h4 class="event-detail__success-title">Registration Successful!</h4>';
                        html += '<p class="event-detail__success-msg">' + data.message + '</p>';
                        html += '<div class="event-detail__success-id"><strong>Registration ID:</strong> ' + data.registration_id + '</div>';
                        html += '<div class="event-detail__success-actions">';
                        html += '<button onclick="window.location.reload()" class="btn btn--primary btn--sm"><i class="fas fa-eye"></i> View Status</button>';
                        html += '</div>';

                        if (!data.is_free && data.banking_details) {
                            html += '<div class="event-detail__success-banking">';
                            html += '<h5>Banking Details</h5>';
                            html += '<div class="event-detail__success-banking-grid">';
                            html += '<div><span class="label">Bank</span><span class="value">' + data.banking_details.bank + '</span></div>';
                            html += '<div><span class="label">Account Name</span><span class="value">' + data.banking_details.account_name + '</span></div>';
                            html += '<div><span class="label">Account Number</span><span class="value">' + data.banking_details.account_number + '</span></div>';
                            html += '<div><span class="label">Branch Code</span><span class="value">' + data.banking_details.branch_code + '</span></div>';
                            html += '<div class="full"><span class="label">Reference</span><span class="value value--gold">' + data.banking_details.reference + '</span></div>';
                            html += '<div class="full full--amount"><span>Amount: R' + data.amount + '</span></div>';
                            html += '</div>';
                            html += '<p><i class="fas fa-info-circle"></i> Please use your Registration ID as reference when making payment.</p>';
                            html += '</div>';
                        }

                        html += '</div>';

                        if (messageDiv) messageDiv.innerHTML = html;

                        // ─── HIDE FORM ───
                        const formGroups = formCard.querySelectorAll('.event-detail__form-group');
                        formGroups.forEach(function(el) { el.style.display = 'none'; });
                        const header = formCard.querySelector('.event-detail__form-header');
                        if (header) header.style.display = 'none';
                        if (submitBtn) submitBtn.style.display = 'none';
                        const note = formCard.querySelector('.event-detail__form-note');
                        if (note) note.style.display = 'none';
                    } else {
                        if (data.existing) {
                            if (messageDiv) {
                                messageDiv.innerHTML = '<div class="event-detail__info"><i class="fas fa-info-circle"></i><div><strong>' + data.message + '</strong><br><span>Registration ID: ' + data.registration_id + '</span><br><button onclick="window.location.reload()" class="btn btn--primary btn--sm" style="margin-top: 8px;"><i class="fas fa-eye"></i> View Status</button></div></div>';
                            }
                        } else {
                            let errorMessage = data.message || 'Something went wrong. Please try again.';

                            if (data.field === 'phone') {
                                const phoneInput = document.getElementById('phone');
                                if (phoneInput) {
                                    phoneInput.style.borderColor = '#dc3545';
                                    phoneInput.focus();
                                    phoneInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            }

                            if (data.field === 'email') {
                                const emailInput = document.getElementById('email');
                                if (emailInput) {
                                    emailInput.style.borderColor = '#dc3545';
                                    emailInput.focus();
                                    emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            }

                            if (messageDiv) {
                                messageDiv.innerHTML = '<div class="event-detail__error"><i class="fas fa-exclamation-circle"></i> ' + errorMessage + '</div>';
                            }
                        }
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    if (messageDiv) {
                        messageDiv.innerHTML = '<div class="event-detail__error"><i class="fas fa-exclamation-circle"></i> Error: ' + (error.message || 'Something went wrong. Please try again.') + '</div>';
                    }
                })
                .finally(function() {
                    submitBtn.disabled = false;
                    if (btnText) btnText.style.display = 'inline';
                    if (btnLoader) btnLoader.style.display = 'none';
                });
            });
        }

        // ─── CLEAR REGISTRATION ───
        const clearForm = document.getElementById('clearRegistrationForm');
        if (clearForm) {
            clearForm.addEventListener('submit', function() {
                localStorage.removeItem(STORAGE_KEY);
            });
        }
    });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/events.css') }}">
@endpush

@endsection