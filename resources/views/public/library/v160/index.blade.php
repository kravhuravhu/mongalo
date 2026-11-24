@extends('layouts.v160.app')

@section('title', ($tab === 'books' ? 'Books Library' : 'Free Resources') . ' | ' . config('seo.site_name'))

@section('meta_description', $tab === 'books'
    ? 'Browse the books library: Divine Identity, My Salvation Companion and more. Digital and hardcopy editions available. Deep-dive teaching on baptism, identity in Christ and the New Covenant.'
    : 'Free Christian literature: booklets, pamphlets, small Bibles and study guides. Free forever, instant download, share freely. All costs covered by Arthur.')
@section('page-class', 'page-library')

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v160/library.css') }}">
@endpush

@section('content')
    @php
        // ─── SHIPPING + CURRENCY (LIVE FROM SETTINGS) ───
        $regions = shipping_regions();
        $currency = currency_symbol();
        // ─── RESOURCE COLOUR PALETTE (SHUFFLED, NEVER REPEATS BACK TO BACK) ───
        $palette = [
            ['bg' => '#FF7A21', 'fg' => '#FFFFFF', 'title' => '#FDE7D6', 'sub' => 'rgba(253, 231, 214, 0.8)', 'label' => 'rgba(30, 42, 68, 0.8)', 'rule' => 'rgba(30, 42, 68, 0.7)', 'icon' => '#1E2A44', 'foot' => '#1E2A44'],
            ['bg' => '#5F8F91', 'fg' => '#1E2A44', 'title' => '#1E2A44', 'sub' => 'rgba(30, 42, 68, 0.85)', 'label' => 'rgba(30, 42, 68, 0.8)', 'rule' => 'rgba(30, 42, 68, 0.6)', 'icon' => '#1E2A44', 'foot' => '#1E2A44'],
            ['bg' => '#3E1A08', 'fg' => '#E9DCCF', 'title' => '#E9DCCF', 'sub' => 'rgba(255, 255, 255, 0.75)', 'label' => 'rgba(255, 255, 255, 0.75)', 'rule' => 'rgba(255, 255, 255, 0.5)', 'icon' => '#E9DCCF', 'foot' => 'rgba(255, 255, 255, 0.85)'],
            ['bg' => '#C9B0A6', 'fg' => '#1E2A44', 'title' => '#1E2A44', 'sub' => 'rgba(30, 42, 68, 0.8)', 'label' => 'rgba(30, 42, 68, 0.75)', 'rule' => 'rgba(30, 42, 68, 0.6)', 'icon' => '#1E2A44', 'foot' => '#1E2A44'],
            ['bg' => '#1E2A44', 'fg' => '#E3AC4A', 'title' => '#EDEAE3', 'sub' => 'rgba(255, 255, 255, 0.75)', 'label' => '#E3AC4A', 'rule' => 'rgba(255, 255, 255, 0.4)', 'icon' => '#E3AC4A', 'foot' => 'rgba(255, 255, 255, 0.85)'],
        ];
        $order = collect($palette)->shuffle(crc32('library-resources'))->values()->all();
        // ─── BOOK LABELS (KEYED BY SLUG, SAFE FALLBACK) ───
        $bookLabels = ['divine-identity' => 'Best Seller', 'my-salvation-companion' => 'My First Book'];
        $labelFor = fn ($book) => $bookLabels[$book->slug] ?? ($book->is_featured ? 'Featured' : 'Book');
        $bookTitles = $paidBooks->pluck('title')->join(', ', ' & ');
        $featuredBook = $paidBooks->get(0);
        $secondBook = $paidBooks->get(1);
        $moreBooks = $paidBooks->slice(2);
        // ─── FILTER CHIPS ───
        $chips = [
            'all' => 'All Resources',
            'pamphlet' => 'Pamphlets',
            'booklet' => 'Booklets',
            'study_guide' => 'Study Guides',
            'bible' => 'Bibles',
            'other' => 'Others',
        ];
    @endphp
    <div class="library" data-active-tab="{{ $tab }}" data-category="{{ $category }}">
        <div class="library__page">
            {{-- ─── HEADER ─── --}}
            <header class="library__header">
                <a href="{{ route('home') }}" class="library__reveal library__back">
                    <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i> Back to Home
                </a>
                <p class="library__watermark">The Written Word</p>
                <a href="{{ route('home') }}" class="library__brand-mark" aria-label="Arthur Mongalo, home">AM</a>
            </header>
            <section class="library__titles">
                <div class="library__title-row {{ $tab === 'books' ? 'is-active' : '' }}" data-for="books">
                    <h1 class="library__title library__reveal" style="animation-delay: 200ms;">My Books</h1>
                    @if($paidBooks->count() > 0)
                        <p class="library__title-note library__reveal" style="animation-delay: 260ms;">{{ $bookTitles }}</p>
                    @endif
                </div>
                <div class="library__title-row {{ $tab === 'resources' ? 'is-active' : '' }}" data-for="resources">
                    <h1 class="library__title library__reveal" style="animation-delay: 200ms;">The Free Library</h1>
                </div>
            </section>
            {{-- ─── TABS ─── --}}
            <nav class="library__tabs library__reveal" style="animation-delay: 300ms;" role="tablist">
                <button type="button" class="library__tab {{ $tab === 'books' ? 'is-active' : '' }}" role="tab" aria-selected="{{ $tab === 'books' ? 'true' : 'false' }}" data-tab="books" data-url="{{ route('books.index') }}">
                    <i class="fa-solid fa-book-open" aria-hidden="true"></i> Featured Books
                    <span class="library__tab-count">{{ $paidBooks->count() }}</span>
                    <span class="library__tab-line"></span>
                </button>
                <button type="button" class="library__tab {{ $tab === 'resources' ? 'is-active' : '' }}" role="tab" aria-selected="{{ $tab === 'resources' ? 'true' : 'false' }}" data-tab="resources" data-url="{{ route('resources') }}">
                    <i class="fa-solid fa-download" aria-hidden="true"></i> Free Resources
                    <span class="library__tab-count">{{ $counts['all'] }}</span>
                    <span class="library__tab-line"></span>
                </button>
            </nav>
            {{-- ─── PANE 1: FEATURED BOOKS ─── --}}
            <div class="library__pane {{ $tab === 'books' ? 'is-active' : '' }}" id="libraryPane-books" role="tabpanel">
                @if($featuredBook)
                    <section class="library__bento">
                        {{-- ─── FEATURED BOOK ─── --}}
                        <article class="library__tile library__tile--feature library__reveal" style="animation-delay: 420ms;" data-slug="{{ $featuredBook->slug }}">
                            <div class="library__tile-glow"></div>
                            <div class="library__tile-head">
                                <span class="library__tile-label">{{ $labelFor($featuredBook) }}</span>
                                <span class="library__tile-badge">PAID</span>
                            </div>
                            <h2 class="library__tile-title">{{ $featuredBook->title }}</h2>
                            @if($featuredBook->subtitle)
                                <p class="library__tile-sub">{{ $featuredBook->subtitle }}</p>
                            @endif
                            <div class="library__book3d-wrap">
                                <div class="library__book3d library__book3d--lg">
                                    @include('components.v160.book.cover', ['book' => $featuredBook])
                                </div>
                            </div>
                            <div class="library__tile-foot">
                                <span class="library__tile-price">{{ $featuredBook->formatted_price }}</span>
                                @include('components.v160.book.open', ['book' => $featuredBook])
                            </div>
                        </article>
                        <div class="library__bento-side">
                            {{-- ─── SECOND BOOK ─── --}}
                            @if($secondBook)
                                <article class="library__tile library__tile--second library__reveal" style="animation-delay: 520ms;" data-slug="{{ $secondBook->slug }}">
                                    <div class="library__tile-head">
                                        <span class="library__tile-label">{{ $labelFor($secondBook) }}</span>
                                        <span class="library__tile-badge">PAID</span>
                                    </div>
                                    <div class="library__second-body">
                                        <div class="library__second-text">
                                            <h2 class="library__tile-title">{{ $secondBook->title }}</h2>
                                            @if($secondBook->subtitle)
                                                <p class="library__tile-sub">{{ $secondBook->subtitle }}</p>
                                            @endif
                                        </div>
                                        <div class="library__book3d-wrap">
                                            <div class="library__book3d library__book3d--md">
                                                @include('components.v160.book.cover', ['book' => $secondBook])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="library__tile-foot">
                                        <span class="library__tile-price">{{ $secondBook->formatted_price }}</span>
                                        @include('components.v160.book.open', ['book' => $secondBook])
                                    </div>
                                </article>
                            @endif
                            <div class="library__bento-row">
                                {{-- ─── BOOK TOURS ─── --}}
                                <article class="library__tile library__tile--tours library__reveal" style="animation-delay: 620ms;">
                                    <svg class="library__tours-icon" viewBox="0 0 44 32" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"><path d="M22 6c-4-3-10-4-19-3v24c9-1 15 0 19 3 4-3 10-4 19-3V3c-9-1-15 0-19 3z"/><path d="M22 6v24"/></svg>
                                    <p class="library__tours-text">Be the first to know about our book tours</p>
                                    <div class="library__tours-cta">
                                        <a href="{{ route('contact') }}" class="library__tours-btn">Join Us <span class="library__arrow">↗</span></a>
                                    </div>
                                </article>
                                {{-- ─── FREE RESOURCES ─── --}}
                                <article class="library__tile library__tile--free library__reveal" style="animation-delay: 700ms;">
                                    <p class="library__free-label">Free Resources</p>
                                    <ul class="library__free-list">
                                        <li><a href="{{ route('resources', ['cat' => 'study_guide']) }}" class="library__ulink" data-goto-category="study_guide">Study guide</a></li>
                                        <li><a href="{{ route('resources', ['cat' => 'pamphlet']) }}" class="library__ulink" data-goto-category="pamphlet">Pamphlets</a></li>
                                        <li><a href="{{ route('resources', ['cat' => 'booklet']) }}" class="library__ulink" data-goto-category="booklet">Booklets</a></li>
                                        <li><a href="{{ route('resources', ['cat' => 'bible']) }}" class="library__ulink" data-goto-category="bible">Bibles</a></li>
                                    </ul>
                                </article>
                            </div>
                        </div>
                    </section>
                    {{-- ─── EXTRA BOOKS ─── --}}
                    @if($moreBooks->count() > 0)
                        <section class="library__bento-more">
                            @foreach($moreBooks as $book)
                                <article class="library__tile library__tile--compact library__reveal" style="animation-delay: {{ 780 + ($loop->index * 100) }}ms;" data-slug="{{ $book->slug }}">
                                    <div class="library__book3d-wrap">
                                        <div class="library__book3d library__book3d--sm">
                                            @include('components.v160.book.cover', ['book' => $book])
                                        </div>
                                    </div>
                                    <div class="library__compact-info">
                                        <span class="library__tile-label">{{ $labelFor($book) }}</span>
                                        <h2 class="library__tile-title">{{ $book->title }}</h2>
                                        <div class="library__tile-foot">
                                            <span class="library__tile-price">{{ $book->formatted_price }}</span>
                                            @include('components.v160.book.open', ['book' => $book])
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </section>
                    @endif
                @else
                    <p class="library__empty"><i class="fa-regular fa-folder-open" aria-hidden="true"></i>New books are on the way.</p>
                @endif
            </div>
            {{-- ─── PANE 2: FREE RESOURCES ─── --}}
            <div class="library__pane {{ $tab === 'resources' ? 'is-active' : '' }}" id="libraryPane-resources" role="tabpanel">
                <div class="library__filters">
                    @foreach($chips as $key => $label)
                        <button type="button" class="library__chip {{ $category === $key ? 'is-active' : '' }}" data-filter="{{ $key }}">
                            {{ $label }} <span class="library__chip-count">{{ $counts[$key] }}</span>
                        </button>
                    @endforeach
                </div>
                <div class="library__stage">
                    <div class="library__grid" id="libraryGrid">
                        @foreach($resources as $resource)
                            @php
                                $c = $order[$loop->index % count($order)];
                                $variant = $loop->index % 3 === 1 ? 'sm' : 'lg';
                                $visible = $category === 'all' ? $loop->index < 3 : $resource->category === $category;
                            @endphp
                            <article class="library__res library__res--{{ $variant }} {{ $visible ? 'library__reveal' : 'is-hidden' }}"
                                style="--res-bg: {{ $c['bg'] }}; --res-fg: {{ $c['fg'] }}; --res-title: {{ $c['title'] }}; --res-sub: {{ $c['sub'] }}; --res-label: {{ $c['label'] }}; --res-rule: {{ $c['rule'] }}; --res-icon: {{ $c['icon'] }}; --res-foot: {{ $c['foot'] }}; animation-delay: {{ 480 + ($loop->index * 100) }}ms;"
                                data-slug="{{ $resource->slug }}"
                                data-type="{{ $resource->category }}"
                                @if($loop->index >= 3) data-more="1" @endif
                                data-title="{{ $resource->title }}"
                                data-sub="{{ $resource->subtitle }}"
                                data-desc="{{ $resource->description }}"
                                data-label="{{ $resource->category_label }}"
                                data-format="{{ $resource->file_type ? strtoupper($resource->file_type) : '' }}"
                                data-size="{{ $resource->file_size }}"
                                data-downloads="{{ (int) $resource->download_count }}"
                                data-download-url="{{ $resource->book_file ? route('books.download', $resource->id) : '' }}">
                                <div class="library__res-top">
                                    <span class="library__res-label">{{ $resource->category_label }}</span>
                                    <span class="library__res-free">FREE</span>
                                </div>
                                <h2 class="library__res-title">{{ $resource->title }}</h2>
                                @if($resource->subtitle)
                                    <p class="library__res-sub">{{ $resource->subtitle }}</p>
                                @endif
                                @if($variant === 'lg')
                                    <svg class="library__res-icon" viewBox="0 0 44 32" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"><path d="M22 6c-4-3-10-4-19-3v24c9-1 15 0 19 3 4-3 10-4 19-3V3c-9-1-15 0-19 3z"/><path d="M22 6v24"/></svg>
                                @endif
                                <div class="library__res-foot">
                                    <div class="library__res-rule"></div>
                                    <div class="library__res-actions">
                                        @if($resource->book_file)
                                            <a href="{{ route('books.download', $resource->id) }}" class="library__res-dl" download>Free Download</a>
                                        @else
                                            <span class="library__res-soon">Coming Soon</span>
                                        @endif
                                        <button type="button" class="library__res-open">View book <span class="library__res-arrow">↗</span></button>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <p class="library__empty {{ $category !== 'all' && $counts[$category] === 0 ? '' : 'is-hidden' }}" id="libraryEmpty">
                        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>More resources in this category are coming soon.
                    </p>
                    <div class="library__tagline">
                        <span class="library__tagline-line"></span>
                        <p class="library__reveal" style="animation-delay: 1000ms;">Freely shared. For your walk in faith</p>
                    </div>
                    <div class="library__more {{ $category !== 'all' || $resources->count() <= 3 ? 'is-hidden' : '' }}" id="libraryMore">
                        <button type="button" class="library__more-btn library__reveal" style="animation-delay: 800ms;" id="libraryLoadMore">Load More <i class="fa-solid fa-arrow-down" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            {{-- ─── FOOTER ─── --}}
            <footer class="library__footer">
                <p>&copy; {{ date('Y') }} Arthur Mongalo Ministry. All rights reserved.</p>
                <p class="library__footer-verse">"Freely you have received; freely give." — Matthew 10:8</p>
            </footer>
        </div>
        {{-- ─── RESOURCE MODAL ─── --}}
        <div class="library__modal" id="libraryResModal" aria-hidden="true">
            <button type="button" class="library__modal-close" data-modal-close>Close <i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
            <div class="library__modal-panel" role="dialog" aria-modal="true" aria-labelledby="libraryResTitle">
                <div class="library__modal-cover" id="libraryResCover">
                    <span class="library__modal-cover-label" id="libraryResCoverLabel">Free Resource</span>
                    <h4 class="library__modal-cover-title" id="libraryResCoverTitle"></h4>
                    <svg class="library__modal-cover-icon" viewBox="0 0 44 32" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"><path d="M22 6c-4-3-10-4-19-3v24c9-1 15 0 19 3 4-3 10-4 19-3V3c-9-1-15 0-19 3z"/><path d="M22 6v24"/></svg>
                </div>
                <div class="library__modal-body">
                    <p class="library__modal-org">Arthur Mongalo Ministry</p>
                    <h3 class="library__modal-title" id="libraryResTitle"></h3>
                    <p class="library__modal-sub" id="libraryResSub"></p>
                    <p class="library__modal-desc" id="libraryResDesc"></p>
                    <div class="library__modal-meta">
                        <div><span>Format</span><span id="libraryResFormat"></span></div>
                        <div><span>Price</span><span class="library__modal-free">Free</span></div>
                        <div id="libraryResDownloadsRow"><span>Downloads</span><span id="libraryResDownloads"></span></div>
                    </div>
                    <div class="library__modal-foot">
                        <a href="#" class="library__modal-dl" id="libraryResDl" download>
                            <span class="library__modal-dl-bar" id="libraryDlBar"></span>
                            <span class="library__modal-dl-label" id="libraryDlLabel"><i class="fa-solid fa-download" aria-hidden="true"></i> Free Download</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- ─── BOOK MODAL ─── --}}
        <div class="library__modal" id="libraryBookModal" aria-hidden="true" data-currency="{{ $currency }}">
            <button type="button" class="library__modal-close" data-modal-close>Close <i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
            <div class="library__modal-panel library__modal-panel--book" role="dialog" aria-modal="true" aria-labelledby="libraryBookTitle">
                <div class="library__modal-stage">
                    <div class="library__book3d library__book3d--modal">
                        <img src="" alt="" class="library__book3d-img" id="libraryBookImg" hidden>
                        <div class="library__book3d-fallback" id="libraryBookFallback"><span id="libraryBookFallbackTitle"></span></div>
                    </div>
                </div>
                <div class="library__modal-body">
                    <p class="library__modal-org">Arthur Mongalo</p>
                    <h3 class="library__modal-title" id="libraryBookTitle"></h3>
                    <p class="library__modal-sub" id="libraryBookSub"></p>
                    {{-- ─── STEP 1: DETAILS ─── --}}
                    <div id="libraryBookDetails">
                        <p class="library__modal-desc" id="libraryBookDesc"></p>
                        <div class="library__editions">
                            <button type="button" class="library__edition is-active" data-ed="digital">
                                <span class="library__edition-name"><span class="library__edition-dot"></span><span>Digital Edition</span></span>
                                <span class="library__edition-price" id="libraryPriceDigital"></span>
                            </button>
                            <button type="button" class="library__edition" data-ed="hard" id="libraryEditionHard">
                                <span class="library__edition-name"><span class="library__edition-dot"></span><span>Hard Copy</span></span>
                                <span class="library__edition-price" id="libraryPriceHard"></span>
                            </button>
                        </div>
                        <div class="library__modal-foot library__modal-foot--buy">
                            <button type="button" class="library__buy-btn" id="libraryBuyBtn">Buy Now <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                            <span class="library__secure"><i class="fa-solid fa-lock" aria-hidden="true"></i>Secure checkout</span>
                        </div>
                    </div>
                    {{-- ─── STEP 2: CHECKOUT ─── --}}
                    <div id="libraryCheckout" hidden>
                        <button type="button" class="library__back-step" id="libraryBackStep"><i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i> Back to details</button>
                        <form id="paymentForm" class="library__form" method="POST" action="{{ route('payment.initiate') }}">
                            @csrf
                            <input type="hidden" name="book_id" id="libraryBookId" value="">
                            <input type="hidden" name="gateway" value="payfast">
                            <input type="hidden" name="delivery_type" value="digital" id="libraryDeliveryType">
                            <div class="library__field">
                                <label for="buyer_name">Full Name</label>
                                <input type="text" name="name" id="buyer_name" placeholder="Your full name" required>
                            </div>
                            <div class="library__field">
                                <label for="buyer_email">Email Address</label>
                                <input type="email" name="email" id="buyer_email" placeholder="your@email.com" required>
                            </div>
                            <div class="library__field">
                                <label for="buyer_phone">Phone Number</label>
                                <input type="tel" name="phone" id="buyer_phone" placeholder="+27 71 000 0000">
                            </div>
                            {{-- ─── HARD COPY ADDRESS ─── --}}
                            <div class="library__hardcopy" id="hardcopyFields" hidden>
                                <p class="library__hardcopy-title"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Delivery Address</p>
                                <div class="library__field">
                                    <label for="delivery_region">Delivery Region</label>
                                    <select name="delivery_region" id="delivery_region">
                                        @foreach($regions as $key => $region)
                                            <option value="{{ $key }}" data-fee="{{ $region['fee'] }}" data-days="{{ $region['days'] }}">{{ $region['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="library__row">
                                    <div class="library__field">
                                        <label for="delivery_address_1">Street Address</label>
                                        <input type="text" name="delivery_address_1" id="delivery_address_1" placeholder="123 Main Road">
                                    </div>
                                    <div class="library__field">
                                        <label for="delivery_address_2">Unit / Complex (optional)</label>
                                        <input type="text" name="delivery_address_2" id="delivery_address_2" placeholder="Unit 4" data-required="false">
                                    </div>
                                </div>
                                <div class="library__row">
                                    <div class="library__field">
                                        <label for="delivery_suburb">Suburb</label>
                                        <input type="text" name="delivery_suburb" id="delivery_suburb" placeholder="Suburb">
                                    </div>
                                    <div class="library__field">
                                        <label for="delivery_city">City</label>
                                        <input type="text" name="delivery_city" id="delivery_city" placeholder="City">
                                    </div>
                                </div>
                                <div class="library__row">
                                    <div class="library__field">
                                        <label for="delivery_province">Province / Region</label>
                                        <input type="text" name="delivery_province" id="delivery_province" placeholder="Province">
                                    </div>
                                    <div class="library__field">
                                        <label for="delivery_postal_code">Postal Code</label>
                                        <input type="text" name="delivery_postal_code" id="delivery_postal_code" placeholder="0000">
                                    </div>
                                </div>
                                <div class="library__field">
                                    <label for="delivery_country">Country</label>
                                    <input type="text" name="delivery_country" id="delivery_country" value="South Africa">
                                </div>
                                <div class="library__field">
                                    <label for="delivery_notes">Delivery Notes (optional)</label>
                                    <input type="text" name="delivery_notes" id="delivery_notes" placeholder="Gate code, best time to deliver, etc." data-required="false">
                                </div>
                            </div>
                            {{-- ─── ORDER SUMMARY ─── --}}
                            <div class="library__summary" id="orderSummary" hidden>
                                <div class="library__summary-row"><span>Book</span><span id="summaryBookPrice"></span></div>
                                <div class="library__summary-row"><span>Shipping</span><span id="summaryShipping">—</span></div>
                                <div class="library__summary-row library__summary-row--total"><span>Total</span><span id="summaryTotal"></span></div>
                                <p class="library__summary-note"><i class="fa-solid fa-clock" aria-hidden="true"></i> <span id="summaryDeliveryDays">—</span></p>
                            </div>
                            <div class="library__field">
                                <x-turnstile />
                            </div>
                            <div class="library__form-actions">
                                <button type="submit" class="library__pay" id="buyNowBtn">
                                    <span id="buyBtnText"><i class="fa-solid fa-lock" aria-hidden="true"></i> Pay</span>
                                    <span id="buyBtnLoader" hidden><i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i> Processing...</span>
                                </button>
                                <button type="button" class="library__cancel" data-modal-close>Cancel</button>
                            </div>
                            <div class="library__message" id="paymentMessage"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ secure_asset('js/v160/library.js') }}"></script>
@endpush

@push('schema')
    @php
        // ─── COLLECTION SCHEMA FOR THE ACTIVE TAB ───
        $isBooksTab = $tab === 'books';
        $pageUrl = $isBooksTab ? route('books.index') : route('resources');
        $listItems = [];
        $position = 1;
        foreach (($isBooksTab ? $paidBooks : $resources) as $item) {
            $entry = [
                '@type' => $isBooksTab ? 'Product' : 'CreativeWork',
                'name' => $item->title,
                'url' => $pageUrl . '?open=' . $item->slug,
            ];
            if ($isBooksTab) {
                $entry['offers'] = [
                    '@type' => 'Offer',
                    'price' => (string) $item->price,
                    'priceCurrency' => 'ZAR',
                    'availability' => 'https://schema.org/InStock',
                ];
            }
            $listItems[] = ['@type' => 'ListItem', 'position' => $position++, 'item' => $entry];
        }
        $collectionSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => $pageUrl . '#webpage',
            'url' => $pageUrl,
            'name' => ($isBooksTab ? 'Books Library' : 'Free Resources') . ' · ' . config('seo.site_name'),
            'isPartOf' => ['@id' => config('seo.site_url') . '/#website'],
            'inLanguage' => 'en-ZA',
            'breadcrumb' => [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => $isBooksTab ? 'Books' : 'Free Resources', 'item' => $pageUrl],
                ],
            ],
        ];
        if (! empty($listItems)) {
            $collectionSchema['mainEntity'] = ['@type' => 'ItemList', 'itemListElement' => $listItems];
        }
    @endphp

    <script type="application/ld+json">{!! json_encode($collectionSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush