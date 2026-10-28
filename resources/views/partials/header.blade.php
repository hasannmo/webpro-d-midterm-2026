@php
    $isAdmin = request()->is('admin*');
@endphp

<header class="site-header" data-site-header>
    <div class="site-header__inner">
        <a href="{{ route('home') }}" class="logo transition-colors duration-300">mijusan</a>

        @if (!$isAdmin)
            <form class="search-bar" action="{{ route('search') }}" method="GET" role="search">
                <input type="search" name="q" value="{{ request('q') }}"
                       placeholder="Searching for simplicity?" aria-label="Search">
                <button type="submit" aria-label="Search"><x-icon name="search" :size="20" /></button>
            </form>

            <div class="header-icons">
                <div class="header-glass-pill flex items-center gap-3 px-3.5 py-1.5 rounded-full transition-all duration-300">
                    @if (auth()->check())
                        <span class="hidden sm:inline-block text-sm font-medium text-white/95">
                            Hi, {{ auth()->user()->name }}!
                        </span>
                    @endif
                    <a href="{{ route('wishlist') }}" aria-label="Wishlist" class="flex items-center text-white transition-opacity hover:opacity-80">
                        <x-icon name="heart" :size="26" />
                    </a>
                    <x-user-menu
                        :wishlist-href="route('wishlist')"
                        :order-href="auth()->check() ? (auth()->user()->isAdmin() ? route('admin.order') : route('myorder')) : route('login')"
                        :logout-action="route('logout')"
                        :login-href="route('login')" />
                </div>
            </div>
        @else
            <div class="header-icons">
                <div class="header-glass-pill px-3.5 py-1.5 rounded-full transition-all duration-300">
                    <a href="{{ route('home') }}" class="text-sm font-light text-white hover:underline">View Store</a>
                </div>
            </div>
        @endif
    </div>
</header>

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.querySelector('[data-site-header]');
            if (!header) return;

            const onScroll = () => {
                if (window.scrollY > 20) {
                    header.classList.add('site-header--scrolled');
                } else {
                    header.classList.remove('site-header--scrolled');
                }
            };

            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        });
    </script>
@endonce

