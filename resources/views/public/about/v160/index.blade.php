@extends('layouts.v160.app')

@section('title', "Arthur Mongalo Story | " . config('seo.site_name'))

@section('meta_description', "Arthur Mongalo's story: responding to the call to accept Christ over and over, seeking assurance, leading a church in Limpopo for nine years, and building a ministry of baptisms in Gauteng.")

@section('meta_image', secure_asset('images/arthur-mongalo-landscape.jpg'))

@section('page-class', 'page-about')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ secure_asset('css/v160/about.css') }}">
@endpush

@section('content')
    @php
        // ─── TIMELINE DATA ───
        $timeline = [
            [
                'year' => '2006',
                'title' => 'Leading in Ministry',
                'text' => 'Until 2011, I led a cell group at Emmanuel Christian Church under Apostle Vincent Loate for several years, before relocating for work.'
            ],
            [
                'year' => '2012',
                'title' => 'A New City, A New Fellowship',
                'text' => 'Relocated to Polokwane, Limpopo. Fellowshipped at God\'s Tabernacle under Dr David Molutsi.'
            ],
            [
                'year' => '2016',
                'title' => 'Remnants Gathering Fellowship',
                'text' => 'Launched the church. Its name proved difficult for elderly people in the village to pronounce, and its eagle and dove logo was hard for members to interpret.'
            ],
            [
                'year' => '2021',
                'title' => 'Becoming Christ Tabernacle-Pneuma',
                'text' => 'Changed the name and logo to something clearer for the congregation.'
            ],
            [
                'year' => '2025',
                'title' => 'Handover to God\'s Presence Ministries',
                'text' => 'Handed the church to God\'s Presence Ministries under Reverend Cornelius Maphoto, due to relocation and collaboration.'
            ],
        ];
        // ─── QUICK FACTS ───
        $facts = [
            'Studied Electrical Engineering, specialising in Process Instrumentation.',
            'Completed a Postgraduate Diploma in Business Management, and has a background in Project Management.',
            'Founder of two companies, MENG and Monono Holdings.',
            'Married for over 19 years, with three children.',
            'Based in Gauteng, South Africa.',
            'An ordained pastor and published author.',
            'Led a church in Limpopo for nine years.',
            'Has travelled to Lesotho, Zimbabwe, Zambia, Botswana, Ghana and the United Kingdom.',
        ];
    @endphp
    <div class="about">
        {{-- ─── AMBIENT GLOWS ─── --}}
        <div class="about__glow">
            <div class="about__glow-top"></div>
            <div class="about__glow-side"></div>
        </div>
        {{-- ─── HEADER ─── --}}
        <header class="about__header">
            <a href="{{ route('home') }}" class="about__back">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                Back to Home
            </a>
            <div class="about__header-right">
                <span class="about__header-label">Ministry Testimony Archive</span>
                <a href="{{ route('home') }}" class="about__brand-mark" aria-label="Arthur Mongalo, home">AM</a>
            </div>
        </header>
        {{-- ─── WATERMARK ─── --}}
        <div class="about__watermark">
            <h1 class="about__watermark-text">Personal Testimony</h1>
        </div>
        <div class="about__main">
            {{-- ─── STAGE: SECTIONS 1 AND 2 OVER A SHARED IMAGE ─── --}}
            <div class="about__stage">
                <div class="about__stage-bg">
                    <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80" alt="Misty mountains at dawn" class="about__stage-img">
                    <div class="about__stage-overlay"></div>
                </div>
                <div class="about__container about__stage-content">
                    {{-- ─── SECTION 1: HERO FEATURE CARD ─── --}}
                    <section class="about__card about__hero">
                        <div class="about__hero-portrait-col">
                            <div class="about__portrait">
                                <div class="about__portrait-inner">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=800&q=80" alt="Arthur Mongalo portrait" class="about__portrait-img">
                                </div>
                                <div class="about__portrait-badge">Pastor &amp; Author</div>
                            </div>
                        </div>
                        <div class="about__hero-content">
                            <div class="about__hero-eyebrow">
                                <span class="about__hero-name">Arthur Mongalo</span>
                                <span class="about__hero-line"></span>
                            </div>
                            <h2 class="about__hero-title">The First Calls <span>to Faith</span></h2>
                            <blockquote class="about__hero-quote">
                                "My journey was not defined by smooth roads, but by the overwhelming grace that met me in my lowest valleys. Grace did not just find me, it transformed my entire purpose."
                            </blockquote>
                        </div>
                    </section>
                    {{-- ─── SECTION 2: CALLED MORE THAN ONCE ─── --}}
                    <section class="about__narrative">
                        <h3 class="about__section-title">Called More Than Once</h3>
                        <div class="about__narrative-grid">
                            <div class="about__card about__narrative-card">
                                A travelling evangelist came to my village in the 1990s, before I was even a teenager. He made an altar call at every service, and I went forward four days in a row. I felt compelled to. I caught myself crying, feeling the need to accept Christ.
                            </div>
                            <div class="about__card about__narrative-card">
                                In 1997 or 1998, I stood up again, this time at Bethesda Christian Church, visiting under Pastor Clement Ibe. I was born again, again. Both times, I felt that same need to be born again, and both times it oddly felt like God was calling me into His service too. I never doubted it was beyond just getting saved.
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="about__container about__body">
                <div class="about__divider"></div>
                {{-- ─── SECTION 3: TABS ─── --}}
                <section class="about__tabs">
                    <div class="about__tabbar" role="tablist">
                        <button type="button" class="about__tab is-active" role="tab" aria-selected="true" data-tab="bio">Biography &amp; Testimony</button>
                        <button type="button" class="about__tab" role="tab" aria-selected="false" data-tab="timeline">Milestones Timeline</button>
                        <button type="button" class="about__tab" role="tab" aria-selected="false" data-tab="reflection">Watch My Reflection</button>
                    </div>
                    {{-- ─── TAB 1: BIOGRAPHY ─── --}}
                    <div class="about__pane about__pane--bio is-active" id="aboutPane-bio" role="tabpanel">
                        <div class="about__bio-text">
                            <div class="about__bio-block">
                                <h4>Purpose</h4>
                                <p>My mission is to teach water and Spirit baptism, and to equip believers to serve.</p>
                                <p>It is for born-again Christians who lack assurance of salvation or baptism, believers who want to start their own mission but do not know where to begin, and anyone exploring faith or living outside a church community.</p>
                            </div>
                            <div class="about__bio-block">
                                <h4>Where It All Started</h4>
                                <p>I responded to the call to accept Christ more than once before it finally took root, and I was baptised in water twice before I found real assurance. Helping others find that assurance sooner is part of why this ministry exists.</p>
                            </div>
                            <div class="about__bio-block">
                                <h4>The Vision</h4>
                                <p>I have a vision to baptise at least a million people in water, pray for at least a million people, and equip every believer for spiritual growth.</p>
                            </div>
                        </div>
                        <div class="about__bio-photo">
                            <div class="about__card about__photo-card">
                                <div class="about__photo-head">
                                    <span>Others</span>
                                    <span>Photo Archive</span>
                                </div>
                                <div class="about__photo-frame">
                                    <img src="https://images.unsplash.com/photo-1544427920-c49ccfb85579?auto=format&fit=crop&w=1200&q=80" alt="Baptism ceremony in mountain lake" class="about__photo-img">
                                    <div class="about__photo-shade"></div>
                                    <div class="about__photo-caption">
                                        <span>Public Declaration of Faith</span>
                                        <p>The waters of renewal: a sacred covenant by mountain lakes.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ─── TAB 2: TIMELINE ─── --}}
                    <div class="about__pane about__pane--timeline about__card" id="aboutPane-timeline" role="tabpanel">
                        <div class="about__timeline-mark">ARTHUR MONGALO</div>
                        <div class="about__timeline-list">
                            @foreach($timeline as $item)
                                <div class="about__timeline-item">
                                    <span class="about__timeline-dot"></span>
                                    <span class="about__timeline-year">{{ $item['year'] }}</span>
                                    <h5 class="about__timeline-title">{{ $item['title'] }}</h5>
                                    <p class="about__timeline-text">{{ $item['text'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- ─── TAB 3: REFLECTION ─── --}}
                    <div class="about__pane about__pane--reflection about__card" id="aboutPane-reflection" role="tabpanel">
                        <div class="about__reflection-head">
                            <span>The Revelation of Mongalo</span>
                            <h4>A Cinematic Identity</h4>
                            <p>Watch the 25-second animated identity preview. A longer 90-second narrated ministry film can build on this five-scene sequence.</p>
                        </div>
                        <div class="about__player">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=1200&q=80" alt="" class="about__player-bg">
                            <div class="about__player-top">
                                <span>A Walk That Started Over and Over</span>
                                <span class="about__player-badge">HD 1080p</span>
                            </div>
                            <div class="about__player-center">
                                <button type="button" class="about__player-play" aria-label="Play reflection">AM</button>
                                <div class="about__player-controls">
                                    <button type="button" aria-label="Rewind">◀◀</button>
                                    <button type="button" class="about__player-pause" aria-label="Pause">❚❚</button>
                                    <button type="button" aria-label="Forward">▶▶</button>
                                </div>
                            </div>
                            <div class="about__player-scrub">
                                <span>00:10</span>
                                <div class="about__player-bar"><div class="about__player-fill"></div></div>
                                <span>00:25</span>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="about__divider"></div>
                {{-- ─── SECTION 4: PILLARS ─── --}}
                <section class="about__pillars">
                    <div class="about__pillars-head">
                        <span class="about__kicker">Core Convictions</span>
                        <h3 class="about__section-title about__section-title--bold">Pillars of <span>Transformation</span></h3>
                        <p>The non-negotiable spiritual realities that anchored Arthur's turn from corporate ambition toward unreserved ministry.</p>
                    </div>
                    <div class="about__pillars-grid">
                        <div class="about__card about__pillar">
                            <div class="about__pillar-main">
                                <span class="about__pillar-num">01</span>
                                <h4>Grace Over Performance</h4>
                                <p>True freedom was discovered the moment legalistic striving died. Righteousness is received as an unearned gift, not earned as a fragile trophy.</p>
                            </div>
                            <span class="about__pillar-ref">ROMANS 5:1–2</span>
                        </div>
                        <div class="about__card about__pillar">
                            <div class="about__pillar-main">
                                <span class="about__pillar-num">02</span>
                                <h4>Radical Discipleship</h4>
                                <p>Following Christ is not an intellectual assent, but daily surrender. Arthur carries an urgency to train leaders who reproduce godly character in every sector.</p>
                            </div>
                            <span class="about__pillar-ref">LUKE 9:23–24</span>
                        </div>
                        <div class="about__card about__pillar">
                            <div class="about__pillar-main">
                                <span class="about__pillar-num">03</span>
                                <h4>The Written &amp; Spoken Word</h4>
                                <p>Scripture breathed through literature, recorded sermons, and digital outreach reaches across borders to ignite dormant spirits with eternal perspective.</p>
                            </div>
                            <span class="about__pillar-ref">2 TIMOTHY 3:16</span>
                        </div>
                    </div>
                </section>
                {{-- ─── SECTION 5: QUICK FACTS ─── --}}
                <section class="about__facts">
                    <div class="about__facts-head">
                        <span class="about__kicker">Quick Facts</span>
                        <h3 class="about__section-title about__section-title--bold">A Few Things <span>About Me</span></h3>
                    </div>
                    <div class="about__facts-grid">
                        @foreach($facts as $index => $fact)
                            <div class="about__card about__fact">
                                <span class="about__fact-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <p>{{ $fact }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
                {{-- ─── SECTION 6: PASTORAL NOTE ─── --}}
                <section class="about__card about__note">
                    <div class="about__note-inner">
                        <span class="about__note-kicker">A Pastoral Note to the Reader</span>
                        <h3 class="about__note-title">“My story is still being written, and so is yours.”</h3>
                        <p>If there is one thing I have learned along this walk, it is that God never wastes a wound. The seasons where you felt unseen, misunderstood, or utterly broken are the very soil where your most profound kingdom authority is formed.</p>
                        <p>Do not be intimidated by your past, and do not rush through the silent seasons of preparation. When God calls you, He equips you with a grace sufficient for every storm.</p>
                        <div class="about__note-foot">
                            <div>
                                <span class="about__note-name">Arthur Mongalo</span>
                                <span class="about__note-role">Founder &amp; Servant, Arthur Mongalo Ministry</span>
                            </div>
                            <div class="about__note-chip">Anchor: 2 Corinthians 12:9</div>
                        </div>
                    </div>
                </section>
                {{-- ─── SECTION 7: CALL TO ACTION ─── --}}
                <section class="about__actions">
                    <a href="{{ route('books.index') }}" class="about__btn about__btn--primary">Explore Books &amp; Teachings</a>
                    <a href="{{ route('community') }}" class="about__btn about__btn--ghost">Join the iN Community</a>
                    <a href="{{ route('invite') }}" class="about__btn about__btn--ghost">Invite Arthur to Speak</a>
                </section>
            </div>
        </div>
        {{-- ─── FOOTER ─── --}}
        <footer class="about__footer">
            <div class="about__footer-inner">
                <div class="about__footer-brand">
                    <span class="about__footer-mark">AM</span>
                    <span>Arthur Mongalo Ministry</span>
                </div>
                <p>&copy; {{ date('Y') }} Arthur Mongalo. All rights reserved. Personal Testimony Archive.</p>
                <div class="about__footer-links">
                    <a href="{{ route('privacy') }}">Privacy</a>
                    <a href="{{ route('terms') }}">Terms</a>
                    <a href="{{ route('contact') }}">Contact Ministry</a>
                </div>
            </div>
        </footer>
    </div>
@endsection

@push('scripts')
    <script src="{{ secure_asset('js/v160/about.js') }}"></script>
@endpush