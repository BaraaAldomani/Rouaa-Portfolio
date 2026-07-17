@php($locale = app()->getLocale())

<x-layout :meta="$meta">
    <x-page-hero :title="setting_text('pages.services_title')" :lead="setting_text('pages.services_lead')" />

    {{-- ═══════════════ SERVICE DETAILS ═══════════════ --}}
    <section class="section-y relative">
        <div class="container-x relative z-10 space-y-6" data-stagger="0.1">
            @foreach ($site->services() as $service)
                <article class="reveal glass card-lift grid gap-6 p-7 sm:grid-cols-[auto_1fr] sm:p-9">
                    <div class="grid h-16 w-16 place-items-center rounded-2xl bg-primary-50 text-4xl shadow-[0_14px_30px_-18px_var(--brand-shadow-primary)]" aria-hidden="true">
                        {{ $service->icon }}
                    </div>
                    <div>
                        <h2 class="font-display text-2xl font-800 text-ink">{{ $service->localized('title') }}</h2>
                        <p class="mt-3 leading-relaxed text-muted">{{ $service->localized('description') }}</p>

                        @if (count($service->features()))
                            <div class="mt-5 flex flex-wrap gap-2.5">
                                @foreach ($service->features() as $feature)
                                    <span class="pill">{{ $feature }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if ($service->localized('legal_note'))
                            <div class="mt-5 flex items-start gap-2.5 rounded-2xl border border-primary-200 bg-primary-50 p-4 text-sm text-primary-900">
                                <span aria-hidden="true">ℹ️</span>
                                <span>{{ $service->localized('legal_note') }}</span>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════ CTA BAND ═══════════════ --}}
    <section class="relative z-10 overflow-hidden bg-surface-dark on-dark">
        <div class="container-x py-16 text-center">
            <h2 class="reveal font-display text-3xl font-800 sm:text-4xl">{{ setting_text('contact.cta_heading') }}</h2>
            <p class="reveal mx-auto mt-4 max-w-2xl text-muted-on-dark" style="--d:.06s">{{ setting_text('contact.cta_text') }}</p>
            <div class="reveal mt-8" style="--d:.12s">
                <a href="{{ route('contact', ['locale' => $locale]) }}" class="btn-sky">
                    {{ setting_text('contact.cta_button') }}
                </a>
            </div>
        </div>
    </section>
</x-layout>
