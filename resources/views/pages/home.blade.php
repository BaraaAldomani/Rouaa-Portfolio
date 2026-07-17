@php($locale = app()->getLocale())
@php($heroLogo = image_url(setting('images.hero_logo'), 'portfolio.images.hero_logo'))
@php($name = setting_text('identity.name', 'common.brand'))
@php($nameParts = preg_split('/\s+/u', trim($name)))
@php($nameLast = count($nameParts) > 1 ? array_pop($nameParts) : '')
@php($nameFirst = implode(' ', $nameParts))

<x-layout :meta="$meta">
    {{-- ═══════════════ HERO ═══════════════ --}}
    <section class="relative overflow-hidden">
        <div class="container-x relative z-10 grid items-center gap-12 py-16 sm:py-24 lg:grid-cols-[1.15fr_.85fr]">
            <div class="text-center lg:text-start">
                <span class="eyebrow reveal justify-center lg:justify-start">{{ setting_text('identity.eyebrow') }}</span>

                <h1 class="reveal mt-5 font-display text-5xl font-900 leading-[1.08] text-ink sm:text-6xl" style="--d:.06s">
                    {{ $nameFirst }} <span class="gradient-text">{{ $nameLast }}</span>
                </h1>

                <p class="reveal mt-4 text-xl font-600 text-primary-700 sm:text-2xl" style="--d:.12s">
                    {{ setting_text('identity.tagline') }}
                </p>

                {{-- Hero stats --}}
                <div class="reveal mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4" data-stagger="0.08" style="--d:.18s">
                    @foreach ($site->stats('hero') as $stat)
                        <x-stat :stat="$stat" class="reveal glass-soft px-3 py-4 text-center" />
                    @endforeach
                </div>

                <div class="reveal mt-9 flex flex-wrap justify-center gap-3 lg:justify-start" style="--d:.26s">
                    <a href="{{ route('services', ['locale' => $locale]) }}" class="btn-sky">
                        {{ setting_text('identity.cta_primary') }}
                    </a>
                    <a href="{{ route('training', ['locale' => $locale]) }}" class="btn-ghost">
                        {{ setting_text('identity.cta_secondary') }}
                    </a>
                </div>
            </div>

            {{-- Floating logo with rotating dashed rings --}}
            <div class="reveal-start flex justify-center" style="--d:.2s">
                <div class="logo-orb">
                    <div class="logo-ring-2"></div>
                    <div class="logo-ring"></div>
                    <div class="logo-circle">
                        <img src="{{ $heroLogo }}" alt="{{ $name }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════ SERVICES STRIP ═══════════════ --}}
    <section class="section-y relative">
        <div class="container-x relative z-10">
            <div class="mx-auto max-w-2xl text-center">
                <span class="eyebrow reveal justify-center">{{ setting_text('home.strip_tag') }}</span>
                <h2 class="reveal mt-4 font-display text-3xl font-800 text-ink sm:text-4xl" style="--d:.06s">
                    {{ setting_text('home.strip_title') }}
                </h2>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-stagger="0.09">
                @foreach ($site->services() as $service)
                    <article class="reveal glass card-lift flex flex-col p-6">
                        <div class="grid h-14 w-14 place-items-center rounded-2xl bg-primary-50 text-3xl">{{ $service->icon }}</div>
                        <h3 class="mt-5 font-display text-lg font-800 text-ink">{{ $service->localized('title') }}</h3>
                        <p class="mt-2.5 text-sm leading-relaxed text-muted">{{ $service->localized('summary') }}</p>
                    </article>
                @endforeach
            </div>

            <div class="reveal mt-10 text-center">
                <a href="{{ route('services', ['locale' => $locale]) }}" class="btn-ghost">
                    {{ setting_text('home.services_cta') }}
                    <span aria-hidden="true">{{ $locale === 'ar' ? '←' : '→' }}</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══════════════ STATS BANNER ═══════════════ --}}
    <section class="relative z-10 overflow-hidden bg-surface-dark on-dark">
        <div class="container-x py-16">
            <div class="grid grid-cols-2 gap-8 text-center sm:grid-cols-3 lg:grid-cols-5" data-stagger="0.08">
                @foreach ($site->stats('banner') as $stat)
                    @php(preg_match('/^(\D*)(\d[\d,]*)(.*)$/u', $stat->value_display, $m))
                    <div class="reveal">
                        <div class="stat-num text-4xl sm:text-5xl"
                             @if ($m) data-count="{{ (int) str_replace(',', '', $m[2]) }}" data-prefix="{{ $m[1] }}" data-suffix="{{ $m[3] }}" @endif>
                            {{ $stat->value_display }}
                        </div>
                        <div class="mt-2 text-sm text-muted-on-dark">{{ $stat->localized('label') }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>
