@php($locale = app()->getLocale())
@php($email = setting('contact.email', config('portfolio.email')))
@php($phone = setting('contact.phone_display', config('portfolio.phone_display')))
@php($whatsapp = setting('contact.whatsapp', config('portfolio.whatsapp')))
@php($linkedin = setting('contact.linkedin', config('portfolio.linkedin')))
@php($youtube = setting('contact.youtube_url', config('portfolio.youtube')))

<x-layout :meta="$meta">
    <x-page-hero :title="setting_text('pages.contact_title')" :lead="setting_text('pages.contact_lead')" />

    <section class="section-y relative">
        <div class="container-x relative z-10 grid gap-10 lg:grid-cols-[1fr_1.1fr]">
            {{-- ═══════════════ CONTACT DETAILS ═══════════════ --}}
            <div>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1" data-stagger="0.07">
                    <a href="mailto:{{ $email }}" class="reveal glass card-lift flex items-center gap-4 p-5">
                        <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-primary-50 text-2xl" aria-hidden="true">✉️</div>
                        <div>
                            <div class="text-xs font-600 uppercase tracking-wide text-muted">{{ __('nav.contact') }}</div>
                            <div class="font-600 text-ink" dir="ltr">{{ $email }}</div>
                        </div>
                    </a>
                    <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="reveal glass card-lift flex items-center gap-4 p-5">
                        <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-primary-50 text-2xl" aria-hidden="true">📞</div>
                        <div>
                            <div class="text-xs font-600 uppercase tracking-wide text-muted">{{ __('common.whatsapp') }}</div>
                            <div class="font-600 text-ink" dir="ltr">{{ $phone }}</div>
                        </div>
                    </a>
                    <div class="reveal glass flex items-center gap-4 p-5">
                        <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-primary-50 text-2xl" aria-hidden="true">📍</div>
                        <div>
                            <div class="text-xs font-600 uppercase tracking-wide text-muted">{{ __('common.location') }}</div>
                            <div class="font-600 text-ink">{{ setting_text('contact.location', 'common.location') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Socials --}}
                <div class="mt-8">
                    <h2 class="font-display text-lg font-800 text-ink">{{ setting_text('contact.social_heading') }}</h2>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener" class="btn-ghost">{{ __('common.linkedin') }}</a>
                        <a href="{{ $youtube }}" target="_blank" rel="noopener" class="btn-ghost">{{ setting_text('contact.youtube_label', 'common.youtube') }}</a>
                        <a href="mailto:{{ $email }}" class="btn-ghost">{{ __('common.email_me') }}</a>
                    </div>
                </div>
            </div>

            {{-- ═══════════════ FORM ═══════════════ --}}
            <div class="reveal-start glass p-7 sm:p-9" style="--d:.08s">
                <h2 class="font-display text-xl font-800 text-ink">{{ __('contact.form.title') }}</h2>

                @if (session('contact_sent'))
                    <div class="mt-5 rounded-2xl border border-success/30 bg-success-soft p-4 text-sm text-success" role="status">
                        {{ __('contact.form.success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store', ['locale' => $locale]) }}" class="mt-6 space-y-5">
                    @csrf

                    {{-- Honeypot: hidden from real users. --}}
                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-600 text-ink">{{ __('contact.form.name') }}</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               placeholder="{{ __('contact.form.name_placeholder') }}"
                               class="mt-2 w-full rounded-xl border border-line bg-white/70 px-4 py-3 text-ink outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/30">
                        @error('name') <p class="mt-1.5 text-sm text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-600 text-ink">{{ __('contact.form.email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required dir="ltr"
                               placeholder="{{ __('contact.form.email_placeholder') }}"
                               class="mt-2 w-full rounded-xl border border-line bg-white/70 px-4 py-3 text-ink outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/30">
                        @error('email') <p class="mt-1.5 text-sm text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-600 text-ink">{{ __('contact.form.message') }}</label>
                        <textarea id="message" name="message" rows="5" required
                                  placeholder="{{ __('contact.form.message_placeholder') }}"
                                  class="mt-2 w-full rounded-xl border border-line bg-white/70 px-4 py-3 text-ink outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/30">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1.5 text-sm text-danger">{{ $message }}</p> @enderror
                        @error('website') <p class="mt-1.5 text-sm text-danger">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-sky w-full">{{ __('contact.form.submit') }}</button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
