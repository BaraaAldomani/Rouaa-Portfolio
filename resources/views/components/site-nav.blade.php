@props(['alternates' => []])
@php($locale = app()->getLocale())
@php($other = $locale === 'ar' ? 'en' : 'ar')
@php($logo = image_url(setting('images.logo'), 'portfolio.images.logo'))
@php($links = [
    ['route' => 'home', 'label' => __('nav.home')],
    ['route' => 'about', 'label' => __('nav.about')],
    ['route' => 'services', 'label' => __('nav.services')],
    ['route' => 'training', 'label' => __('nav.training')],
    ['route' => 'contact', 'label' => __('nav.contact')],
])

<nav class="site-nav" data-site-nav aria-label="{{ __('nav.main_navigation') }}">
    <div class="container-x flex items-center justify-between gap-4 py-3.5">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="flex items-center gap-2.5 shrink-0">
            <img src="{{ $logo }}" alt="{{ setting_text('identity.name', 'common.brand') }}" class="h-10 w-10 rounded-full object-cover ring-1 ring-line">
            <span class="font-display text-lg font-800 text-ink leading-none">{{ setting_text('identity.name', 'common.brand') }}</span>
        </a>

        <div class="body-nav-menu" data-nav-menu>
            @foreach ($links as $link)
                <a href="{{ route($link['route'], ['locale' => $locale]) }}"
                   class="nav-link"
                   @if (request()->routeIs($link['route'])) aria-current="page" @endif>
                    {{ $link['label'] }}
                </a>
            @endforeach

            <a href="{{ $alternates[$other] ?? route('home', ['locale' => $other]) }}"
               class="pill"
               hreflang="{{ $other }}"
               aria-label="{{ __('nav.switch_language') }}">
                {{ __('nav.switch_language') }}
            </a>

            <a href="{{ route('contact', ['locale' => $locale]) }}" class="btn-sky !py-2.5 !px-5 text-sm">
                {{ __('nav.get_in_touch') }}
            </a>
        </div>

        <button type="button" class="nav-toggle" data-nav-toggle aria-expanded="false" aria-label="{{ __('nav.open_menu') }}">
            <span class="hamburger" aria-hidden="true"><span></span><span></span><span></span></span>
        </button>
    </div>
</nav>
