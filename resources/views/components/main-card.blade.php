@props([
    'name',
    'price',
    'image',
    'secondImage' => null,
    'href' => '#',
])

<a href="{{ $href }}"
   {{ $attributes->class('group flex flex-col h-full w-full rounded-xl bg-white px-7 pt-7 pb-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] transition-shadow duration-200 hover:shadow-[0_8px_28px_rgb(43_36_32/0.10)] focus-visible:shadow-[0_8px_28px_rgb(43_36_32/0.10)] outline-none') }}>
    <div class="relative w-full aspect-[284/385] overflow-hidden bg-white">
        <img src="{{ $image }}"
             alt="{{ $name }}"
             loading="lazy"
             class="block h-full w-full object-contain transition-opacity duration-300 group-hover:opacity-0 group-focus-visible:opacity-0">

        <img src="{{ $secondImage ?? $image }}"
             alt=""
             loading="lazy"
             class="absolute inset-0 block h-full w-full object-contain opacity-0 transition-opacity duration-300 group-hover:opacity-100 group-focus-visible:opacity-100">
    </div>

    <div class="mt-auto pt-3 px-3 opacity-0 translate-y-1 transition duration-200 group-hover:opacity-100 group-hover:translate-y-0 group-focus-visible:opacity-100 group-focus-visible:translate-y-0 [@media(hover:none)]:opacity-100 [@media(hover:none)]:translate-y-0">
        <p class="text-sm md:text-base font-light uppercase leading-snug text-black truncate" title="{{ $name }}">{{ $name }}</p>
        <p class="mt-1 text-sm md:text-base font-light leading-tight text-brand-text">IDR {{ number_format($price, 0, ',', '.') }}</p>
    </div>
</a>