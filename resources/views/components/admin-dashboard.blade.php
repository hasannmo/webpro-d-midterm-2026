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

<section {{ $attributes->class('w-full rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-9') }}>
    <x-admin-range-select :selected="$selected" />

    <div class="mt-3 h-[280px] w-full rounded-lg bg-cream-dark md:h-[560px]">{{ $chart ?? '' }}</div>

    <div class="mt-3 flex min-h-[82px] items-center justify-between gap-4 border-t border-muted/40 px-2.5">
        <p class="text-[18px] font-medium text-black">Total Order : {{ $format($totalOrder) }}</p>
        <a href="{{ $orderHref }}" class="{{ $manage }}">Manage</a>
    </div>

    <div class="flex min-h-[82px] items-center justify-between gap-4 border-t border-muted/40 px-2.5">
        <p class="text-[18px] font-medium text-black">Total User : {{ $format($totalUser) }}</p>
        <a href="{{ $userHref }}" class="{{ $manage }}">Manage</a>
    </div>
</section>