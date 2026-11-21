@props([
    'id' => null,
    'name',
    'price',
    'description' => '',
    'checkoutHref' => '#',
    'wishlisted' => false,
    'toggleUrl' => null,
])

<div {{ $attributes->class('w-full') }}>
    <h1 class="font-heading text-2xl sm:text-3xl md:text-[36px] font-medium leading-tight tracking-tight text-ink">{{ $name }}</h1>

    <p class="mt-2 sm:mt-3 font-heading text-xl sm:text-2xl md:text-[28px] font-medium leading-tight text-brand-text">IDR {{ number_format($price, 0, ',', '.') }}</p>

    <div class="mt-6 sm:mt-8 flex flex-wrap items-center gap-2.5 sm:gap-3">
        <a href="{{ $checkoutHref }}"
           class="inline-flex h-11 sm:h-12 flex-1 sm:flex-initial sm:min-w-[170px] items-center justify-center rounded-lg bg-brand px-6 text-sm sm:text-base font-medium text-white transition-colors duration-200 hover:bg-brand-dark focus-visible:bg-brand-dark outline-none">
            Checkout Now
        </a>

        @if ($id)
            @if (auth()->check())
                <form action="{{ route('cart.add') }}" method="POST" data-cart-form class="inline-flex">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                            data-cart-button
                            class="inline-flex h-11 sm:h-12 items-center justify-center gap-2 rounded-lg border border-brand bg-white px-5 text-sm sm:text-base font-medium text-brand transition-colors duration-200 hover:bg-brand hover:text-white outline-none">
                        <x-icon name="shopping-cart" :size="20" />
                        <span>Add to Cart</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex h-11 sm:h-12 items-center justify-center gap-2 rounded-lg border border-brand bg-white px-5 text-sm sm:text-base font-medium text-brand transition-colors duration-200 hover:bg-brand hover:text-white outline-none">
                    <x-icon name="shopping-cart" :size="20" />
                    <span>Add to Cart</span>
                </a>
            @endif
        @endif

        @if (auth()->check())
            <button type="button"
                    data-wishlist
                    data-toggle-url="{{ $toggleUrl }}"
                    aria-label="{{ $wishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
                    aria-pressed="{{ $wishlisted ? 'true' : 'false' }}"
                    class="group flex h-11 w-11 sm:h-12 sm:w-12 shrink-0 cursor-pointer items-center justify-center rounded-lg border bg-transparent transition-colors duration-200 outline-none {{ $wishlisted ? 'border-brand text-brand' : 'border-sage text-sage hover:border-brand hover:text-brand' }}">
                <x-icon name="heart" :size="24" data-heart class="{{ $wishlisted ? 'fill-current' : '' }}" />
            </button>
        @else
            <a href="{{ route('login') }}"
               aria-label="Add to wishlist"
               class="group flex h-11 w-11 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-lg border border-sage bg-transparent text-sage transition-colors duration-200 hover:border-brand hover:text-brand outline-none">
                <x-icon name="heart" :size="24" />
            </a>
        @endif
    </div>

    <div id="cart-notification" class="hidden mt-3 rounded-lg bg-green-50 border border-green-200 px-4 py-2.5 text-xs sm:text-sm font-medium text-green-800 transition-all duration-300">
        Item added to your cart! <a href="{{ route('cart.index') }}" class="underline font-semibold ml-1">View Cart</a>
    </div>

    @if ($description)
        <h2 class="mt-6 sm:mt-8 font-heading text-lg sm:text-xl font-medium leading-tight text-ink">Product Description</h2>
        <p class="mt-1.5 sm:mt-2 whitespace-pre-line text-xs sm:text-sm md:text-base font-normal leading-relaxed text-black/80">{{ $description }}</p>
    @endif
</div>

@once
    <script>
        document.querySelectorAll('[data-cart-form]').forEach((form) => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const button = form.querySelector('[data-cart-button]');
                const origHtml = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<span>Adding...</span>';

                try {
                    const formData = new FormData(form);
                    const res = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (res.ok) {
                        const data = await res.json();
                        // Update cart badge in header
                        const cartCountBadges = document.querySelectorAll('#cart-count-badge');
                        cartCountBadges.forEach(badge => {
                            badge.textContent = data.cart_count;
                            badge.classList.remove('hidden');
                        });

                        const notif = document.getElementById('cart-notification');
                        if (notif) {
                            notif.classList.remove('hidden');
                            setTimeout(() => {
                                notif.classList.add('hidden');
                            }, 4000);
                        }
                    } else {
                        form.submit();
                    }
                } catch (err) {
                    form.submit();
                } finally {
                    button.disabled = false;
                    button.innerHTML = origHtml;
                }
            });
        });

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