@props([
    'selected' => '7d',
    'totalOrder' => 'xxxx',
    'totalUser' => 'xxxx',
    'orderHref' => '#',
    'userHref' => '#',
])

@php
    $format = fn ($value) => is_numeric($value) ? number_format($value, 0, ',', '.') : $value;
    $manage = 'inline-flex h-12 shrink-0 items-center justify-center rounded-md bg-sage px-3 text-[18px] font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none';
@endphp

<section {{ $attributes->class('w-full rounded-2xl border border-sand bg-white p-4 sm:p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-8') }}>
    <x-admin-range-select :selected="$selected" navigate="true" />

    <div class="mt-3 h-[240px] sm:h-[320px] w-full rounded-lg bg-cream-dark md:h-[500px]">{{ $chart ?? '' }}</div>

    <div class="mt-3 flex min-h-[64px] sm:min-h-[76px] items-center justify-between gap-3 border-t border-muted/40 px-1 sm:px-2.5">
        <p class="text-sm sm:text-base md:text-[18px] font-medium text-black">Total Order : {{ $format($totalOrder) }}</p>
        <a href="{{ $orderHref }}" class="inline-flex h-9 sm:h-11 shrink-0 items-center justify-center rounded-md bg-sage px-3 text-xs sm:text-sm md:text-base font-light text-white transition duration-200 hover:brightness-95">Manage</a>
    </div>

    <div class="flex min-h-[64px] sm:min-h-[76px] items-center justify-between gap-3 border-t border-muted/40 px-1 sm:px-2.5">
        <p class="text-sm sm:text-base md:text-[18px] font-medium text-black">Total User : {{ $format($totalUser) }}</p>
        <a href="{{ $userHref }}" class="inline-flex h-9 sm:h-11 shrink-0 items-center justify-center rounded-md bg-sage px-3 text-xs sm:text-sm md:text-base font-light text-white transition duration-200 hover:brightness-95">Manage</a>
    </div>
</section>