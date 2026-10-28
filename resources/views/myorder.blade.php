@extends('layouts.app')

@section('title', 'My Orders — mijusan')

@section('content')
    <section class="section py-8 md:py-14">
        <div class="section__inner max-w-5xl mx-auto">
            <div class="mb-6 flex items-center gap-4">
                <a href="{{ route('home') }}"
                   class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-ink shadow-[0_2px_8px_rgb(43_36_32/0.12)] transition duration-200 hover:bg-brand hover:text-white"
                   aria-label="Back to home">
                    <x-icon name="arrow-left" :size="20" />
                </a>
                <h1 class="font-serif text-3xl font-semibold text-ink md:text-4xl">
                    My Orders
                </h1>
            </div>

            @if ($orders->count())
                <div class="rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-8">
                    <div class="hidden border-b border-sand pb-3 text-xs font-semibold tracking-wider text-muted uppercase md:grid md:grid-cols-[1.4fr_2fr_1fr_1fr_1fr] md:gap-4">
                        <span>Order ID</span>
                        <span>Item</span>
                        <span>Price</span>
                        <span>Status</span>
                        <span class="text-right">Date</span>
                    </div>

                    <ul class="divide-y divide-sand/70">
                        @foreach ($orders as $order)
                            <li class="py-4 md:grid md:grid-cols-[1.4fr_2fr_1fr_1fr_1fr] md:items-center md:gap-4 text-sm">
                                <span class="font-mono text-xs md:text-sm font-medium text-ink">{{ $order->order_number }}</span>
                                <div class="mt-1 md:mt-0 font-medium text-ink">
                                    @if ($order->product)
                                        <a href="{{ route('product.show', ['productName' => $order->product->slug]) }}" class="hover:text-brand-text hover:underline">
                                            {{ $order->product_name }}
                                        </a>
                                    @else
                                        {{ $order->product_name }}
                                    @endif
                                </div>
                                <span class="text-brand-text font-medium whitespace-nowrap">IDR {{ number_format($order->price, 0, ',', '.') }}</span>
                                <div>
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-success capitalize border border-green-200">
                                        {{ $order->status }}
                                    </span>
                                </div>
                                <span class="text-xs text-muted md:text-right whitespace-nowrap">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    @if ($orders->hasPages())
                        <div class="mt-6 border-t border-sand pt-6">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            @else
                <div class="rounded-2xl border border-sand bg-white p-12 text-center shadow-sm">
                    <p class="font-heading text-xl font-medium text-ink">You haven't placed any orders yet</p>
                    <p class="mt-2 text-sm text-muted">When you checkout items, your receipts and order histories will appear here.</p>
                    <a href="{{ route('home') }}"
                       class="mt-6 inline-flex h-11 items-center justify-center rounded-lg bg-brand px-6 text-sm font-medium text-white transition hover:bg-brand-dark">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

