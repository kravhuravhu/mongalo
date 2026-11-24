# v1.6.0: iN brands and CTA channels

The ministry is branded around **iN** (iN Community today, possibly iN Church and others later). Everything an iN page needs is shared, so a new one is a config entry plus one page, not a rebuild.

## What is shared

| Piece | Where | Purpose |
|---|---|---|
| Brand registry | `config/in.php` | Name, tagline, quote, theme colours, hero CTAs, event categories |
| Brand CSS system | `public/css/v160/in.css` | `.in` root, monogram, buttons, back pill, footer, banner. Reads theme from CSS variables |
| Monogram | `components/v160/in-monogram.blade.php` | White "i" and accent "N" |
| Footer | `components/v160/in-footer.blade.php` | Quote, gatherings, connect links, legal. Slot for a banner |
| CTA link | `components/v160/cta-link.blade.php` | External link that opens the "coming soon" modal when its URL is empty |
| CTA modal | `components/v160/cta-modal.blade.php` | Already included by `layouts/v160/app.blade.php` on every page |
| CTA channels | `config/social.php` | WhatsApp, Instagram, Facebook, YouTube (values come from `.env`) |

## Theming

The page root sets the theme from config, so colours never live in CSS:

```blade
<div class="in in--church"
    style="--in-bg: {{ $theme['bg'] }}; --in-surface: {{ $theme['surface'] }}; --in-accent: {{ $theme['accent'] }}; --in-accent-hover: {{ $theme['accent_hover'] }}; --in-accent-soft: {{ $theme['accent_soft'] }}; --in-accent-text: {{ $theme['accent_text'] }};">
```

`in.css` styles anything inside `.in` using those variables. Page-specific CSS goes in `public/css/v160/<brand>.css`, nested under `.in.in--<brand>` (see `community.css`).

## Adding a new iN (example: iN Church)

1. **Config.** Copy the commented `church` block at the bottom of `config/in.php`, set `'active' => true`, and fill name, slug, route, tagline, quote, theme and CTAs.
2. **Route.** `Route::get('/church', [ChurchController::class, 'index'])->name('church');`
3. **Controller.** Read `config('in.brands.church')` and pass it to the view as `$brand`.
4. **View.** `resources/views/public/church/v160/index.blade.php`, using `@extends('layouts.v160.app')`, the root `<div>` above, `<x-v160.in-monogram>`, `<x-v160.cta-link>` and `<x-v160.in-footer>`.
5. **CSS.** Load `in.css` first, then `public/css/v160/church.css` for the page-specific parts.
6. **Home page.** Add a card or link to the new page if it should be discoverable.

## CTA channels and the "coming soon" modal

Any link to Facebook, Instagram, YouTube or WhatsApp should use the component:

```blade
<x-v160.cta-link channel="youtube" class="your-class">Watch on YouTube</x-v160.cta-link>
```

- If the env value is set, it renders a normal external link.
- If it is empty, it renders `href="#"` and the click opens the modal ("Oops, you probably checked us out on YouTube...").
- Env keys: `WHATSAPP_INVITE_URL`, `INSTAGRAM_INVITE_URL`, `FACEBOOK_INVITE_URL`, `YOUTUBE_INVITE_URL`.
- To add a channel (for example TikTok), add an entry to `config/social.php`. No other code changes.

## Events (all categories, including baptisms and book tours)

Events are one model with a `category` and an optional recurrence, managed in the admin event form.

- **Categories** live in `config/in.php` under `event_categories`. `pinned` categories always get a tab on the community page.
- **Recurrence:** none, daily, weekly (with weekdays), monthly or yearly, with an interval and an optional end date. The event's own date is the first occurrence. Logic is in `App\Models\Event` (`occurrencesFrom`, `nextOccurrence`, `isOccurrence`, `recurrence_label`).
- **Registrations** for recurring events store the chosen `occurrence_date`.
- **Poster:** `poster_image` is uploaded in the admin form and stored in `storage/app/public/events/posters`. The community hero shows the next event that has one.
- Run `php artisan migrate` and make sure `php artisan storage:link` has been done.