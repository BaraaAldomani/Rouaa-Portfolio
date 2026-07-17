@php($locale = app()->getLocale())
@php($heroLogo = image_url(setting('images.hero_logo'), 'portfolio.images.hero_logo'))
@php($name = setting_text('identity.name', 'common.brand'))
@php($tagline = setting_text('identity.tagline'))
@php($email = setting('contact.email', config('portfolio.email')))
@php($phone = setting('contact.phone_display', config('portfolio.phone_display')))
@php($whatsapp = setting('contact.whatsapp', config('portfolio.whatsapp')))
@php($linkedin = setting('contact.linkedin', config('portfolio.linkedin')))
@php($youtube = setting('contact.youtube_url', config('portfolio.youtube')))
@php($navLinks = [
    ['route' => 'about', 'label' => __('nav.about')],
    ['route' => 'services', 'label' => __('nav.services')],
    ['route' => 'training', 'label' => __('nav.training')],
    ['route' => 'contact', 'label' => __('nav.contact')],
])

<footer class="relative z-10 mt-24 bg-surface-dark on-dark">
    <div class="container-x py-14">
        <div class="grid gap-12 md:grid-cols-3">
            {{-- Brand --}}
            <div class="md:col-span-1">
                <div class="flex items-center gap-3">
                    <img src="{{ $heroLogo }}" alt="{{ $name }}" class="h-14 w-14 rounded-2xl object-cover">
                    <div>
                        <div class="font-display text-xl font-800">{{ $name }}</div>
                        <div class="text-sm text-muted-on-dark">{{ $tagline }}</div>
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-3">
                    <a href="{{ $linkedin }}" target="_blank" rel="noopener" aria-label="{{ __('common.linkedin') }}"
                       class="grid h-10 w-10 place-items-center rounded-full border border-line-on-dark transition hover:bg-white/10">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.119 20.452H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="{{ $youtube }}" target="_blank" rel="noopener" aria-label="{{ __('common.youtube') }}"
                       class="grid h-10 w-10 place-items-center rounded-full border border-line-on-dark transition hover:bg-white/10">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="mailto:{{ $email }}" aria-label="{{ __('common.email_me') }}"
                       class="grid h-10 w-10 place-items-center rounded-full border border-line-on-dark transition hover:bg-white/10">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Quick links --}}
            <nav class="md:col-span-1" aria-label="{{ __('nav.main_navigation') }}">
                <h2 class="text-sm font-700 uppercase tracking-wide text-muted-on-dark">{{ __('nav.main_navigation') }}</h2>
                <ul class="mt-4 space-y-2.5">
                    @foreach ($navLinks as $link)
                        <li>
                            <a href="{{ route($link['route'], ['locale' => $locale]) }}" class="text-ink-on-dark/90 transition hover:text-white">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            {{-- Contact --}}
            <div class="md:col-span-1">
                <h2 class="text-sm font-700 uppercase tracking-wide text-muted-on-dark">{{ __('nav.get_in_touch') }}</h2>
                <ul class="mt-4 space-y-2.5 text-ink-on-dark/90">
                    <li><a href="mailto:{{ $email }}" class="transition hover:text-white" dir="ltr">{{ $email }}</a></li>
                    <li><a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="transition hover:text-white" dir="ltr">{{ $phone }}</a></li>
                    <li>{{ setting_text('contact.location', 'common.location') }}</li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-line-on-dark pt-6 text-sm text-muted-on-dark sm:flex-row">
            <p>{{ $name }} — {{ $tagline }}</p>
            <p>© {{ date('Y') }} {{ __('common.footer_rights') }}</p>
        </div>
    </div>
</footer>
