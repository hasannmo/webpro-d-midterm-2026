@props([
    'products' => [],
    'addHref' => '#',
])

<section {{ $attributes->class('w-full rounded-2xl border border-sand bg-white p-4 sm:p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-8') }}>
    <h1 class="text-xl sm:text-2xl md:text-[32px] font-bold leading-tight text-black">Product Management</h1>

    <a href="{{ $addHref }}"
       class="mt-4 sm:mt-6 inline-flex h-9 sm:h-11 items-center justify-center rounded-lg bg-warning px-3 sm:px-4 text-xs sm:text-sm md:text-base font-medium text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
        Add Product
    </a>

    <div class="mt-4 sm:mt-5 grid grid-cols-2 gap-2.5 sm:gap-3.5 md:[grid-template-columns:repeat(auto-fill,minmax(min(100%,200px),1fr))]">
        @foreach ($products as $product)
            <article class="flex flex-col rounded-xl border border-sand bg-white p-2 sm:p-2.5 shadow-xs transition hover:shadow-md">
                <div class="relative w-full aspect-[3/4] overflow-hidden rounded-lg bg-white">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy"
                         class="h-full w-full object-contain">
                </div>

                <div class="flex-1 px-0.5 pt-1.5 pb-1 sm:pt-2 sm:pb-2">
                    <p class="text-[11px] sm:text-xs md:text-sm font-light uppercase leading-snug text-ink truncate" title="{{ $product['name'] }}">{{ $product['name'] }}</p>
                    <p class="mt-0.5 text-xs sm:text-sm font-light leading-tight text-brand-text">IDR {{ number_format($product['price'], 0, ',', '.') }}</p>
                </div>

                <div class="flex gap-1.5 pt-1">
                    <a href="{{ $product['editHref'] ?? '#' }}"
                       class="flex h-7 sm:h-8 flex-1 items-center justify-center rounded bg-sage text-[11px] sm:text-xs font-light text-white transition hover:brightness-95">
                        Edit
                    </a>

                    <form method="POST" action="{{ $product['removeAction'] ?? '#' }}" class="flex-1"
                          onsubmit="return confirm('Remove this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex h-7 sm:h-8 w-full cursor-pointer items-center justify-center rounded bg-danger text-[11px] sm:text-xs font-light text-white transition hover:brightness-95">
                            Remove
                        </button>
                    </form>
                </div>
            </article>
        @endforeach
    </div>
</section>