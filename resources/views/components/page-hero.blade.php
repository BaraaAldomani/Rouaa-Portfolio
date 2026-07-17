@props(['title', 'lead' => null])

<section class="page-hero">
    <div class="container-x relative z-10 py-16 text-center sm:py-24">
        <h1 class="reveal font-display text-4xl font-900 leading-tight text-ink sm:text-5xl">
            {{ $title }}
        </h1>
        @if ($lead)
            <p class="reveal mx-auto mt-5 max-w-2xl text-lg text-muted" style="--d:.08s">
                {{ $lead }}
            </p>
        @endif
        {{ $slot }}
    </div>
</section>
