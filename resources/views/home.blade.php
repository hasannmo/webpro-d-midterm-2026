@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="hero">
        <img src="{{ asset('images/'.$heroBanner) }}" alt="mijusan hero banner">
    </section>

    <section class="section">
        <div class="section__inner hero-cards-wrap">
            <x-carousel class="carousel__track--hero">
                @foreach ($heroCards as $image)
                    <img src="{{ asset('images/'.$image) }}" alt="Lookbook {{ $loop->iteration }}">
                @endforeach
            </x-carousel>
        </div>
    </section>

    <x-product-section title="Popular Product" :products="$popular" />

    <x-product-section title="Top Wear"    :products="$topWear"    carousel />
    <x-product-section title="Outer Wear"  :products="$outerWear"  carousel />
    <x-product-section title="Bottom Wear" :products="$bottomWear" carousel />
@endsection
