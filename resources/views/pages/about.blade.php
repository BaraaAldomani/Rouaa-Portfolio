@php($storyParas = preg_split('/\n\n+/', trim(setting_text('about.story'))))

<x-layout :meta="$meta">
    <x-page-hero :title="setting_text('pages.about_title')" :lead="setting_text('pages.about_lead')" />

    {{-- ═══════════════ STORY + TIMELINE ═══════════════ --}}
    <section class="section-y relative">
        <div class="container-x relative z-10 grid gap-14 lg:grid-cols-2">
            {{-- Story --}}
            <div>
                <span class="eyebrow reveal">{{ setting_text('about.story_heading') }}</span>
                <div class="reveal mt-6 space-y-4 text-[1.02rem] leading-relaxed text-muted" style="--d:.06s">
                    @foreach ($storyParas as $para)
                        <p>{{ $para }}</p>
                    @endforeach
                </div>

                {{-- Rakeez co-founder badge --}}
                <div class="reveal mt-8 flex items-center gap-4 glass p-5" style="--d:.12s">
                    <div class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-primary-50 text-3xl">🤝</div>
                    <div>
                        <div class="font-display font-800 text-ink">{{ setting_text('about.rakeez_title') }}</div>
                        <div class="text-sm text-muted">{{ setting_text('about.rakeez_text') }}</div>
                    </div>
                </div>

                {{-- Skills --}}
                <div class="reveal mt-8 flex flex-wrap gap-2.5" data-stagger="0.05" style="--d:.16s">
                    @foreach ($site->skills() as $skill)
                        <span class="pill reveal">{{ $skill->localized('label') }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Career timeline --}}
            <div>
                <h2 class="reveal font-display text-2xl font-800 text-ink">{{ setting_text('about.career_heading') }}</h2>
                <ol class="relative mt-8 space-y-6 border-s-2 border-line ps-6" data-stagger="0.08">
                    @foreach ($site->experiences() as $exp)
                        <li class="reveal-start relative">
                            <span class="absolute -start-[1.72rem] top-1.5 grid h-4 w-4 place-items-center rounded-full bg-primary ring-4 ring-surface" aria-hidden="true"></span>
                            <div class="glass card-lift p-5">
                                <div class="pill">{{ $exp->localized('period') }}</div>
                                <h3 class="mt-3 font-display text-lg font-800 text-ink">{{ $exp->localized('role') }}</h3>
                                <div class="text-sm font-600 text-primary-700">{{ $exp->localized('org') }}</div>
                                <p class="mt-2 text-sm leading-relaxed text-muted">{{ $exp->localized('description') }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    {{-- ═══════════════ EDUCATION ═══════════════ --}}
    <section class="section-y relative bg-surface-sky">
        <div class="container-x relative z-10">
            <div class="mx-auto max-w-2xl text-center">
                <span class="eyebrow reveal justify-center">{{ setting_text('about.education_eyebrow') }}</span>
                <h2 class="reveal mt-4 font-display text-3xl font-800 text-ink sm:text-4xl" style="--d:.06s">
                    {{ setting_text('about.education_title') }}
                </h2>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-stagger="0.08">
                @foreach ($site->education() as $edu)
                    <article class="reveal glass card-lift p-6">
                        <div class="grid h-11 w-11 place-items-center rounded-xl bg-primary-50 text-xl" aria-hidden="true">🎓</div>
                        <h3 class="mt-4 font-display text-base font-800 text-ink">{{ $edu->localized('institution') }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $edu->localized('detail') }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>
