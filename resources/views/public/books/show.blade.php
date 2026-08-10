@extends('layouts.app')

@section('title', $book->title . ' · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')

<div class="book-detail">

    {{-- BOOK DETAIL FLOATING ORBS --}}
    <div class="book-detail__orbs">
        <div class="book-detail__orb book-detail__orb--1"></div>
        <div class="book-detail__orb book-detail__orb--2"></div>
        <div class="book-detail__orb book-detail__orb--3"></div>
        <div class="book-detail__orb book-detail__orb--4"></div>
        <div class="book-detail__orb book-detail__orb--5"></div>
    </div>

    {{-- HERO — Book Detail --}}
    <section class="book-detail__hero">
        <div class="book-detail__hero-bg">
            <div class="book-detail__hero-shape book-detail__hero-shape--1"></div>
            <div class="book-detail__hero-shape book-detail__hero-shape--2"></div>
            <div class="book-detail__hero-particle book-detail__hero-particle--1"></div>
            <div class="book-detail__hero-particle book-detail__hero-particle--2"></div>
            <div class="book-detail__hero-particle book-detail__hero-particle--3"></div>
        </div>
        <div class="book-detail__hero-tag">BOOK</div>

        <div class="wrap">
            <div class="book-detail__hero-grid">
                {{-- LEFT: Book Cover --}}
                <div class="book-detail__hero-cover">
                    @if($book->cover_image)
                        <div class="book-detail__hero-placeholder {{ $book->cover_image ? 'book-detail__hero-placeholder--with-image' : '' }}" style="background:{{ $book->cover_color ?? '#2d2d44' }}; position: relative; overflow: hidden;">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/books/covers/' . $book->cover_image) }}" 
                                    alt="{{ $book->title }}" 
                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                            @endif
                            <span class="book-detail__hero-placeholder-title" style="position: relative; z-index: 2;">
                                {{ $book->title }}
                            </span>
                            <small class="book-detail__hero-placeholder-author" style="position: relative; z-index: 2;">Arthur Mongalo</small>
                            <div class="book-detail__hero-placeholder-shine"></div>
                        </div>
                    @else
                        <div class="book-detail__hero-placeholder" style="background:{{ $book->cover_color ?? '#2d2d44' }};">
                            <span class="book-detail__hero-placeholder-title">{{ $book->title }}</span>
                            <small class="book-detail__hero-placeholder-author">Arthur Mongalo</small>
                            <div class="book-detail__hero-placeholder-shine"></div>
                        </div>
                    @endif
                </div>

                {{-- RIGHT: Book Info --}}
                <div class="book-detail__hero-content">
                    <span class="book-detail__hero-badge">
                        <i class="fas fa-book"></i> 
                        @if($book->is_free)
                            Free Resource
                        @else
                            Book
                        @endif
                    </span>
                    <h1 class="book-detail__hero-title">{{ $book->title }}</h1>
                    @if($book->subtitle)
                        <p class="book-detail__hero-subtitle">{{ $book->subtitle }}</p>
                    @endif

                    <div class="book-detail__hero-meta">
                        <span class="book-detail__hero-price">{{ $book->formatted_price }}</span>
                        @if($book->is_featured)
                            <span class="book-detail__hero-badge--featured">★ Bestseller</span>
                        @endif
                        @if($book->is_free)
                            <span class="book-detail__hero-badge--free">Free Download</span>
                        @endif
                        @if($book->book_file)
                            <span class="book-detail__hero-badge--featured" style="background: #d4edda; color: #155724; border-color: #b7dfb9;">
                                <i class="fas fa-file-{{ $book->file_type }}"></i> 
                                {{ strtoupper($book->file_type) }} · {{ $book->file_size ?? 'Available' }}
                            </span>
                        @endif
                    </div>

                    <p class="book-detail__hero-text">{{ $book->description }}</p>

                    <div class="book-detail__hero-actions">
                        @if($book->is_free && $book->book_file)
                            {{-- ─── FREE DOWNLOAD ─── --}}
                            <a href="{{ route('payment.download', $book->id) }}" class="btn btn--primary btn--lg">
                                <i class="fas fa-download"></i> Download Free
                            </a>
                        @elseif($book->book_file && !$book->is_free)
                            {{-- ─── PAID BOOK - SHOW BUY FORM ─── --}}
                            <div id="buyBookContainer">
                                <button class="btn btn--primary btn--lg" id="showBuyForm">
                                    <i class="fas fa-shopping-cart"></i> Buy Now
                                </button>
                                <a href="#" class="btn btn--outline" onclick="event.preventDefault(); alert('Preview coming soon.');">
                                    <i class="fas fa-book-open"></i> Preview
                                </a>
                            </div>

                            {{-- ─── BUY FORM ─── --}}
                            <div id="buyBookForm" style="display: none; width: 100%; margin-top: 16px;">
                                <div class="buy-book-form">
                                    <h4 style="font-family: var(--font-serif); font-weight: 700; margin-bottom: 12px;">Enter Your Details</h4>
                                    <form id="paymentForm" method="POST" action="{{ route('payment.initiate') }}">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <input type="hidden" name="gateway" value="payfast">

                                        <div class="buy-book-form__group">
                                            <label for="buyer_name">Full Name <span class="required">*</span></label>
                                            <input type="text" name="name" id="buyer_name" placeholder="Thabo Mokoena" required>
                                        </div>

                                        <div class="buy-book-form__group">
                                            <label for="buyer_email">Email Address <span class="required">*</span></label>
                                            <input type="email" name="email" id="buyer_email" placeholder="thabo@example.co.za" required>
                                        </div>

                                        <div class="buy-book-form__group">
                                            <label for="buyer_phone">Phone Number</label>
                                            <input type="tel" name="phone" id="buyer_phone" placeholder="+27 71 000 0000">
                                        </div>

                                        <div class="buy-book-form__actions">
                                            <button type="submit" class="btn btn--primary btn--lg" id="buyNowBtn">
                                                <span id="buyBtnText"><i class="fas fa-lock"></i> Pay Now</span>
                                                <span id="buyBtnLoader" style="display: none;">
                                                    <i class="fas fa-spinner fa-spin"></i> Processing...
                                                </span>
                                            </button>
                                            <button type="button" class="btn btn--secondary" id="cancelBuyForm">
                                                Cancel
                                            </button>
                                        </div>

                                        <div id="paymentMessage" style="margin-top: 12px;"></div>
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- ─── NO FILE UPLOADED ─── --}}
                            <div class="book-detail__hero-notice" style="background: #fff3cd; color: #856404; padding: 12px 20px; border-radius: 10px; font-size: 0.85rem;">
                                <i class="fas fa-info-circle"></i> 
                                This book will be available soon. Check back later.
                            </div>
                        @endif
                    </div>

                    <div class="book-detail__hero-features">
                        @if($book->book_file)
                            <span><i class="fas fa-check-circle"></i> Instant Download</span>
                            <span><i class="fas fa-check-circle"></i> Secure Access</span>
                            @if(!$book->is_free)
                                <span><i class="fas fa-check-circle"></i> One-time Purchase</span>
                            @endif
                        @endif
                        <span><i class="fas fa-check-circle"></i> Read on Any Device</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RELATED BOOKS --}}
    @if($relatedBooks->count() > 0)
        <section class="book-detail__related">
            <div class="book-detail__related-bg">
                <div class="book-detail__related-shape book-detail__related-shape--1"></div>
                <div class="book-detail__related-shape book-detail__related-shape--2"></div>
            </div>
            <div class="book-detail__related-tag">RELATED</div>
            <div class="wrap">
                <div class="section-header">
                    <span class="section-header__eyebrow">You Might Also Like</span>
                    <h2 class="section-header__title">Related <span>Books</span></h2>
                </div>

                <div class="book-detail__related-grid">
                    @foreach($relatedBooks as $related)
                        <div class="book-detail__related-card reveal reveal--scale" data-delay="{{ $loop->index * 100 }}">
                            <div class="book-detail__related-cover {{ $related->cover_image ? 'book-detail__related-cover--with-image' : '' }}" style="background:{{ $related->cover_color ?? '#a67c4e' }}; position: relative; overflow: hidden;">
                                @if($related->cover_image)
                                    <img src="{{ asset('storage/books/covers/' . $related->cover_image) }}" 
                                         alt="{{ $related->title }}" 
                                         style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                                @endif
                                <span class="book-detail__related-cover-title" style="position: relative; z-index: 2;">
                                    {{ $related->title }}
                                </span>
                                <div class="book-detail__related-cover-shine"></div>
                            </div>
                            <div class="book-detail__related-info">
                                <h4 class="book-detail__related-name">{{ $related->title }}</h4>
                                <span class="book-detail__related-price">{{ $related->formatted_price }}</span>
                                <a href="{{ route('books.show', $related->slug) }}" class="btn btn--primary btn--sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- COMMUNITY CTA --}}
    <section class="book-detail__community">
        <div class="book-detail__community-bg">
            <div class="book-detail__community-shape book-detail__community-shape--1"></div>
            <div class="book-detail__community-shape book-detail__community-shape--2"></div>
        </div>
        <div class="wrap">
            <div class="book-detail__community-content reveal" data-delay="100">
                <div class="book-detail__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="book-detail__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="book-detail__community-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/books.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ─── SHOW BUY FORM ───
            const showBtn = document.getElementById('showBuyForm');
            const buyForm = document.getElementById('buyBookForm');
            const cancelBtn = document.getElementById('cancelBuyForm');
            const container = document.getElementById('buyBookContainer');

            if (showBtn && buyForm) {
                showBtn.addEventListener('click', function() {
                    buyForm.style.display = 'block';
                    if (container) container.style.display = 'none';
                });
            }

            if (cancelBtn && buyForm) {
                cancelBtn.addEventListener('click', function() {
                    buyForm.style.display = 'none';
                    if (container) container.style.display = 'block';
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

                    // ─── SHOW LOADING ───
                    submitBtn.disabled = true;
                    btnText.style.display = 'none';
                    btnLoader.style.display = 'inline';
                    messageDiv.innerHTML = '';

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
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.success) {
                            // ─── REDIRECT TO CHECKOUT ───
                            window.location.href = data.redirect_url;
                        } else {
                            // ─── CHECK FOR FIELD-SPECIFIC ERRORS ───
                            let errorMessage = data.message || 'Something went wrong. Please try again.';
                            
                            // ─── IF PHONE ERROR, HIGHLIGHT PHONE FIELD ───
                            if (data.field === 'phone') {
                                const phoneInput = document.getElementById('buyer_phone');
                                if (phoneInput) {
                                    phoneInput.style.borderColor = '#dc3545';
                                    phoneInput.focus();
                                    // ─── SCROLL TO PHONE FIELD ───
                                    phoneInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            }
                            
                            // ─── IF EMAIL ERROR, HIGHLIGHT EMAIL FIELD ───
                            if (data.field === 'email') {
                                const emailInput = document.getElementById('buyer_email');
                                if (emailInput) {
                                    emailInput.style.borderColor = '#dc3545';
                                    emailInput.focus();
                                    emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            }

                            messageDiv.innerHTML = `
                                <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 10px; border-left: 4px solid #dc3545;">
                                    <i class="fas fa-exclamation-circle"></i> 
                                    ${errorMessage}
                                </div>
                            `;
                            
                            // ─── RESET BUTTON ───
                            submitBtn.disabled = false;
                            btnText.style.display = 'inline';
                            btnLoader.style.display = 'none';
                        }
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                        messageDiv.innerHTML = `
                            <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 10px; border-left: 4px solid #dc3545;">
                                <i class="fas fa-exclamation-circle"></i> 
                                Payment initiation failed. Please try again.
                            </div>
                        `;
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