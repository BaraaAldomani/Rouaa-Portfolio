@php($locale = app()->getLocale())
@php($introParas = preg_split('/\n\n+/', trim(setting_text('training.intro'))))
@php($levelClass = ['beginner' => 'badge-beginner', 'intermediate' => 'badge-intermediate', 'advanced' => 'badge-advanced'])

<x-layout :meta="$meta">
    <x-page-hero :title="setting_text('pages.training_title')" :lead="setting_text('pages.training_lead')" />

    <div class="section-y relative">
        <div class="container-x relative z-10">
            {{-- ═══════════════ INTRO + PARTNER BOX ═══════════════ --}}
            <div class="grid gap-8 lg:grid-cols-[1.4fr_1fr]">
                <div>
                    <span class="eyebrow reveal">{{ setting_text('training.intro_heading') }}</span>
                    <div class="reveal mt-6 space-y-4 text-[1.02rem] leading-relaxed text-muted" style="--d:.06s">
                        @foreach ($introParas as $para)
                            <p>{{ $para }}</p>
                        @endforeach
                    </div>
                </div>

                <aside class="reveal-start glass p-8 text-center" style="--d:.1s">
                    <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-primary-50 text-4xl" aria-hidden="true">🎓</div>
                    <h2 class="mt-5 font-display text-lg font-800 text-ink">{{ setting_text('training.partner_heading') }}</h2>
                    <div class="mt-3 inline-flex rounded-full bg-primary px-4 py-1.5 text-sm font-700 text-white">{{ setting('training.partner_cert', 'TOT Certified') }}</div>
                    <p class="mt-5 text-sm text-muted">{{ setting_text('training.partner_collab_pre') }}</p>
                    <div class="font-display text-lg font-800 text-primary-700">{{ setting('training.partner_name', 'LearningGo') }}</div>
                    <p class="mt-1 text-sm text-muted">{{ setting_text('training.partner_collab_post') }}</p>
                </aside>
            </div>

            {{-- ═══════════════ SERIES ═══════════════ --}}
            <div class="mt-16 space-y-14">
                @foreach ($site->trainingSeries() as $i => $series)
                    <section>
                        <div class="reveal flex items-center gap-4">
                            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 font-display text-xl font-800 text-white">{{ $i + 1 }}</div>
                            <div>
                                <h2 class="font-display text-xl font-800 text-ink sm:text-2xl">{{ $series->localized('title') }}</h2>
                                <span class="pill mt-1.5">{{ $series->localized('tag') }}</span>
                            </div>
                        </div>

                        <div class="mt-7 grid gap-6 md:grid-cols-3" data-stagger="0.08">
                            @foreach ($series->courses as $course)
                                <article class="reveal glass card-lift flex flex-col p-6">
                                    <div class="flex items-center justify-between">
                                        <div class="grid h-12 w-12 place-items-center rounded-xl bg-primary-50 text-2xl" aria-hidden="true">{{ $course->icon }}</div>
                                        <span class="badge-level {{ $levelClass[$course->level] ?? 'badge-beginner' }}">{{ __('common.level_' . $course->level) }}</span>
                                    </div>
                                    <h3 class="mt-4 font-display text-base font-800 leading-snug text-ink">{{ $course->localized('title') }}</h3>
                                    <p class="mt-2.5 text-sm leading-relaxed text-muted">{{ $course->localized('description') }}</p>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>

            {{-- ═══════════════ TRAINING CTA ═══════════════ --}}
            <div class="reveal mt-16 overflow-hidden rounded-[2rem] bg-gradient-to-br from-primary-500 to-primary-700 p-10 text-center text-white sm:p-14">
                <div class="text-4xl" aria-hidden="true">✉️</div>
                <h2 class="mt-4 font-display text-2xl font-800 sm:text-3xl">{{ setting_text('training.cta_heading') }}</h2>
                <p class="mx-auto mt-3 max-w-2xl text-white/90">{{ setting_text('training.cta_text') }}</p>
                <div class="mt-7">
                    <a href="{{ route('contact', ['locale' => $locale]) }}" class="btn-ghost !bg-white !text-primary-700">
                        {{ setting_text('training.cta_button') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
