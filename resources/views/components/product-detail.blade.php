@props([
    'name',
    'price',
    'description' => '',
    'checkoutHref' => '#',
    'wishlisted' => false,
    'toggleUrl' => null,
])

<div {{ $attributes->class('w-full') }}>
    <h1 class="font-heading text-[32px] font-medium leading-tight tracking-tight text-ink md:text-[40px]">{{ $name }}</h1>

    <p class="mt-3 font-heading text-[24px] font-medium leading-tight text-brand-text md:text-[28px]">IDR {{ number_format($price, 0, ',', '.') }}</p>

    <div class="mt-10 flex items-center gap-3">
        <a href="{{ $checkoutHref }}"
           class="inline-flex h-12 min-w-[190px] items-center justify-center rounded-lg bg-brand px-8 text-[18px] font-normal text-white transition-colors duration-200 hover:bg-brand-dark focus-visible:bg-brand-dark outline-none">
            Checkout Now
        </a>

        @if (auth()->check())
            <button type="button"
                    data-wishlist
                    data-toggle-url="{{ $toggleUrl }}"
                    aria-label="{{ $wishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
                    aria-pressed="{{ $wishlisted ? 'true' : 'false' }}"
                    class="group flex h-12 w-12 cursor-pointer items-center justify-center rounded-lg border bg-transparent transition-colors duration-200 outline-none {{ $wishlisted ? 'border-brand text-brand' : 'border-sage text-sage hover:border-brand hover:text-brand' }}">
                <x-icon name="heart" :size="26" data-heart class="{{ $wishlisted ? 'fill-current' : '' }}" />
            </button>
        @else
            <a href="{{ route('login') }}"
               aria-label="Add to wishlist"
               class="group flex h-12 w-12 items-center justify-center rounded-lg border border-sage bg-transparent text-sage transition-colors duration-200 hover:border-brand hover:text-brand outline-none">
                <x-icon name="heart" :size="26" />
            </a>
        @endif
    </div>

    @if ($description)
        <h2 class="mt-10 font-heading text-[20px] font-medium leading-tight text-ink">Product Description</h2>
        <p class="mt-2 whitespace-pre-line text-base font-normal leading-snug text-black">{{ $description }}</p>
    @endif
</div>

@once
    <script>
        document.querySelectorAll('[data-wishlist]').forEach((button) => {
            button.addEventListener('click', async () => {
                const heart = button.querySelector('[data-heart]');
                const toggleUrl = button.dataset.toggleUrl;

                if (toggleUrl) {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const res = await fetch(toggleUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token || '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        });
                        const data = await res.json();
                        const active = data.status === 'added';

                        button.setAttribute('aria-pressed', active ? 'true' : 'false');
                        button.setAttribute('aria-label', active ? 'Remove from wishlist' : 'Add to wishlist');
                        heart.classList.toggle('fill-current', active);
                        button.classList.toggle('text-brand', active);
                        button.classList.toggle('border-brand', active);
                        button.classList.toggle('text-sage', !active);
                        button.classList.toggle('border-sage', !active);
                    } catch (e) {
                        console.error('Wishlist toggle error', e);
                    }
                }
            });
        });
    </script>
@endonce