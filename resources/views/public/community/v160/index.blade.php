@extends('layouts.v160.app')

@section('title', $brand['name'] . ' | ' . config('seo.site_name'))

@section('meta_description', 'Join ' . $brand['name'] . ': upcoming baptisms, book tours and gatherings with Arthur Mongalo. ' . $brand['quote'])

@section('page-class', 'page-community')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ secure_asset('css/v160/in.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/v160/community.css') }}">
@endpush

@section('content')
    @php
        $theme = $brand['theme'];
        $currency = currency_symbol();
        $posterEvent = $posterProgram['event'] ?? null;
        $posterNext = $posterProgram['next'] ?? null;
        $posterTime = ($posterEvent && $posterEvent->time) ? \Carbon\Carbon::parse($posterEvent->time)->format('H\hi') : null;
        $gatherings = $tabs->map(fn ($item, $key) => ['label' => $item['label'], 'href' => '#programs', 'filter' => $key])->values()->all();
        $gatherings[] = ['label' => 'Upcoming Events', 'href' => '#programs', 'filter' => 'all'];
    @endphp

    <div class="in in--community"
        data-initial-cat="{{ $category }}"
        style="--in-bg: {{ $theme['bg'] }}; --in-surface: {{ $theme['surface'] }}; --in-accent: {{ $theme['accent'] }}; --in-accent-hover: {{ $theme['accent_hover'] }}; --in-accent-soft: {{ $theme['accent_soft'] }}; --in-accent-text: {{ $theme['accent_text'] }};">
        
        {{-- ─── SECTION 1: HERO ─── --}}
        <section class="in__hero">
            <header class="in__hero-header">
                <a href="{{ route('home') }}" class="in__back"><span>&larr;</span> Back to Home</a>
                <nav class="in__nav">
                    <a href="#programs">Programs</a>
                    <a href="#programs" data-register-next>Register</a>
                    <a href="#gatherings">Gatherings</a>
                </nav>
            </header>
            <div class="in__hills">
                <svg viewBox="0 0 1440 320" fill="none" preserveAspectRatio="none" aria-hidden="true">
                    <path fill="#120508" d="M0,192L48,181.3C96,171,192,149,288,160C384,171,480,213,576,202.7C672,192,768,128,864,122.7C960,117,1056,171,1152,186.7C1248,203,1344,181,1392,170.7L1440,160L1440,320L0,320Z"></path>
                    <path fill="#0d0406" opacity="0.6" d="M0,256L60,240C120,224,240,192,360,197.3C480,203,600,245,720,240C840,235,960,181,1080,170.7C1200,160,1320,192,1380,208L1440,224L1440,320L0,320Z"></path>
                </svg>
            </div>
            <div class="in__hero-grid">
                {{-- ─── LEFT: MONOGRAM TOP, CTAs BOTTOM-LEFT ─── --}}
                <div class="in__hero-main">
                    <div class="in__hero-brand">
                        <span class="in__tagline">{{ $brand['tagline'] }}</span>
                        <x-v160.in-monogram size="lg" />
                    </div>
                    <div class="in__hero-actions">
                        <x-v160.cta-link :channel="$brand['cta']['primary']['channel']" class="in__btn in__btn--primary">{{ $brand['cta']['primary']['label'] }}</x-v160.cta-link>
                        <a href="{{ $brand['cta']['secondary']['href'] }}" class="in__btn in__btn--ghost">{{ $brand['cta']['secondary']['label'] }}</a>
                    </div>
                </div>
                
                {{-- ─── RIGHT: DOWNLOADABLE POSTER ─── --}}
                <div class="in__hero-poster">
                    <div class="in__poster-wrap" id="inPosterWrap">
                        <div class="in__poster" id="inPoster">
                            <div class="in__poster-frame">
                                <img src="{{ $posterEvent ? $posterEvent->poster_url : 'https://images.unsplash.com/photo-1507692049790-de58290a4334?auto=format&fit=crop&w=900&q=80' }}"
                                    alt="{{ $posterEvent ? $posterEvent->title . ' poster' : 'Worship crowd' }}" class="in__poster-img">
                                @unless($posterEvent)
                                    <div class="in__poster-soon"><span>Next poster coming soon</span></div>
                                @endunless
                            </div>
                            <div class="in__poster-caption">
                                @if($posterEvent)
                                    <span class="in__poster-kicker">Upcoming {{ $posterEvent->category_label }}</span>
                                    <h3 class="in__poster-title">{{ $posterEvent->title }}</h3>
                                    <p class="in__poster-meta">{{ $posterNext->format('j F Y') }}@if($posterTime) &middot; {{ $posterTime }}@endif @if($posterEvent->location) &middot; {{ $posterEvent->location }}@endif</p>
                                    <a href="{{ $posterEvent->poster_url }}" class="in__poster-download" download="{{ $posterEvent->slug }}-poster.{{ pathinfo($posterEvent->poster_image, PATHINFO_EXTENSION) }}">
                                        <i class="fa-solid fa-download" aria-hidden="true"></i> Download poster
                                    </a>
                                @else
                                    <span class="in__poster-kicker">Stay tuned</span>
                                    <h3 class="in__poster-title">The next gathering is on its way</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        {{-- ─── SECTION 2: PROGRAMS ─── --}}
        <section class="in__programs" id="programs">
            <div class="in__programs-head">
                <span class="in__kicker">Life Together</span>
                <h2 class="in__programs-title">Programs</h2>
            </div>
            <div class="in__tabs" role="tablist">
                <button type="button" class="in__tab {{ $category === 'all' ? 'is-active' : '' }}" data-cat="all" role="tab">
                    <span>01</span>All Events
                </button>
                @foreach($tabs as $key => $item)
                    <button type="button" class="in__tab {{ $category === $key ? 'is-active' : '' }}" data-cat="{{ $key }}" role="tab">
                        <span>{{ str_pad($loop->iteration + 1, 2, '0', STR_PAD_LEFT) }}</span>{{ $item['label'] }}
                    </button>
                @endforeach
                <button type="button" class="in__tab {{ $category === 'invite' ? 'is-active' : '' }}" data-cat="invite" role="tab">
                    <span>{{ str_pad($tabs->count() + 2, 2, '0', STR_PAD_LEFT) }}</span>Invite Arthur to your Events
                </button>
            </div>
            <div class="in__rows {{ $category === 'invite' ? 'is-hidden' : '' }}" id="inRows">
                @foreach($programs as $program)
                    @php
                        $event = $program['event'];
                        $next = $program['next'];
                        $timeLabel = $event->time ? \Carbon\Carbon::parse($event->time)->format('H\hi') : null;
                        $priceLabel = $event->is_free ? 'FREE' : $currency . number_format($event->price, 2, ',', ' ');
                        $occurrences = collect($program['occurrences'])->map(fn ($day) => [
                            'value' => $day->format('Y-m-d'),
                            'label' => $day->format('D, j F Y'),
                            'target' => \Carbon\Carbon::parse($day->format('Y-m-d') . ' ' . ($event->time ?: '00:00'))->toIso8601String(),
                        ])->values();
                        $visible = in_array($category, ['all', $event->category], true);
                    @endphp
                    <div class="in__row {{ $visible ? '' : 'is-hidden' }}" data-cat="{{ $event->category }}" data-slug="{{ $event->slug }}">
                        <div class="in__row-date">{{ strtoupper($next->format('j F Y')) }}</div>
                        <div class="in__row-main">
                            <h3 class="in__row-title">{{ $event->title }}</h3>
                            <p class="in__row-meta">{{ collect([$event->location, $timeLabel])->filter()->join(', ') }}</p>
                            @if($event->is_recurring)
                                <span class="in__row-repeat"><i class="fa-solid fa-rotate" aria-hidden="true"></i> {{ $event->recurrence_label }}</span>
                            @endif
                        </div>
                        <div class="in__row-side">
                            <span class="in__row-price">{{ $priceLabel }}@unless($event->is_free) <small>PER PERSON</small>@endunless</span>
                            <button type="button" class="in__row-open" aria-label="Register for {{ $event->title }}"
                                data-event-id="{{ $event->id }}"
                                data-title="{{ $event->title }}"
                                data-desc="{{ $event->description }}"
                                data-location="{{ $event->location }}"
                                data-time="{{ $timeLabel }}"
                                data-price-label="{{ $priceLabel }}"
                                data-is-free="{{ $event->is_free ? '1' : '0' }}"
                                data-recurrence="{{ $event->recurrence_label }}"
                                data-occurrences="{{ json_encode($occurrences) }}">&nearr;</button>
                        </div>
                    </div>
                @endforeach
                <p class="in__empty is-hidden" id="inEmpty">Nothing scheduled here yet. Check back soon.</p>
            </div>
            <div class="in__invite {{ $category === 'invite' ? '' : 'is-hidden' }}" id="inInvite">
                <h3>Invite Arthur to your events</h3>
                <p>Hosting a conference, church service, youth gathering or book launch? Send an invitation and we will get back to you.</p>
                <a href="{{ route('invite') }}" class="in__btn in__btn--primary">Send an invitation</a>
            </div>
        </section>
        
        {{-- ─── REGISTER MODAL ─── --}}
        <div class="in__modal" id="inRegisterModal" aria-hidden="true">
            <div class="in__modal-wrap">
                <div class="in__modal-bar">
                    <button type="button" class="in__modal-back" data-modal-close><span>&larr;</span> All Events</button>
                    <button type="button" class="in__modal-close" data-modal-close>Close &times;</button>
                </div>
                <div class="in__modal-card" role="dialog" aria-modal="true" aria-labelledby="inRegTitle">
                    <div class="in__modal-info">
                        <div class="in__modal-details">
                            <h3 class="in__modal-title" id="inRegTitle"></h3>
                            <p class="in__modal-meta" id="inRegMeta"></p>
                            <p class="in__modal-desc" id="inRegDesc"></p>
                            <span class="in__modal-repeat" id="inRegRepeat" hidden><i class="fa-solid fa-rotate" aria-hidden="true"></i> <span id="inRegRepeatText"></span></span>
                            <div class="in__modal-price" id="inRegPrice"></div>
                        </div>
                        <div class="in__countdown">
                            <span class="in__countdown-label">Countdown:</span>
                            <div class="in__countdown-grid">
                                <div class="in__cd-unit"><span id="cdDays">00</span><small>dd</small></div>
                                <i>:</i>
                                <div class="in__cd-unit"><span id="cdHours">00</span><small>hh</small></div>
                                <i>:</i>
                                <div class="in__cd-unit"><span id="cdMins">00</span><small>mm</small></div>
                                <i>:</i>
                                <div class="in__cd-unit"><span id="cdSecs">00</span><small>ss</small></div>
                            </div>
                        </div>
                    </div>
                    <div class="in__modal-form">
                        {{-- ─── FORM STATE ─── --}}
                        <div id="inRegFormView">
                            <h3 class="in__modal-heading">Register Now</h3>
                            <form id="inRegForm" class="in__form" method="POST" action="{{ route('events.register') }}">
                                @csrf
                                <input type="hidden" name="event_id" id="inRegEventId" value="">
                                <div class="in__field" id="inRegOccurrenceField" hidden>
                                    <label for="inRegOccurrence">Choose a date:</label>
                                    <select name="occurrence_date" id="inRegOccurrence" class="in__input"></select>
                                </div>
                                <div class="in__field">
                                    <label for="inRegName">Name:</label>
                                    <input type="text" name="name" id="inRegName" class="in__input" required placeholder="Enter your name here...">
                                </div>
                                <div class="in__field">
                                    <label for="inRegEmail">Email Address:</label>
                                    <input type="email" name="email" id="inRegEmail" class="in__input" required placeholder="Enter your email here...">
                                </div>
                                <div class="in__field">
                                    <label for="inRegPhone">Phone Number:</label>
                                    <input type="tel" name="phone" id="inRegPhone" class="in__input" required placeholder="Enter your phone number here...">
                                </div>
                                <div class="in__field">
                                    <x-turnstile />
                                </div>
                                <div class="in__form-foot">
                                    <p class="in__form-error" id="inRegError" hidden></p>
                                    <button type="submit" class="in__submit" id="inRegSubmit">
                                        <span id="inRegSubmitText">Submit <span>&nearr;</span></span>
                                        <span id="inRegSubmitLoader" hidden><i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i> Sending...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        {{-- ─── SUCCESS STATE ─── --}}
                        <div id="inRegSuccessView" hidden>
                            <span class="in__success-icon"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                            <h3 class="in__modal-heading">You are registered</h3>
                            <p class="in__success-message" id="inSuccessMessage"></p>
                            <dl class="in__success-list">
                                <div><dt>Registration ID</dt><dd id="inSuccessId"></dd></div>
                                <div><dt>Name</dt><dd id="inSuccessName"></dd></div>
                                <div id="inSuccessDateRow"><dt>Date</dt><dd id="inSuccessDate"></dd></div>
                            </dl>
                            <div class="in__bank" id="inSuccessBank" hidden>
                                <p>Please complete payment using these details:</p>
                                <dl>
                                    <div><dt>Bank</dt><dd id="bankName"></dd></div>
                                    <div><dt>Account name</dt><dd id="bankAccountName"></dd></div>
                                    <div><dt>Account number</dt><dd id="bankAccountNumber"></dd></div>
                                    <div><dt>Branch code</dt><dd id="bankBranch"></dd></div>
                                    <div><dt>Reference</dt><dd id="bankReference"></dd></div>
                                </dl>
                            </div>
                            <div class="in__success-actions">
                                <x-v160.cta-link channel="whatsapp" class="in__btn in__btn--dark">Join the WhatsApp group</x-v160.cta-link>
                                <button type="button" class="in__success-clear" id="inSuccessClear">Not you? Register someone else</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- ─── FOOTER ─── --}}
        <x-v160.in-footer :brand="$brand" :gatherings="$gatherings">
            @include('public.community.v160.partials.banner')
        </x-v160.in-footer>
    </div>
@endsection

@push('scripts')
    <script src="{{ secure_asset('js/v160/community.js') }}"></script>
@endpush

@push('schema')
    @php
        $schemaEvents = [];
        foreach ($programs as $program) {
            $event = $program['event'];
            $schemaEvents[] = array_filter([
                '@type' => 'Event',
                'name' => $event->title,
                'description' => $event->description,
                'startDate' => \Carbon\Carbon::parse($program['next']->format('Y-m-d') . ' ' . ($event->time ?: '00:00'))->toIso8601String(),
                'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
                'eventStatus' => 'https://schema.org/EventScheduled',
                'location' => $event->location ? ['@type' => 'Place', 'name' => $event->location] : null,
                'image' => $event->poster_url,
                'isAccessibleForFree' => (bool) $event->is_free,
                'organizer' => ['@type' => 'Organization', 'name' => config('seo.site_name'), 'url' => config('seo.site_url')],
                'url' => route('community', ['open' => $event->slug]),
            ]);
        }
        $communitySchema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => route('community') . '#webpage',
            'url' => route('community'),
            'name' => $brand['name'] . ' · ' . config('seo.site_name'),
            'inLanguage' => 'en-ZA',
            'mainEntity' => ['@type' => 'ItemList', 'itemListElement' => array_map(
                fn ($item, $index) => ['@type' => 'ListItem', 'position' => $index + 1, 'item' => $item],
                $schemaEvents,
                array_keys($schemaEvents)
            )],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($communitySchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush