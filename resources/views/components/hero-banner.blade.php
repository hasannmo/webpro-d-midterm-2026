@props([
    'slides' => [],
    'interval' => 5000,
])

@if (count($slides))
    <section data-hero-banner data-interval="{{ $interval }}" aria-roledescription="carousel"
        {{ $attributes->class('relative w-full overflow-hidden bg-cream-dark') }}>
        <div data-track class="flex transition-transform duration-700 ease-in-out">
            @foreach ($slides as $slide)
                <div class="w-full shrink-0" aria-roledescription="slide">
                    @if (!empty($slide['href']))
                        <a href="{{ $slide['href'] }}" class="block">
                            <img src="{{ $slide['image'] }}" alt="{{ $slide['alt'] ?? '' }}"
                                class="block h-[400px] w-full object-cover object-center md:h-[730px]"
                                @if (!$loop->first) loading="lazy" @endif>
                        </a>
                    @else
                        <img src="{{ $slide['image'] }}" alt="{{ $slide['alt'] ?? '' }}"
                            class="block h-[400px] w-full object-cover object-center md:h-[730px]"
                            @if (!$loop->first) loading="lazy" @endif>
                    @endif
                </div>
            @endforeach
        </div>

        @if (count($slides) > 1)
            <div class="absolute bottom-5 left-1/2 flex -translate-x-1/2 items-center gap-2">
                @foreach ($slides as $slide)
                    <button type="button" data-dot aria-label="Go to slide {{ $loop->iteration }}"
                        class="h-2.5 w-2.5 cursor-pointer rounded-full transition-colors duration-300 {{ $loop->first ? 'bg-brand' : 'bg-white/60' }}"></button>
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

                const go = (next) => {
                    index = (next + total) % total;
                    track.style.transform = `translateX(-${index * 100}%)`;
                    dots.forEach((dot, i) => {
                        const active = i === index;
                        dot.classList.toggle('bg-brand', active);
                        dot.classList.toggle('bg-white/60', !active);
                        dot.setAttribute('aria-current', active ? 'true' : 'false');
                    });
                };

                const start = () => {
                    if (total < 2 || reduceMotion || timer) return;
                    timer = setInterval(() => go(index + 1), interval);
                };

                const stop = () => {
                    clearInterval(timer);
                    timer = null;
                };

                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        go(i);
                        stop();
                        start();
                    });
                });

                banner.addEventListener('mouseenter', stop);
                banner.addEventListener('mouseleave', start);
                document.addEventListener('visibilitychange', () => (document.hidden ? stop() : start()));

                go(0);
                start();
            });
        </script>
    @endonce
@endif