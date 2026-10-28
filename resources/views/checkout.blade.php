@extends('layouts.app')

@section('title', 'Checkout — ' . $product['name'])

@section('content')
    <section class="section py-12 md:py-20">
        <div class="section__inner max-w-4xl mx-auto">
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

