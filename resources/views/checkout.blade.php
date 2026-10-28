@extends('layouts.app')

@section('title', 'Checkout — ' . $product['name'])

@section('content')
    <section class="section py-8 md:py-16">
        <div class="section__inner max-w-4xl mx-auto">
            <div class="mb-6 flex items-center">
                <a href="{{ $cancelHref }}"
                   class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-ink shadow-[0_2px_8px_rgb(43_36_32/0.12)] transition duration-200 hover:bg-brand hover:text-white"
                   aria-label="Back to product">
                    <x-icon name="arrow-left" :size="20" />
                </a>
            </div>

            <x-checkout-card
                :name="$product['name']"
                :price="$product['price']"
                :image="$product['image']"
                :confirmed="$confirmed"
                :confirm-action="$confirmAction"
                :cancel-href="$cancelHref" />
        </div>
    </section>
@endsection

