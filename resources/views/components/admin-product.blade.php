@props([
    'products' => [],
    'addHref' => '#',
])

<section {{ $attributes->class('w-full rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-9') }}>
    <h1 class="text-[32px] font-bold leading-tight text-black">Product Management</h1>

    <a href="{{ $addHref }}"
       class="mt-6 inline-flex h-[53px] items-center justify-center rounded-lg bg-warning px-3 text-[22px] font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
        Add Product
    </a>

    <div class="mt-3 grid gap-3 [grid-template-columns:repeat(auto-fill,minmax(min(100%,260px),1fr))]">
        @foreach ($products as $product)
            <article class="rounded-xl border border-sand bg-white p-2">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy"
                     class="block aspect-[284/385] w-full bg-cream-dark object-cover">

                <div class="px-2 pt-3 pb-3">
                    <p class="text-[18px] font-normal leading-tight text-ink">{{ $product['name'] }}</p>
                    <p class="mt-1 text-[18px] font-normal leading-tight text-ink">IDR {{ number_format($product['price'], 0, ',', '.') }}</p>
                </div>

                <div class="flex gap-2.5">
                    <a href="{{ $product['editHref'] ?? '#' }}"
                       class="flex h-12 flex-1 items-center justify-center rounded-md bg-sage text-[20px] font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
                        Edit
                    </a>

                    <form method="POST" action="{{ $product['removeAction'] ?? '#' }}" class="flex-1"
                          onsubmit="return confirm('Remove this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex h-12 w-full cursor-pointer items-center justify-center rounded-md bg-danger text-[20px] font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
                            Remove
                        </button>
                    </form>
                </div>
            </article>
        @endforeach
    </div>
</section>