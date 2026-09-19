@extends('layouts.v150.app')

@section('title', $book->title . ' · ' . env('PROJECT_NAME', 'IN.iN'))

@section('content')

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
                            Bestseller
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
                        <button class="btn btn--primary btn--lg" id="showBuyForm">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                            <span>Buy Now</span>
                        </button>

                        @if($book->book_file)
                            <a href="{{ route('books.preview', $book->slug) }}" target="_blank" class="btn btn--outline btn--lg">
                                <i class="fas fa-book-open" aria-hidden="true"></i>
                                <span>Preview</span>
                            </a>
                        @endif
                    </div>

                    {{-- ─── BUY FORM (HIDDEN BY DEFAULT) ─── --}}
                    <div id="buyBookForm" style="display: none; margin-top: 32px;">
                        <div class="book-detail__buy-form">
                            <h4 class="book-detail__buy-form-title">Complete Your Purchase</h4>

                            <form id="paymentForm" method="POST" action="{{ route('payment.initiate') }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <input type="hidden" name="gateway" value="payfast">

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

                                    <button type="button" class="btn btn--outline" id="cancelBuyForm">
                                        Cancel
                                    </button>
                                </div>

                                <div id="paymentMessage" style="margin-top: 16px;"></div>
                            </form>
                        </div>
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

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/books.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ─── SHOW/HIDE BUY FORM ───
            const showBtn = document.getElementById('showBuyForm');
            const buyForm = document.getElementById('buyBookForm');
            const cancelBtn = document.getElementById('cancelBuyForm');

            if (showBtn && buyForm) {
                showBtn.addEventListener('click', function() {
                    buyForm.style.display = 'block';
                    showBtn.style.display = 'none';
                    buyForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }

            if (cancelBtn && buyForm) {
                cancelBtn.addEventListener('click', function() {
                    buyForm.style.display = 'none';
                    if (showBtn) showBtn.style.display = 'inline-flex';
                });
            }

            // ─── PAYMENT FORM SUBMIT ───
            const paymentForm = document.getElementById('paymentForm');
            const submitBtn = document.getElementById('buyNowBtn');
            const btnText = document.getElementById('buyBtnText');
            const btnLoader = document.getElementById('buyBtnLoader');
            const messageDiv = document.getElementById('paymentMessage');

            if (paymentForm) {
                paymentForm.addEventListener('submit', function(e) {
                    e.preventDefault();

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
                        } else {
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
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
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
        });
    </script>
@endpush

@endsection