@props(['channel'])
@php
    $info = config('social.channels.' . $channel, []);
    $url = trim((string) ($info['url'] ?? ''));
    $missing = $url === '' || $url === '#';
@endphp
<a href="{{ $missing ? '#' : $url }}"
    {{ $attributes }}
    data-cta="{{ $channel }}"
    data-cta-label="{{ $info['label'] ?? ucfirst($channel) }}"
    data-cta-noun="{{ $info['noun'] ?? 'page' }}"
    @if($missing)
        data-cta-missing="1" role="button"
    @else
        target="_blank" rel="noopener noreferrer"
    @endif
>{{ $slot }}</a>