@extends('layouts.v150.app')

@section('title', $book->title . ' · ' . env('PROJECT_NAME', 'IN.iN'))

@section('content')

@php
    // ─── PULL LIVE SHIPPING REGIONS FROM SETTINGS ───
    $regions = shipping_regions();
    $currency = currency_symbol();
@endphp

<div class="book-detail">

    {{-- ─── HERO — SPLIT LAYOUT ─── --}}
    <section class="book-detail__hero">
        <div class="book-detail__hero-bg">
            <div class="book-detail__hero-shape book-detail__hero-shape--1"></div>
            <div class="book-detail__hero-shape book-detail__hero-shape--2"></div>
        </div>

        <div class="wrap">
            {{-- ─── BREADCRUMB ─── --}}
            <div class="book-detail__breadcrumb">
                <a href="{{ route('books.index') }}">Books</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $book->title }}</span>
            </div>

            <div class="book-detail__hero-grid">
                {{-- ─── COVER LEFT ─── --}}
                <div class="book-detail__cover">
                    <div class="book-detail__cover-book">
                        @if($book->cover_image)
                            <img 
                                src="{{ asset('storage/books/covers/' . $book->cover_image) }}" 
                                alt="{{ $book->title }}"
                                class="book-detail__cover-img"
                            >
                        @else
                            <div class="book-detail__cover-placeholder" style="background: {{ $book->cover_color ?? '#00ff00' }};">
                                <span>{{ $book->title }}</span>
                            </div>
                        @endif

                        <div class="book-detail__cover-spine"></div>
                        <div class="book-detail__cover-shine"></div>
                    </div>

                    @if($book->is_featured)
                        <span class="book-detail__badge">
                            <i class="fas fa-star" aria-hidden="true"></i>
                            Featured
                        </span>
                    @endif
                </div>

                {{-- ─── INFO RIGHT ─── --}}
                <div class="book-detail__info">
                    <span class="book-detail__eyebrow">Book</span>

                    <h1 class="book-detail__title">{{ $book->title }}</h1>

                    @if($book->subtitle)
                        <p class="book-detail__subtitle">{{ $book->subtitle }}</p>
                    @endif

                    <p class="book-detail__desc">{{ $book->description }}</p>

                    <div class="book-detail__meta">
                        <span class="book-detail__price">{{ $book->formatted_price }}</span>

                        @if($book->file_type)
                            <span class="book-detail__meta-item">
                                <i class="fas fa-file-{{ $book->file_type === 'pdf' ? 'pdf' : 'alt' }}"></i>
                                {{ strtoupper($book->file_type) }}
                            </span>
                        @endif

                        @if($book->file_size)
                            <span class="book-detail__meta-item">
                                <i class="fas fa-hdd"></i>
                                {{ $book->file_size }}
                            </span>
                        @endif
                    </div>

                    <div class="book-detail__actions">
                        <button type="button" class="btn btn--primary btn--lg" data-modal-open="buyModal">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                            <span>Continue Shopping</span>
                        </button>

                        @if($book->has_hardcopy_option)
                            <span class="book-detail__hardcopy-badge">
                                <i class="fas fa-truck" aria-hidden="true"></i>
                                Hard copy available from {{ $book->formatted_hardcopy_price }}
                            </span>
                        @endif

                        <a class="btn btn--outline btn--lg disabled" aria-disabled="true">
                            <i class="fas fa-book-open" aria-hidden="true"></i>
                            <span>No Preview Available</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── RELATED BOOKS ─── --}}
    @if($relatedBooks->count() > 0)
        <section class="book-detail__related">
            <div class="book-detail__related-bg">
                <div class="book-detail__related-shape book-detail__related-shape--1"></div>
            </div>

            <div class="wrap">
                <div class="section-header">
                    <span class="section-header__eyebrow">More to Read</span>
                    <h2 class="section-header__title">Related <span>Books</span></h2>
                </div>

                <div class="book-detail__related-grid">
                    @foreach($relatedBooks as $related)
                        <div class="book-detail__related-card">
                            <div class="book-detail__related-cover">
                                @if($related->cover_image)
                                    <img 
                                        src="{{ asset('storage/books/covers/' . $related->cover_image) }}" 
                                        alt="{{ $related->title }}"
                                    >
                                @else
                                    <div class="book-detail__related-cover-placeholder" style="background: {{ $related->cover_color ?? '#00ff00' }};">
                                        <span>{{ $related->title }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="book-detail__related-info">
                                <h4 class="book-detail__related-title">{{ $related->title }}</h4>
                                <span class="book-detail__related-price">{{ $related->formatted_price }}</span>

                                <a href="{{ route('books.show', $related->slug) }}" class="book-detail__related-link">
                                    <span>View Book</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ─── COMMUNITY CTA ─── --}}
    <section class="book-detail__community">
        <div class="book-detail__community-bg">
            <div class="book-detail__community-shape book-detail__community-shape--1"></div>
            <div class="book-detail__community-shape book-detail__community-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="book-detail__community-content">
                <div class="book-detail__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <h2 class="book-detail__community-title">
                    Join the <span>conversation</span>
                </h2>

                <p class="book-detail__community-desc">
                    Be part of the community reading along with you.
                </p>

                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    <span>Join on WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── BUY MODAL ─── --}}
    <div class="book-detail__modal" id="buyModal" aria-hidden="true">
        <div class="book-detail__modal-overlay" data-modal-close></div>

        <div class="book-detail__modal-content" role="dialog" aria-modal="true" aria-labelledby="buyModalTitle">
            <button type="button" class="book-detail__modal-close" data-modal-close aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>

            <div class="book-detail__modal-header">
                <span class="book-detail__modal-eyebrow">Complete Your Purchase</span>
                <h3 class="book-detail__modal-title" id="buyModalTitle">{{ $book->title }}</h3>
                @if($book->subtitle)
                    <p class="book-detail__modal-subtitle">{{ $book->subtitle }}</p>
                @endif
            </div>

            <div class="book-detail__modal-body">
                <form id="paymentForm" method="POST" action="{{ route('payment.initiate') }}">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="hidden" name="gateway" value="payfast">

                    {{-- ─── DELIVERY TYPE ─── --}}
                    @if($book->has_hardcopy_option)
                        <div class="book-detail__delivery-choice">
                            <label class="book-detail__delivery-option book-detail__delivery-option--active">
                                <input type="radio" name="delivery_type" value="digital" checked>
                                <span class="book-detail__delivery-option-body">
                                    <span class="book-detail__delivery-option-icon">
                                        <i class="fas fa-download" aria-hidden="true"></i>
                                    </span>
                                    <span class="book-detail__delivery-option-text">
                                        <span class="book-detail__delivery-option-label">Digital copy</span>
                                        <span class="book-detail__delivery-option-desc">Instant download after payment</span>
                                    </span>
                                    <span class="book-detail__delivery-option-price">{{ $book->formatted_price }}</span>
                                </span>
                            </label>

                            <label class="book-detail__delivery-option">
                                <input type="radio" name="delivery_type" value="hardcopy">
                                <span class="book-detail__delivery-option-body">
                                    <span class="book-detail__delivery-option-icon">
                                        <i class="fas fa-truck" aria-hidden="true"></i>
                                    </span>
                                    <span class="book-detail__delivery-option-text">
                                        <span class="book-detail__delivery-option-label">Hard copy <span class="book-detail__delivery-option-bonus">+ digital free</span></span>
                                        <span class="book-detail__delivery-option-desc">Printed and posted to you</span>
                                    </span>
                                    <span class="book-detail__delivery-option-price">{{ $book->formatted_hardcopy_price }}</span>
                                </span>
                            </label>
                        </div>
                    @else
                        <input type="hidden" name="delivery_type" value="digital">
                    @endif

                    {{-- ─── BUYER DETAILS ─── --}}
                    <div class="book-detail__form-group">
                        <label for="buyer_name">Full Name</label>
                        <input type="text" name="name" id="buyer_name" placeholder="Your full name" required>
                    </div>

                    <div class="book-detail__form-group">
                        <label for="buyer_email">Email Address</label>
                        <input type="email" name="email" id="buyer_email" placeholder="your@email.com" required>
                    </div>

                    <div class="book-detail__form-group">
                        <label for="buyer_phone">Phone Number</label>
                        <input type="tel" name="phone" id="buyer_phone" placeholder="+27 71 000 0000">
                    </div>

                    {{-- ─── HARD COPY ADDRESS BLOCK ─── --}}
                    @if($book->has_hardcopy_option)
                        <div id="hardcopyFields" class="book-detail__hardcopy-fields" style="display: none;">
                            <div class="book-detail__hardcopy-title">
                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                Delivery Address
                            </div>

                            <div class="book-detail__form-group">
                                <label for="delivery_region">Delivery Region</label>
                                <select name="delivery_region" id="delivery_region">
                                    @foreach($regions as $key => $region)
                                        <option value="{{ $key }}" data-fee="{{ $region['fee'] }}" data-days="{{ $region['days'] }}">
                                            {{ $region['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="book-detail__form-row">
                                <div class="book-detail__form-group">
                                    <label for="delivery_address_1">Street Address</label>
                                    <input type="text" name="delivery_address_1" id="delivery_address_1" placeholder="123 Main Road">
                                </div>
                                <div class="book-detail__form-group">
                                    <label for="delivery_address_2">Unit / Complex (optional)</label>
                                    <input type="text" name="delivery_address_2" id="delivery_address_2" placeholder="Unit 4">
                                </div>
                            </div>

                            <div class="book-detail__form-row">
                                <div class="book-detail__form-group">
                                    <label for="delivery_suburb">Suburb</label>
                                    <input type="text" name="delivery_suburb" id="delivery_suburb" placeholder="Suburb">
                                </div>
                                <div class="book-detail__form-group">
                                    <label for="delivery_city">City</label>
                                    <input type="text" name="delivery_city" id="delivery_city" placeholder="City">
                                </div>
                            </div>

                            <div class="book-detail__form-row">
                                <div class="book-detail__form-group">
                                    <label for="delivery_province">Province / Region</label>
                                    <input type="text" name="delivery_province" id="delivery_province" placeholder="Province">
                                </div>
                                <div class="book-detail__form-group">
                                    <label for="delivery_postal_code">Postal Code</label>
                                    <input type="text" name="delivery_postal_code" id="delivery_postal_code" placeholder="0000">
                                </div>
                            </div>

                            <div class="book-detail__form-group">
                                <label for="delivery_country">Country</label>
                                <input type="text" name="delivery_country" id="delivery_country" value="South Africa">
                            </div>

                            <div class="book-detail__form-group">
                                <label for="delivery_notes">Delivery Notes (optional)</label>
                                <input type="text" name="delivery_notes" id="delivery_notes" placeholder="Gate code, best time to deliver, etc.">
                            </div>
                        </div>
                    @endif

                    {{-- ─── ORDER SUMMARY ─── --}}
                    @if($book->has_hardcopy_option)
                        <div class="book-detail__summary" id="orderSummary">
                            <div class="book-detail__summary-row">
                                <span>Book</span>
                                <span id="summaryBookPrice">{{ $book->formatted_price }}</span>
                            </div>
                            <div class="book-detail__summary-row" id="summaryShippingRow" style="display: none;">
                                <span>Shipping</span>
                                <span id="summaryShipping">—</span>
                            </div>
                            <div class="book-detail__summary-row book-detail__summary-row--total">
                                <span>Total</span>
                                <span id="summaryTotal">{{ $book->formatted_price }}</span>
                            </div>
                            <div class="book-detail__summary-note" id="summaryDeliveryNote" style="display: none;">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                <span id="summaryDeliveryDays">—</span>
                            </div>
                        </div>
                    @endif

                    <div class="book-detail__form-actions">
                        <button type="submit" class="btn btn--primary btn--lg" id="buyNowBtn">
                            <span id="buyBtnText">
                                <i class="fas fa-lock" aria-hidden="true"></i>
                                Pay {{ $book->formatted_price }}
                            </span>
                            <span id="buyBtnLoader" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                                Processing...
                            </span>
                        </button>

                        <button type="button" class="btn btn--outline" data-modal-close>
                            Cancel
                        </button>
                    </div>

                    <div id="paymentMessage" style="margin-top: 16px;"></div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/books.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ─── CURRENCY SYMBOL (READ FROM SETTINGS) ───
            const currency = @json($currency);

            // ─── PAYMENT FORM SUBMIT ───
            const paymentForm = document.getElementById('paymentForm');
            const submitBtn = document.getElementById('buyNowBtn');
            const btnText = document.getElementById('buyBtnText');
            const btnLoader = document.getElementById('buyBtnLoader');
            const messageDiv = document.getElementById('paymentMessage');

            if (paymentForm) {
                paymentForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // ─── SHOW CUSTOM PAGE SPINNER (app.js overlay) ───
                    if (typeof window.showAppOverlay === 'function') {
                        window.showAppOverlay();
                    }

                    submitBtn.disabled = true;
                    if (btnText) btnText.style.display = 'none';
                    if (btnLoader) btnLoader.style.display = 'inline';
                    if (messageDiv) messageDiv.innerHTML = '';

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
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect_url;
                            return;
                        }

                        // ─── HIDE CUSTOM PAGE SPINNER ON ERROR ───
                        if (typeof window.hideAppOverlay === 'function') {
                            window.hideAppOverlay();
                        }

                        let errorMessage = data.message || 'Something went wrong. Please try again.';

                        if (data.field === 'phone') {
                            const phoneInput = document.getElementById('buyer_phone');
                            if (phoneInput) {
                                phoneInput.style.borderColor = '#dc3545';
                                phoneInput.focus();
                                phoneInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }

                        if (data.field === 'email') {
                            const emailInput = document.getElementById('buyer_email');
                            if (emailInput) {
                                emailInput.style.borderColor = '#dc3545';
                                emailInput.focus();
                                emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }

                        if (messageDiv) {
                            messageDiv.innerHTML = `
                                <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 10px; border-left: 4px solid #dc3545;">
                                    <i class="fas fa-exclamation-circle"></i> 
                                    ${errorMessage}
                                </div>
                            `;
                        }

                        submitBtn.disabled = false;
                        if (btnText) btnText.style.display = 'inline';
                        if (btnLoader) btnLoader.style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // ─── HIDE CUSTOM PAGE SPINNER ON ERROR ───
                        if (typeof window.hideAppOverlay === 'function') {
                            window.hideAppOverlay();
                        }

                        if (messageDiv) {
                            messageDiv.innerHTML = `
                                <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 10px; border-left: 4px solid #dc3545;">
                                    <i class="fas fa-exclamation-circle"></i> 
                                    Payment initiation failed. Please try again.
                                </div>
                            `;
                        }
                        submitBtn.disabled = false;
                        if (btnText) btnText.style.display = 'inline';
                        if (btnLoader) btnLoader.style.display = 'none';
                    });
                });
            }

            // ─── DELIVERY TYPE TOGGLE + PRICE SUMMARY ───
            const digitalPrice = {{ (float) $book->getRawPriceAttribute() }};
            const hardcopyPrice = {{ (float) $book->hardcopy_price_raw }};
            const hasHardcopy = {{ $book->has_hardcopy_option ? 'true' : 'false' }};

            if (hasHardcopy) {
                const deliveryRadios = document.querySelectorAll('input[name="delivery_type"]');
                const hardcopyFields = document.getElementById('hardcopyFields');
                const summaryBookPrice = document.getElementById('summaryBookPrice');
                const summaryShippingRow = document.getElementById('summaryShippingRow');
                const summaryShipping = document.getElementById('summaryShipping');
                const summaryTotal = document.getElementById('summaryTotal');
                const summaryDeliveryNote = document.getElementById('summaryDeliveryNote');
                const summaryDeliveryDays = document.getElementById('summaryDeliveryDays');
                const buyBtnText = document.getElementById('buyBtnText');
                const regionSelect = document.getElementById('delivery_region');

                function fmt(n) {
                    return currency + ' ' + n.toFixed(2);
                }

                function getShippingFee() {
                    if (!regionSelect) return 0;
                    const opt = regionSelect.options[regionSelect.selectedIndex];
                    return parseFloat(opt.getAttribute('data-fee') || '0');
                }

                function getShippingDays() {
                    if (!regionSelect) return '';
                    const opt = regionSelect.options[regionSelect.selectedIndex];
                    return opt.getAttribute('data-days') || '';
                }

                function updateSummary() {
                    const selected = document.querySelector('input[name="delivery_type"]:checked');
                    const isHard = selected && selected.value === 'hardcopy';

                    // Update label active state
                    document.querySelectorAll('.book-detail__delivery-option').forEach(function (label) {
                        const input = label.querySelector('input');
                        label.classList.toggle('book-detail__delivery-option--active', input.checked);
                    });

                    // Toggle address fields
                    if (hardcopyFields) {
                        hardcopyFields.style.display = isHard ? 'block' : 'none';
                        hardcopyFields.querySelectorAll('input, select').forEach(function (el) {
                            el.required = isHard && el.dataset.required !== 'false';
                        });
                    }

                    if (isHard) {
                        const shipping = getShippingFee();
                        const bookPrice = hardcopyPrice;
                        const total = bookPrice + shipping;

                        summaryBookPrice.textContent = fmt(bookPrice);
                        summaryShippingRow.style.display = 'flex';
                        summaryShipping.textContent = fmt(shipping);
                        summaryTotal.textContent = fmt(total);
                        summaryDeliveryNote.style.display = 'flex';
                        summaryDeliveryDays.textContent = getShippingDays();
                        buyBtnText.innerHTML = '<i class="fas fa-lock"></i> Pay ' + fmt(total);
                    } else {
                        summaryBookPrice.textContent = fmt(digitalPrice);
                        summaryShippingRow.style.display = 'none';
                        summaryTotal.textContent = fmt(digitalPrice);
                        summaryDeliveryNote.style.display = 'none';
                        buyBtnText.innerHTML = '<i class="fas fa-lock"></i> Pay ' + fmt(digitalPrice);
                    }
                }

                deliveryRadios.forEach(function (radio) {
                    radio.addEventListener('change', updateSummary);
                });

                if (regionSelect) {
                    regionSelect.addEventListener('change', updateSummary);
                }

                updateSummary();
            }
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/books.css') }}">
@endpush

@endsection