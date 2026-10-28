@props([
    'products' => [],
    'addHref' => '#',
])

<section {{ $attributes->class('w-full rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-9') }}>
    <h1 class="text-[32px] font-bold leading-tight text-black">Product Management</h1>

    <a href="{{ $addHref }}"
       class="mt-6 inline-flex h-11 items-center justify-center rounded-lg bg-warning px-4 text-base font-medium text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
        Add Product
    </a>

    <div class="mt-5 grid gap-4 [grid-template-columns:repeat(auto-fill,minmax(min(100%,190px),1fr))] md:[grid-template-columns:repeat(auto-fill,minmax(min(100%,210px),1fr))]">
        @foreach ($products as $product)
            <article class="flex flex-col rounded-xl border border-sand bg-white p-2.5 shadow-sm transition hover:shadow-md">
                <div class="relative w-full aspect-[3/4] overflow-hidden rounded-lg bg-white">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy"
                         class="h-full w-full object-contain">
                </div>

                <div class="flex-1 px-1 pt-2.5 pb-2">
                    <p class="text-sm font-light uppercase leading-snug text-ink truncate" title="{{ $product['name'] }}">{{ $product['name'] }}</p>
                    <p class="mt-0.5 text-sm font-light leading-tight text-brand-text">IDR {{ number_format($product['price'], 0, ',', '.') }}</p>
                </div>

                <div class="flex gap-2 pt-1">
                    <a href="{{ $product['editHref'] ?? '#' }}"
                       class="flex h-9 flex-1 items-center justify-center rounded-md bg-sage text-sm font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
                        Edit
                    </a>

                    <form method="POST" action="{{ $product['removeAction'] ?? '#' }}" class="flex-1"
                          onsubmit="return confirm('Remove this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex h-9 w-full cursor-pointer items-center justify-center rounded-md bg-danger text-sm font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
                            Remove
                        </button>
                    </form>
                </div>
            </article>
        @endforeach
    </div>
</section>