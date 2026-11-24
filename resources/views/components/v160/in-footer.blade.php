@props(['brand', 'gatherings' => []])

<footer {{ $attributes->class(['in__footer']) }}>
    <div class="in__footer-inner">
        <div class="in__footer-cols">
            <div class="in__footer-brand">
                <x-v160.in-monogram size="sm" />
                <p class="in__footer-quote">&ldquo;{{ $brand['quote'] }}&rdquo;</p>
            </div>
            <div class="in__footer-col" id="gatherings">
                <h4>Gatherings</h4>
                <span class="in__footer-rule"></span>
                <ul>
                    @foreach($gatherings as $item)
                        <li><a href="{{ $item['href'] }}" @isset($item['filter']) data-filter="{{ $item['filter'] }}" @endisset>{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="in__footer-col">
                <h4>Connect</h4>
                <span class="in__footer-rule"></span>
                <ul>
                    <li><x-v160.cta-link channel="whatsapp">WhatsApp Group</x-v160.cta-link></li>
                    <li><x-v160.cta-link channel="instagram">Instagram Page</x-v160.cta-link></li>
                    <li><x-v160.cta-link channel="facebook">Facebook</x-v160.cta-link></li>
                    <li><x-v160.cta-link channel="youtube">YouTube</x-v160.cta-link></li>
                </ul>
            </div>
        </div>
        
        <div class="in__footer-legal">
            <p>&copy; {{ date('Y') }} Arthur Mongalo Ministry. All rights reserved.</p>
            <div>
                <a href="{{ route('privacy') }}">Privacy Policy</a>
                <a href="{{ route('terms') }}">Terms of Service</a>
            </div>
        </div>
        {{ $slot }}
    </div>
</footer>