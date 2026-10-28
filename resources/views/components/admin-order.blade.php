@props([
    'selected' => '7d',
    'total' => 'xxxx',
    'orders' => [],
    'paginator' => null,
])

@php
    $format = fn ($value) => is_numeric($value) ? number_format($value, 0, ',', '.') : $value;
    $date = fn ($value) => $value instanceof \DateTimeInterface ? $value->format('d/m/Y H:i:s') : $value;
@endphp

<section {{ $attributes->class('w-full rounded-2xl border border-sand bg-white p-4 sm:p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-8') }}>
    <x-admin-range-select :selected="$selected" navigate="true" />

    <div class="mt-3 h-[240px] sm:h-[320px] w-full overflow-hidden rounded-lg bg-cream-dark md:h-[500px]">{{ $chart ?? '' }}</div>

    <div class="mt-3 flex min-h-[60px] sm:min-h-[76px] items-center border-t border-muted/40 px-1 sm:px-2.5">
        <p class="text-sm sm:text-base md:text-[18px] font-medium text-black">Total Order : {{ $format($total) }}</p>
    </div>

    {{-- Table Header --}}
    <div class="hidden border-t border-muted/40 px-3 py-3 text-xs font-semibold tracking-wider text-muted uppercase md:grid md:grid-cols-[1.6fr_2fr_1.1fr_1.8fr_1.2fr] md:items-center md:gap-4">
        <span>Order ID</span>
        <span>Product</span>
        <span>Price</span>
        <span>Customer Email</span>
        <span class="text-right">Date & Time</span>
    </div>

    <ul>
        @forelse ($orders as $order)
            <li class="flex flex-col gap-1 border-t border-muted/20 px-2 py-2.5 text-xs md:text-sm font-light text-black md:grid md:min-h-[54px] md:grid-cols-[1.6fr_2fr_1.1fr_1.8fr_1.2fr] md:items-center md:gap-4 md:py-0">
                <div class="flex items-center justify-between md:block">
                    <span class="font-mono text-[11px] md:text-xs font-medium text-ink">{{ $order['id'] }}</span>
                    <span class="text-[10px] md:hidden text-muted whitespace-nowrap">{{ $date($order['date']) }}</span>
                </div>
                <span class="font-normal text-ink leading-tight pr-2 line-clamp-1 md:line-clamp-2" title="{{ $order['product'] }}">{{ $order['product'] }}</span>
                <div class="flex items-center justify-between md:block">
                    <span class="font-medium text-brand-text md:text-ink md:font-normal whitespace-nowrap text-xs md:text-sm">IDR {{ $format($order['price']) }}</span>
                    <a href="mailto:{{ $order['email'] }}" class="w-fit text-brand-text truncate text-xs hover:underline md:hidden" title="{{ $order['email'] }}">{{ $order['email'] }}</a>
                </div>
                <a href="mailto:{{ $order['email'] }}" class="hidden md:inline-block w-fit text-brand-text truncate hover:underline" title="{{ $order['email'] }}">{{ $order['email'] }}</a>
                <span class="hidden md:block text-xs text-muted md:text-right whitespace-nowrap">{{ $date($order['date']) }}</span>
            </li>
        @empty
            <li class="border-t border-muted/40 px-2.5 py-6 text-center text-muted">
                No orders found.
            </li>
        @endforelse
    </ul>

    @if ($paginator)
        <div class="mt-6 border-t border-muted/40 pt-6">
            {{ $paginator->links() }}
        </div>
    @endif
</section>
