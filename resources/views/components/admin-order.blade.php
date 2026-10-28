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

<section {{ $attributes->class('w-full rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-9') }}>
    <x-admin-range-select :selected="$selected" navigate="true" />

    <div class="mt-3 h-[280px] w-full overflow-hidden rounded-lg bg-cream-dark md:h-[560px]">{{ $chart ?? '' }}</div>

    <div class="mt-3 flex min-h-[82px] items-center border-t border-muted/40 px-2.5">
        <p class="text-[18px] font-medium text-black">Total Order : {{ $format($total) }}</p>
    </div>

    {{-- Table Header --}}
    <div class="hidden border-t border-muted/40 px-2.5 py-3 text-[16px] font-semibold text-muted md:grid md:grid-cols-[1.3fr_1.4fr_1fr_1.6fr_1.5fr] md:items-center md:gap-4">
        <span>Order ID</span>
        <span>Product</span>
        <span>Price</span>
        <span>Customer Email</span>
        <span class="md:text-right">Date & Time</span>
    </div>

    <ul>
        @forelse ($orders as $order)
            <li class="flex flex-col gap-1 border-t border-muted/40 px-2.5 py-4 text-[18px] font-light text-black md:grid md:min-h-[82px] md:grid-cols-[1.3fr_1.4fr_1fr_1.6fr_1.5fr] md:items-center md:gap-4 md:py-0">
                <span class="font-medium text-ink md:font-light">{{ $order['id'] }}</span>
                <span>{{ $order['product'] }}</span>
                <span>IDR {{ $format($order['price']) }}</span>
                <a href="mailto:{{ $order['email'] }}" class="w-fit text-brand-text underline">{{ $order['email'] }}</a>
                <span class="md:text-right">{{ $date($order['date']) }}</span>
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
