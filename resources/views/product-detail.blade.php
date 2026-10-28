@extends('layouts.app')

@section('title', $product['name'] . ' — mijusan')

@section('content')
    <section class="section pt-6 pb-16">
        <div class="section__inner">
            <div class="mb-6 flex items-center">
                <a href="{{ route('home') }}"
                   class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-ink shadow-[0_2px_8px_rgb(43_36_32/0.12)] transition duration-200 hover:bg-brand hover:text-white"
                   aria-label="Back to home">
                    <x-icon name="arrow-left" :size="20" />
                </a>
            </div>

            <div class="grid grid-cols-1 items-start gap-10 md:grid-cols-2 md:gap-14 lg:gap-20">
                <div class="flex w-full items-center justify-center rounded-2xl bg-white p-8 md:p-14 shadow-[0_4px_20px_rgb(43_36_32/0.05)]">
                    <img src="{{ $product['image'] }}"
                         alt="{{ $product['name'] }}"
                         class="aspect-square max-h-[460px] w-full object-contain">
                </div>

                <div class="flex flex-col justify-center pt-2 md:pt-6">
                    <x-product-detail
                        :name="$product['name']"
                        :price="$product['price']"
                        :description="$product['description']"
                        :wishlisted="$isWishlisted"
                        :toggle-url="route('wishlist.toggle', ['productId' => $product['id']])"
                        :checkout-href="route('checkout.show', ['productName' => $product['slug']])" />
                </div>
            </div>
        </div>
    </section>

    <section class="section pb-20">
        <div class="section__inner">
            <h2 class="mb-8 font-serif text-3xl font-semibold text-ink md:text-4xl">
                Discover your style
            </h2>

            <div class="grid gap-4" style="grid-template-columns: repeat(auto-fill, minmax(min(100%, 260px), 1fr));">
                @foreach ($discoverProducts as $item)
                    <x-product-card
                        :name="$item['name']"
                        :price="$item['price']"
                        :image="$item['image']"
                        :second-image="$item['secondImage'] ?? null"
                        :href="$item['href'] ?? '#'" />
                @endforeach
            </div>
        </div>
    </section>
@endsection

