@props([
    'name',
    'price',
    'image',
    'confirmed' => false,
    'confirmAction' => '#',
    'cancelHref' => '#',
    'supportEmail' => 'customerservice@mijusan.com',
])

<div {{ $attributes->class('grid w-full gap-8 rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:grid-cols-2 md:gap-12 md:p-10') }}>
    <div class="flex items-center justify-center">
        <img src="{{ $image }}" alt="{{ $name }}" class="block max-h-[420px] w-full object-contain">
    </div>

    <div class="flex flex-col">
        <h1 class="border-b border-ink pb-1 font-heading text-[32px] font-medium leading-tight tracking-tight text-ink md:text-[36px]">Finish Your Checkout</h1>

        <h2 class="mt-4 font-heading text-[26px] font-medium leading-tight text-ink md:text-[28px]">{{ $name }}</h2>
        <p class="mt-2 font-heading text-[18px] font-medium leading-tight text-brand-text">IDR {{ number_format($price, 0, ',', '.') }}</p>

        @if ($confirmed)
            <div aria-disabled="true" role="status"
                 class="mt-10 flex h-12 w-full cursor-not-allowed select-none items-center justify-center rounded-lg bg-sand text-[18px] font-normal text-muted">
                Checkout Confirmed
            </div>

            <p class="mt-8 text-base font-normal leading-snug text-black">Your order will be recorded and processed shortly.</p>
        @else
            <form method="POST" action="{{ $confirmAction }}" class="mt-10">
                @csrf
                <button type="submit"
                        class="flex h-12 w-full cursor-pointer items-center justify-center rounded-lg bg-brand text-[18px] font-normal text-white transition-colors duration-200 hover:bg-brand-dark focus-visible:bg-brand-dark outline-none">
                    Confirm Checkout
                </button>
            </form>

            <a href="{{ $cancelHref }}"
               class="mt-3 flex h-12 w-full items-center justify-center rounded-lg bg-danger text-[18px] font-normal text-white transition-opacity duration-200 hover:opacity-90 focus-visible:opacity-90 outline-none">
                Cancel Checkout
            </a>
        @endif

        <p class="{{ $confirmed ? 'mt-8' : 'mt-10' }} text-base font-normal leading-snug text-black">
            Having any issues?<br>
            contact us at <a href="mailto:{{ $supportEmail }}" class="text-brand-text hover:underline">{{ $supportEmail }}</a>
        </p>
    </div>
</div>