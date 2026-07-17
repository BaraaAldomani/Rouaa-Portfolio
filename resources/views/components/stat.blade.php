@props(['stat'])
@php(preg_match('/^(\D*)(\d[\d,]*)(.*)$/u', $stat->value_display, $m))

<div {{ $attributes }}>
    <div class="stat-num text-2xl sm:text-3xl"
         @if ($m) data-count="{{ (int) str_replace(',', '', $m[2]) }}" data-prefix="{{ $m[1] }}" data-suffix="{{ $m[3] }}" @endif>
        {{ $stat->value_display }}
    </div>
    <div class="mt-1.5 text-xs font-500 text-muted">{{ $stat->localized('label') }}</div>
</div>
