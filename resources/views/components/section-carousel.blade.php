@props([
    'items' => [],
])

@if (count($items))
    <div data-section-carousel {{ $attributes->class('relative') }}>
        <div data-track
            class="flex items-stretch gap-3 overflow-x-auto scroll-smooth snap-x snap-proximity py-4 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($items as $item)
                <div class="flex w-[260px] shrink-0 snap-start md:w-[300px]">
                    <x-main-card
                        :name="$item['name']"
                        :price="$item['price']"
                        :image="$item['image']"
                        :second-image="$item['secondImage'] ?? null"
                        :href="$item['href'] ?? '#'" />
                </div>
            @endforeach
        </div>

        <button type="button" data-prev aria-label="Previous"
            class="absolute left-3 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white text-ink shadow-[0_2px_12px_rgb(43_36_32/0.18)] transition duration-200 hover:bg-brand hover:text-white md:flex">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <path d="m15 18-6-6 6-6" />
            </svg>
        </button>

        <button type="button" data-next aria-label="Next"
            class="absolute right-3 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white text-ink shadow-[0_2px_12px_rgb(43_36_32/0.18)] transition duration-200 hover:bg-brand hover:text-white md:flex">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </button>
    </div>

    @once
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-section-carousel]').forEach((carousel) => {
                    const track = carousel.querySelector('[data-track]');
                    const prev = carousel.querySelector('[data-prev]');
                    const next = carousel.querySelector('[data-next]');
                    const hiddenClasses = ['opacity-0', 'pointer-events-none'];

                    const toggle = (button, visible) => {
                        hiddenClasses.forEach((c) => button.classList.toggle(c, !visible));
                    };

                    const update = () => {
                        const max = track.scrollWidth - track.clientWidth - 2;
                        toggle(prev, track.scrollLeft > 4);
                        toggle(next, track.scrollLeft < max);
                    };

                    const step = () => Math.max(280, track.clientWidth * 0.75);

                    prev.addEventListener('click', () => track.scrollBy({ left: -step(), behavior: 'smooth' }));
                    next.addEventListener('click', () => track.scrollBy({ left: step(), behavior: 'smooth' }));
                    track.addEventListener('scroll', update, { passive: true });
                    window.addEventListener('resize', update, { passive: true });

                    // Initial update and delayed check after images render
                    update();
                    setTimeout(update, 200);
                    setTimeout(update, 800);
                });
            });
        </script>
    @endonce
@endif