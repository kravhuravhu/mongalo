<div class="page page--legal">
    <x-v160.page-header />
    <div class="page__main">
        {{-- ─── HERO ─── --}}
        <section class="legal__hero">
            <span class="page__eyebrow">Legal</span>
            <h1 class="page__title">{{ $titleLead }} <span>{{ $titleAccent }}</span></h1>
            <p class="page__lead">{{ $subtitle }}</p>
            <span class="legal__meta"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i> Last updated: {{ $lastUpdated }}</span>
        </section>
        
        {{-- ─── BODY ─── --}}
        <section class="legal__body">
            <p class="legal__intro">{{ $intro }}</p>
            <div class="legal__sections">
                @foreach($sections as $section)
                    <article class="page__card legal__section">
                        <header class="legal__section-header">
                            <span class="legal__section-number">{{ $section['number'] }}</span>
                            <h2 class="legal__section-title">{{ $section['title'] }}</h2>
                        </header>
                        <div class="legal__section-body">
                            @foreach($section['body'] as $block)
                                @if(is_array($block))
                                    <ul class="legal__list">
                                        @foreach($block as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>{{ $block }}</p>
                                @endif
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="legal__footnote">
                <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                <p>{{ $footnote }}</p>
            </div>
            <div class="legal__actions">
                <a href="{{ route('contact') }}" class="page__btn page__btn--primary"><i class="fa-solid fa-envelope" aria-hidden="true"></i> Contact Us</a>
                <a href="{{ route('home') }}" class="page__btn page__btn--ghost"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back Home</a>
            </div>
        </section>
    </div>
    <x-v160.page-footer />
</div>