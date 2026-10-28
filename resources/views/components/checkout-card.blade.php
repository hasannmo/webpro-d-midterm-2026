@props([
    'name',
    'price',
    'image',
    'confirmed' => false,
    'confirmAction' => '#',
    'cancelHref' => '#',
    'supportEmail' => 'customerservice@mijusan.com',
])

<div {{ $attributes->class('grid w-full gap-6 rounded-2xl border border-sand bg-white p-4 sm:p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:grid-cols-2 md:gap-10 md:p-10') }}>
    <div class="flex items-center justify-center p-2">
        <img src="{{ $image }}" alt="{{ $name }}" class="block max-h-[260px] sm:max-h-[340px] md:max-h-[420px] w-full object-contain">
    </div>

    <div class="flex flex-col">
        <h1 class="border-b border-ink pb-1 font-heading text-2xl sm:text-3xl font-medium leading-tight tracking-tight text-ink md:text-[36px]">Finish Your Checkout</h1>

        <h2 class="mt-3 sm:mt-4 font-heading text-lg sm:text-xl font-medium leading-tight text-ink md:text-[26px]">{{ $name }}</h2>
        <p class="mt-1 sm:mt-2 font-heading text-base sm:text-lg font-medium leading-tight text-brand-text">IDR {{ number_format($price, 0, ',', '.') }}</p>

        @if ($confirmed)
            <div aria-disabled="true" role="status"
                 class="mt-6 sm:mt-8 flex h-11 sm:h-12 w-full cursor-not-allowed select-none items-center justify-center rounded-lg bg-sand text-sm sm:text-base font-normal text-muted">
                Checkout Confirmed
            </div>

            <p class="mt-4 sm:mt-6 text-xs sm:text-sm md:text-base font-normal leading-snug text-black">Your order will be recorded and processed shortly.</p>
        @else
            <form method="POST" action="{{ $confirmAction }}" class="mt-6 sm:mt-8">
                @csrf
                <button type="submit"
                        class="flex h-11 sm:h-12 w-full cursor-pointer items-center justify-center rounded-lg bg-brand text-sm sm:text-base font-medium text-white transition-colors duration-200 hover:bg-brand-dark focus-visible:bg-brand-dark outline-none">
                    Confirm Checkout
                </button>
            </form>

            <a href="{{ $cancelHref }}"
               class="mt-2.5 sm:mt-3 flex h-11 sm:h-12 w-full items-center justify-center rounded-lg bg-danger text-sm sm:text-base font-medium text-white transition-opacity duration-200 hover:opacity-90 focus-visible:opacity-90 outline-none">
                Cancel Checkout
            </a>
        @endif

        <p class="{{ $confirmed ? 'mt-6' : 'mt-6 sm:mt-8' }} text-xs sm:text-sm font-normal leading-snug text-black">
            Having any issues?<br>
            contact us at <a href="mailto:{{ $supportEmail }}" class="text-brand-text hover:underline">{{ $supportEmail }}</a>
        </p>
    </div>
</div>