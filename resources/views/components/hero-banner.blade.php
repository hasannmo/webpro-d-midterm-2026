@props([
    'slides' => [],
    'interval' => 5000,
])

@if (count($slides))
    <section data-hero-banner data-interval="{{ $interval }}" aria-roledescription="carousel"
        {{ $attributes->class('relative w-full overflow-hidden bg-cream-dark select-none touch-pan-y') }}>
        <div data-track
            class="flex overflow-x-auto snap-x snap-mandatory [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden transition-transform duration-500 ease-out cursor-grab active:cursor-grabbing">
            @foreach ($slides as $slide)
                <div class="w-full shrink-0 snap-start" aria-roledescription="slide">
                    @if (!empty($slide['href']))
                        <a href="{{ $slide['href'] }}" class="block draggable-false">
                            <img src="{{ $slide['image'] }}" alt="{{ $slide['alt'] ?? '' }}"
                                class="pointer-events-none block h-[260px] w-full object-cover object-center sm:h-[380px] md:h-[540px] lg:h-[700px]"
                                @if (!$loop->first) loading="lazy" @endif>
                        </a>
                    @else
                        <img src="{{ $slide['image'] }}" alt="{{ $slide['alt'] ?? '' }}"
                            class="pointer-events-none block h-[260px] w-full object-cover object-center sm:h-[380px] md:h-[540px] lg:h-[700px]"
                            @if (!$loop->first) loading="lazy" @endif>
                    @endif
                </div>
            @endforeach
        </div>

        @if (count($slides) > 1)
            <div class="absolute bottom-3 md:bottom-5 left-1/2 flex -translate-x-1/2 items-center gap-2 z-10">
                @foreach ($slides as $slide)
                    <button type="button" data-dot aria-label="Go to slide {{ $loop->iteration }}"
                        class="h-2 w-2 md:h-2.5 md:w-2.5 cursor-pointer rounded-full transition-all duration-300 {{ $loop->first ? 'bg-brand w-5 md:w-6' : 'bg-white/60' }}"></button>
                @endforeach
            </div>
        @endif
    </section>

    @once
        <script>
            document.querySelectorAll('[data-hero-banner]').forEach((banner) => {
                const track = banner.querySelector('[data-track]');
                const dots = banner.querySelectorAll('[data-dot]');
                const total = track.children.length;
                const interval = parseInt(banner.dataset.interval, 10) || 5000;
                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                let index = 0;
                let timer = null;

                const updateDots = (activeIdx) => {
                    dots.forEach((dot, i) => {
                        const active = i === activeIdx;
                        dot.classList.toggle('bg-brand', active);
                        dot.classList.toggle('w-5', active);
                        dot.classList.toggle('md:w-6', active);
                        dot.classList.toggle('bg-white/60', !active);
                        dot.classList.toggle('w-2', !active);
                        dot.classList.toggle('md:w-2.5', !active);
                        dot.setAttribute('aria-current', active ? 'true' : 'false');
                    });
                };

                const scrollToSlide = (next) => {
                    index = (next + total) % total;
                    const targetLeft = track.clientWidth * index;
                    track.scrollTo({ left: targetLeft, behavior: 'smooth' });
                    updateDots(index);
                };

                const start = () => {
                    if (total < 2 || reduceMotion || timer) return;
                    timer = setInterval(() => {
                        scrollToSlide(index + 1);
                    }, interval);
                };

                const stop = () => {
                    if (timer) {
                        clearInterval(timer);
                        timer = null;
                    }
                };

                // Track manual user scrolling / swipe
                let isScrolling = null;
                track.addEventListener('scroll', () => {
                    stop();
                    clearTimeout(isScrolling);
                    isScrolling = setTimeout(() => {
                        const newIdx = Math.round(track.scrollLeft / track.clientWidth);
                        if (!isNaN(newIdx) && newIdx >= 0 && newIdx < total) {
                            index = newIdx;
                            updateDots(index);
                        }
                        start();
                    }, 120);
                }, { passive: true });

                // Click dot navigation
                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        stop();
                        scrollToSlide(i);
                        start();
                    });
                });

                banner.addEventListener('mouseenter', stop);
                banner.addEventListener('mouseleave', start);
                banner.addEventListener('touchstart', stop, { passive: true });
                banner.addEventListener('touchend', start, { passive: true });
                document.addEventListener('visibilitychange', () => (document.hidden ? stop() : start()));

                updateDots(0);
                start();
            });
        </script>
    @endonce
@endif