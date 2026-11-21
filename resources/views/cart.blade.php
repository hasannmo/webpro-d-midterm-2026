@extends('layouts.app')

@section('title', 'Shopping Cart — mijusan')

@section('content')
    <section class="section py-6 md:py-14">
        <div class="section__inner max-w-5xl mx-auto">
            <div class="mb-6 flex items-center justify-between">
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ route('home') }}"
                       class="inline-flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full bg-white text-ink shadow-[0_2px_8px_rgb(43_36_32/0.12)] transition duration-200 hover:bg-brand hover:text-white"
                       aria-label="Back to home">
                        <x-icon name="arrow-left" :size="18" class="sm:h-5 sm:w-5" />
                    </a>
                    <h1 class="font-serif text-2xl font-semibold text-ink sm:text-3xl md:text-4xl">
                        Shopping Cart
                    </h1>
                </div>
                <span class="text-sm sm:text-base text-muted font-medium">
                    {{ $cartItems->sum('quantity') }} {{ Str::plural('item', $cartItems->sum('quantity')) }}
                </span>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if ($cartItems->count() > 0)
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    {{-- Cart Items List --}}
                    <div class="lg:col-span-2 space-y-4">
                        <div class="rounded-2xl border border-sand bg-white p-4 sm:p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)]">
                            <ul class="divide-y divide-sand/70">
                                @foreach ($cartItems as $item)
                                    <li class="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4" id="cart-item-{{ $item->id }}">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('product.show', ['productName' => $item->product->slug]) }}" class="shrink-0">
                                                <div class="h-20 w-20 sm:h-24 sm:w-24 overflow-hidden rounded-xl border border-sand bg-cream flex items-center justify-center p-2">
                                                    <img src="{{ $item->product->image_url }}"
                                                         alt="{{ $item->product->name }}"
                                                         class="h-full w-full object-contain">
                                                </div>
                                            </a>
                                            <div class="min-w-0 flex-1">
                                                <a href="{{ route('product.show', ['productName' => $item->product->slug]) }}"
                                                   class="font-heading text-sm sm:text-base font-medium text-ink hover:text-brand-text line-clamp-1">
                                                    {{ $item->product->name }}
                                                </a>
                                                <p class="mt-1 text-xs sm:text-sm font-semibold text-brand-text">
                                                    IDR {{ number_format($item->product->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between sm:justify-end gap-6 pt-2 sm:pt-0 border-t sm:border-t-0 border-sand/50">
                                            {{-- Quantity Controls --}}
                                            <div class="flex items-center rounded-lg border border-sand bg-cream">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                    <button type="submit"
                                                            class="h-8 w-8 inline-flex items-center justify-center text-ink hover:text-brand transition disabled:opacity-40"
                                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                                            aria-label="Decrease quantity">
                                                        <x-icon name="minus" :size="14" />
                                                    </button>
                                                </form>

                                                <span class="w-8 text-center text-xs sm:text-sm font-semibold text-ink">
                                                    {{ $item->quantity }}
                                                </span>

                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                    <button type="submit"
                                                            class="h-8 w-8 inline-flex items-center justify-center text-ink hover:text-brand transition"
                                                            aria-label="Increase quantity">
                                                        <x-icon name="plus" :size="14" />
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- Line Subtotal --}}
                                            <div class="text-right min-w-[110px]">
                                                <span class="text-xs text-muted block sm:hidden">Total</span>
                                                <span class="text-sm sm:text-base font-semibold text-ink">
                                                    IDR {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </span>
                                            </div>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-1.5 text-muted hover:text-red-600 transition"
                                                        aria-label="Remove item"
                                                        onclick="return confirm('Remove this item from your cart?')">
                                                    <x-icon name="trash" :size="18" />
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="lg:col-span-1">
                        <div class="sticky top-24 rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)]">
                            <h2 class="font-serif text-xl font-semibold text-ink border-b border-sand pb-4">
                                Order Summary
                            </h2>

                            <div class="mt-4 space-y-3 text-sm">
                                <div class="flex justify-between text-muted">
                                    <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                    <span class="font-medium text-ink">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-muted">
                                    <span>Shipping Estimate</span>
                                    <span class="font-medium text-ink">Free</span>
                                </div>
                                <div class="border-t border-sand pt-4 flex justify-between font-serif text-lg font-bold text-ink">
                                    <span>Total</span>
                                    <span class="text-brand-text">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <form action="{{ route('cart.checkout') }}" method="POST" class="mt-6">
                                @csrf
                                <button type="submit"
                                        class="w-full inline-flex h-12 items-center justify-center rounded-xl bg-brand px-6 font-medium text-white shadow-md transition hover:bg-brand-dark focus:outline-none">
                                    Proceed to Checkout
                                </button>
                            </form>

                            <div class="mt-4 text-center">
                                <a href="{{ route('home') }}" class="text-xs sm:text-sm text-muted hover:text-brand underline">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-sand bg-white p-12 text-center shadow-sm">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-cream text-muted mb-4">
                        <x-icon name="shopping-cart" :size="32" />
                    </div>
                    <p class="font-serif text-xl sm:text-2xl font-semibold text-ink">Your cart is empty</p>
                    <p class="mt-2 text-sm text-muted max-w-md mx-auto">Looks like you haven't added any curated pieces to your bag yet.</p>
                    <a href="{{ route('home') }}"
                       class="mt-6 inline-flex h-11 items-center justify-center rounded-lg bg-brand px-6 text-sm font-medium text-white transition hover:bg-brand-dark">
                        Discover Products
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
