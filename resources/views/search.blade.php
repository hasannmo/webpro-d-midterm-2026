@extends('layouts.app')

@section('title', ($query ? 'Search results for "' . $query . '"' : 'Search Products') . ' — mijusan')

@section('content')
    <section class="section py-8 md:py-14">
        <div class="section__inner">
            <div class="mb-8 flex flex-col gap-2 border-b border-sand pb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}"
                       class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-ink shadow-[0_2px_8px_rgb(43_36_32/0.12)] transition duration-200 hover:bg-brand hover:text-white"
                       aria-label="Back to home">
                        <x-icon name="arrow-left" :size="20" />
                    </a>
                    <h1 class="font-serif text-3xl font-semibold text-ink md:text-4xl">
                        @if ($query)
                            Search Results for &ldquo;{{ $query }}&rdquo;
                        @else
                            Search Products
                        @endif
                    </h1>
                </div>

                @if ($query)
                    <p class="text-sm text-muted ml-14">
                        Found {{ $count }} {{ Str::plural('product', $count) }}
                    </p>
                @endif
            </div>

            @if ($count > 0)
                <x-product-table :items="$items" :min="260" />
            @else
                <div class="rounded-2xl border border-sand bg-white p-12 text-center shadow-sm max-w-2xl mx-auto">
                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-cream-dark text-muted mb-4">
                        <x-icon name="search" :size="32" />
                    </span>
                    <h2 class="font-heading text-xl font-medium text-ink">
                        @if ($query)
                            No products match your search &ldquo;{{ $query }}&rdquo;
                        @else
                            Enter a search keyword
                        @endif
                    </h2>
                    <p class="mt-2 text-sm text-muted">Try checking for spelling errors or searching for broader terms like "shirt", "blazer", "denim", or "jacket".</p>
                    <a href="{{ route('home') }}"
                       class="mt-6 inline-flex h-11 items-center justify-center rounded-lg bg-brand px-6 text-sm font-medium text-white transition hover:bg-brand-dark">
                        Browse All Products
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

