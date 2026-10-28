@props([
    'active' => 'dashboard',
    'items' => null,
])

@php
    $items = $items ?? [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'href' => route('admin.dashboard')],
        ['key' => 'order', 'label' => 'Order', 'icon' => 'shopping-bag', 'href' => route('admin.order')],
        ['key' => 'product', 'label' => 'Product', 'icon' => 'boxes', 'href' => route('admin.product')],
        ['key' => 'account', 'label' => 'Account', 'icon' => 'person-standing', 'href' => route('admin.account')],
    ];
@endphp

<nav aria-label="Dashboard menu" {{ $attributes->class('sticky top-20 z-10 w-full bg-brand-soft px-6 py-8 md:w-[260px] md:self-start') }}>
    <ul class="flex flex-row gap-2 overflow-x-auto md:flex-col md:gap-3 md:overflow-visible [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach ($items as $item)
            @php($isActive = $item['key'] === $active)
            <li class="shrink-0">
                <a href="{{ $item['href'] }}"
                   @if ($isActive) aria-current="page" @endif
                   class="flex items-center gap-4 rounded-lg px-4 py-2.5 text-[18px] leading-tight text-black transition-colors duration-200 hover:bg-white/60 focus-visible:bg-white/60 outline-none {{ $isActive ? 'bg-white/60 font-medium' : 'font-normal' }}">
                    <x-icon :name="$item['icon']" :size="28" />
                    <span>{{ $item['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</nav>