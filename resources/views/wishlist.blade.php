@extends('layouts.app')

@section('title', 'Your Wishlist')

@section('content')
    <section class="section py-8 md:py-12">
        <div class="section__inner">
            <div class="mb-6 flex items-center gap-4">
                <a href="{{ route('home') }}"
                   class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-ink shadow-[0_2px_8px_rgb(43_36_32/0.12)] transition duration-200 hover:bg-brand hover:text-white"
                   aria-label="Back to Home">
                    <x-icon name="arrow-left" :size="20" />
                </a>
                <h1 class="font-serif text-3xl font-semibold text-ink md:text-4xl">
                    Your Wishlist
                </h1>
            </div>

            @if (count($wishlistItems))
                <x-product-table :items="$wishlistItems" :min="260" />
            @else
                <div class="rounded-2xl border border-sand bg-white p-12 text-center shadow-sm">
                    <p class="font-heading text-xl font-medium text-ink">Your wishlist is currently empty</p>
                    <p class="mt-2 text-sm text-muted">Explore our catalog and heart your favorite items to save them here.</p>
                    <a href="{{ route('home') }}"
                       class="mt-6 inline-flex h-11 items-center justify-center rounded-lg bg-brand px-6 text-sm font-medium text-white transition hover:bg-brand-dark">
                        Discover Products
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection


