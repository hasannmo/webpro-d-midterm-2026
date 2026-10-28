@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <x-hero-banner :slides="$heroSlides" />

    <section class="section">
        <div class="section__inner hero-cards-wrap">
            <x-main-carousel :items="$heroCardItems" />
        </div>
    </section>

    <section class="section">
        <div class="section__inner">
            <h2 class="section-title">Popular Product</h2>
            <x-product-table :items="$popularProducts" />
        </div>
    </section>

    <section class="section">
        <div class="section__inner">
            <h2 class="section-title">Top Wear</h2>
            <x-section-carousel :items="$topWearProducts" />
        </div>
    </section>

    <section class="section">
        <div class="section__inner">
            <h2 class="section-title">Outer Wear</h2>
            <x-section-carousel :items="$outerWearProducts" />
        </div>
    </section>

    <section class="section">
        <div class="section__inner">
            <h2 class="section-title">Bottom Wear</h2>
            <x-section-carousel :items="$bottomWearProducts" />
        </div>
    </section>
@endsection

