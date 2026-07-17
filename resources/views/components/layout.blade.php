@props(['meta'])
@php($locale = app()->getLocale())
@php($logo = image_url(setting('images.logo'), 'portfolio.images.logo'))
@php($person = [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => setting_text('identity.name', 'common.brand'),
    'jobTitle' => $locale === 'ar' ? 'استشارية أعمال وأخصائية زكاة' : 'Business Consultant & Zakat Specialist',
    'description' => $meta->description,
    'url' => $meta->canonical,
    'image' => image_url(setting('images.og'), 'portfolio.images.og'),
    'email' => 'mailto:' . setting('contact.email', config('portfolio.email')),
    'telephone' => '+' . setting('contact.whatsapp', config('portfolio.whatsapp')),
    'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Riyadh', 'addressCountry' => 'SA'],
    'sameAs' => array_values(array_filter([
        setting('contact.linkedin', config('portfolio.linkedin')),
        setting('contact.youtube_url', config('portfolio.youtube')),
    ])),
    'knowsAbout' => ['Auditing', 'Zakat', 'Taxation', 'Feasibility Studies', 'Accounting', 'Financial Analysis', 'Professional Training'],
    'knowsLanguage' => ['Arabic', 'English'],
])
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $meta->title }}</title>
    <meta name="description" content="{{ $meta->description }}">
    <link rel="canonical" href="{{ $meta->canonical }}">
    @foreach ($meta->alternates as $altLocale => $url)
        <link rel="alternate" hreflang="{{ $altLocale }}" href="{{ $url }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ $meta->alternates['ar'] ?? $meta->canonical }}">

    <meta property="og:type" content="profile">
    <meta property="og:locale" content="{{ $locale === 'ar' ? 'ar_SA' : 'en_US' }}">
    <meta property="og:title" content="{{ $meta->title }}">
    <meta property="og:description" content="{{ $meta->description }}">
    <meta property="og:url" content="{{ $meta->canonical }}">
    <meta property="og:image" content="{{ $logo }}">
    <meta name="twitter:card" content="summary">

    <link rel="icon" type="image/jpeg" href="{{ $logo }}">
    <link rel="apple-touch-icon" href="{{ $logo }}">

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=cairo:300,400,500,600,700,800,900|inter:400,500,600,700,800&display=swap" rel="stylesheet">

    <script>document.documentElement.classList.add('js')</script>
    @vite(['resources/css/app.css', 'resources/js/sky.js'])

    {{-- Dashboard-managed brand colours. These override the three base tokens in
         tokens.css; every derived shade/surface/glass/orb recomputes via color-mix(). --}}
    <style>:root{--brand-primary:{{ setting('theme.primary', '#1B9BD2') }};--brand-secondary:{{ setting('theme.secondary', '#16384C') }};--brand-accent:{{ setting('theme.accent', '#35C3EE') }};}</style>

    <script type="application/ld+json">{!! json_encode($person, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</head>
<body class="relative min-h-screen bg-surface text-ink antialiased">
    {{-- Global soft sky wash — three blurred orbs with gentle scroll parallax. --}}
    <div class="orbs" style="position:fixed;z-index:0" aria-hidden="true">
        <div class="orb orb-1" data-speed="0.05"></div>
        <div class="orb orb-2" data-speed="-0.04"></div>
        <div class="orb orb-3" data-speed="0.03"></div>
    </div>

    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:start-4 focus:top-4 focus:z-[60] focus:rounded-full focus:bg-primary focus:px-4 focus:py-2 focus:text-white">
        {{ __('common.skip_to_content') }}
    </a>

    <div class="relative z-10">
        <x-site-nav :alternates="$meta->alternates" />

        <main id="main">
            {{ $slot }}
        </main>

        <x-site-footer />
    </div>
</body>
</html>
