@props([
    'name',
    'price',
    'description' => '',
    'checkoutHref' => '#',
    'wishlisted' => false,
])

<div {{ $attributes->class('w-full') }}>
    <h1 class="font-heading text-[32px] font-medium leading-tight tracking-tight text-ink md:text-[40px]">{{ $name }}</h1>

    <p class="mt-3 font-heading text-[24px] font-medium leading-tight text-brand-text md:text-[28px]">IDR {{ number_format($price, 0, ',', '.') }}</p>

    <div class="mt-10 flex items-center gap-3">
        <a href="{{ $checkoutHref }}"
           class="inline-flex h-12 min-w-[190px] items-center justify-center rounded-lg bg-brand px-8 text-[18px] font-normal text-white transition-colors duration-200 hover:bg-brand-dark focus-visible:bg-brand-dark outline-none">
            Checkout Now
        </a>

        <button type="button" data-wishlist aria-label="Add to wishlist" aria-pressed="{{ $wishlisted ? 'true' : 'false' }}"
                class="group flex h-12 w-12 cursor-pointer items-center justify-center rounded-lg border border-sage bg-transparent text-sage transition-colors duration-200 hover:border-brand hover:text-brand outline-none focus-visible:border-brand focus-visible:text-brand">
            <x-icon name="heart" :size="26" data-heart class="{{ $wishlisted ? 'fill-current' : '' }}" />
        </button>
    </div>

    @if ($description)
        <h2 class="mt-10 font-heading text-[20px] font-medium leading-tight text-ink">Product Description</h2>
        <p class="mt-2 whitespace-pre-line text-base font-normal leading-snug text-black">{{ $description }}</p>
    @endif
</div>

@once
    <script>
        document.querySelectorAll('[data-wishlist]').forEach((button) => {
            button.addEventListener('click', () => {
                const heart = button.querySelector('[data-heart]');
                const active = button.getAttribute('aria-pressed') !== 'true';
                button.setAttribute('aria-pressed', active ? 'true' : 'false');
                button.setAttribute('aria-label', active ? 'Remove from wishlist' : 'Add to wishlist');
                heart.classList.toggle('fill-current', active);
                button.classList.toggle('text-brand', active);
                button.classList.toggle('border-brand', active);
            });
        });
    </script>
@endonce