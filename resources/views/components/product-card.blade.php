@props([
    'name',
    'price',
    'image',
    'secondImage' => null,
    'href' => '#',
])

<a href="{{ $href }}"
   {{ $attributes->class('group relative flex flex-col w-full rounded-xl bg-white p-3 sm:p-5 md:p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] transition-shadow duration-200 hover:shadow-[0_8px_28px_rgb(43_36_32/0.10)] focus-visible:shadow-[0_8px_28px_rgb(43_36_32/0.10)] outline-none overflow-hidden') }}>
    <div class="relative w-full aspect-[3/4] bg-white flex items-center justify-center">
        <img src="{{ $image }}"
             alt="{{ $name }}"
             loading="lazy"
             class="block h-full w-full object-contain">

        @if ($secondImage && $secondImage !== $image)
            <img src="{{ $secondImage }}"
                 alt=""
                 loading="lazy"
                 class="absolute inset-0 block h-full w-full object-contain opacity-0 transition-opacity duration-300 group-hover:opacity-100 group-focus-visible:opacity-100">
        @endif

        {{-- Desktop Hover Overlay --}}
        <div class="hidden md:block absolute inset-x-0 bottom-0 bg-white/95 px-3 py-2.5 backdrop-blur-[2px] opacity-0 translate-y-1 transition duration-200 group-hover:opacity-100 group-hover:translate-y-0 group-focus-visible:opacity-100 group-focus-visible:translate-y-0">
            <p class="text-sm md:text-base font-light uppercase leading-snug text-black truncate" title="{{ $name }}">{{ $name }}</p>
            <p class="mt-0.5 text-sm md:text-base font-light leading-tight text-brand-text">IDR {{ number_format($price, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Mobile Info Below Image (Not Overlaying) --}}
    <div class="md:hidden mt-2.5 pt-1.5 border-t border-sand/40 flex flex-col">
        <p class="text-[11px] sm:text-xs font-light uppercase leading-tight text-ink truncate" title="{{ $name }}">{{ $name }}</p>
        <p class="mt-0.5 text-xs sm:text-sm font-medium leading-tight text-brand-text">IDR {{ number_format($price, 0, ',', '.') }}</p>
    </div>
</a>