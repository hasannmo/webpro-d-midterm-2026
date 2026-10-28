@props([
    'wishlistHref' => '#',
    'orderHref' => '#',
    'logoutAction' => '#',
])

<div data-user-menu {{ $attributes->class('relative') }}>
    <button type="button" data-trigger aria-label="Open menu" aria-haspopup="menu" aria-expanded="false"
            class="flex cursor-pointer items-center justify-center text-white outline-none transition-opacity duration-200 hover:opacity-80 focus-visible:opacity-80">
        <x-icon name="menu" :size="28" />
    </button>

    <div data-menu role="menu" hidden
         class="absolute right-0 top-full z-50 mt-3 w-[220px] overflow-hidden rounded-xl border border-sand bg-white py-2 shadow-[0_8px_28px_rgb(43_36_32/0.10)]">
        <a href="{{ $wishlistHref }}" role="menuitem"
           class="block px-5 py-3 text-base font-normal text-black transition-colors duration-150 hover:bg-cream-dark focus-visible:bg-cream-dark outline-none">
            Wishlist
        </a>

        <a href="{{ $orderHref }}" role="menuitem"
           class="block px-5 py-3 text-base font-normal text-black transition-colors duration-150 hover:bg-cream-dark focus-visible:bg-cream-dark outline-none">
            My Order
        </a>

        <div class="my-1 border-t border-sand"></div>

        <form method="POST" action="{{ $logoutAction }}">
            @csrf
            <button type="submit" role="menuitem"
                    class="block w-full cursor-pointer px-5 py-3 text-left text-base font-normal text-danger transition-colors duration-150 hover:bg-cream-dark focus-visible:bg-cream-dark outline-none">
                Log out
            </button>
        </form>
    </div>
</div>

@once
    <script>
        document.querySelectorAll('[data-user-menu]').forEach((root) => {
            const trigger = root.querySelector('[data-trigger]');
            const menu = root.querySelector('[data-menu]');

            const close = () => {
                menu.hidden = true;
                trigger.setAttribute('aria-expanded', 'false');
            };

            const open = () => {
                menu.hidden = false;
                trigger.setAttribute('aria-expanded', 'true');
            };

            trigger.addEventListener('click', () => (menu.hidden ? open() : close()));

            document.addEventListener('click', (event) => {
                if (!root.contains(event.target)) close();
            });

            root.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    close();
                    trigger.focus();
                }
            });
        });
    </script>
@endonce