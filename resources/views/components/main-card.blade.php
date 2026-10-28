@props([
    'name',
    'price',
    'image',
    'secondImage' => null,
    'href' => '#',
])

<a href="{{ $href }}"
   {{ $attributes->class('group block w-full rounded-xl bg-white px-7 pt-7 pb-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] transition-shadow duration-200 hover:shadow-[0_8px_28px_rgb(43_36_32/0.10)] focus-visible:shadow-[0_8px_28px_rgb(43_36_32/0.10)] outline-none') }}>
    <img src="{{ $image }}"
         alt="{{ $name }}"
         loading="lazy"
         class="block w-full aspect-[284/385] bg-cream-dark object-cover">

    <img src="{{ $secondImage ?? $image }}"
         alt=""
         loading="lazy"
         class="mt-9 block w-full aspect-[284/305] bg-cream-dark object-cover [mask-image:linear-gradient(to_bottom,black_70%,transparent_100%)]">

    <div class="mt-3 px-3 opacity-0 translate-y-1 transition duration-200 group-hover:opacity-100 group-hover:translate-y-0 group-focus-visible:opacity-100 group-focus-visible:translate-y-0 [@media(hover:none)]:opacity-100 [@media(hover:none)]:translate-y-0">
        <p class="text-[20px] font-extralight uppercase leading-tight text-black">{{ $name }}</p>
        <p class="mt-1 text-[20px] font-light leading-tight text-brand-text">IDR {{ number_format($price, 0, ',', '.') }}</p>
    </div>
</a>