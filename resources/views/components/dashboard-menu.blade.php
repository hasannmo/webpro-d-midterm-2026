@props([
    'active' => 'dashboard',
    'items' => null,
])

@php
    $isCreator = auth()->check() && auth()->user()->isCreator();

    $defaultItems = [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'href' => route('admin.dashboard')],
        ['key' => 'order', 'label' => 'Order', 'icon' => 'shopping-bag', 'href' => route('admin.order')],
        ['key' => 'product', 'label' => 'Product', 'icon' => 'boxes', 'href' => route('admin.product')],
        ['key' => 'account', 'label' => 'Account', 'icon' => 'person-standing', 'href' => route('admin.account')],
    ];

    if ($isCreator) {
        $defaultItems[] = [
            'key' => 'rickroll',
            'label' => 'Rickroll',
            'icon' => 'youtube',
            'href' => route('admin.rickroll'),
        ];
    }

    $items = $items ?? $defaultItems;
@endphp

<div data-admin-menu-root class="w-full md:w-[240px] md:sticky md:top-20 md:z-10 md:self-start">
    {{-- Mobile Hamburger Trigger & Active Tab Bar --}}
    <div class="flex items-center justify-between rounded-xl bg-brand-soft p-3 md:hidden">
        <div class="flex items-center gap-2.5">
            <x-icon name="layout-dashboard" :size="20" class="text-brand-text" />
            <span class="text-sm font-semibold capitalize text-ink">
                Admin : {{ ucfirst($active) }}
            </span>
        </div>

        <button type="button" data-mobile-menu-btn aria-expanded="false" aria-label="Toggle admin navigation"
                class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/80 text-ink shadow-xs transition hover:bg-white active:scale-95">
            <svg data-icon-bars xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
            </svg>
            <svg data-icon-close class="hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
            </svg>
        </button>
    </div>

    {{-- Menu List (Collapsible on Mobile, Static on Desktop) --}}
    <nav aria-label="Dashboard menu"
         data-mobile-menu
         class="hidden mt-2 rounded-xl bg-brand-soft p-2.5 md:mt-0 md:block md:rounded-2xl md:p-5 md:py-8 shadow-xs md:shadow-none">
        <ul class="flex flex-col gap-1.5 md:gap-2.5">
            @foreach ($items as $item)
                @php($isActive = $item['key'] === $active)
                <li>
                    <a href="{{ $item['href'] }}"
                       @if ($isActive) aria-current="page" @endif
                       class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm md:text-base leading-tight text-black transition-colors duration-200 hover:bg-white/60 focus-visible:bg-white/60 outline-none {{ $isActive ? 'bg-white font-semibold text-brand-text shadow-xs' : 'font-normal' }}">
                        <x-icon :name="$item['icon']" :size="20" class="md:h-6 md:w-6" />
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-admin-menu-root]').forEach((root) => {
                const btn = root.querySelector('[data-mobile-menu-btn]');
                const menu = root.querySelector('[data-mobile-menu]');
                const iconBars = root.querySelector('[data-icon-bars]');
                const iconClose = root.querySelector('[data-icon-close]');

                if (!btn || !menu) return;

                btn.addEventListener('click', () => {
                    const isClosed = menu.classList.contains('hidden');
                    menu.classList.toggle('hidden', !isClosed);
                    iconBars.classList.toggle('hidden', isClosed);
                    iconClose.classList.toggle('hidden', !isClosed);
                    btn.setAttribute('aria-expanded', isClosed ? 'true' : 'false');
                });
            });
        });
    </script>
@endonce
