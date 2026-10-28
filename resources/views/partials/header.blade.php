@php
    $isAdmin = request()->is('admin*');
@endphp

<header class="site-header">
    <div class="site-header__inner">
        <a href="{{ route('home') }}" class="logo">mijusan</a>

        @if (!$isAdmin)
            <form class="search-bar" action="{{ route('search') }}" method="GET" role="search">
                <input type="search" name="q" value="{{ request('q') }}"
                       placeholder="Searching for simplicity?" aria-label="Search">
                <button type="submit" aria-label="Search"><x-icon name="search" :size="20" /></button>
            </form>

            <div class="header-icons">
                @if (auth()->check())
                    <span class="hidden sm:inline-block text-sm font-medium text-white/95">
                        Hi, {{ auth()->user()->name }}!
                    </span>
                @endif
                <a href="{{ route('wishlist') }}" aria-label="Wishlist"><x-icon name="heart" :size="28" /></a>
                <x-user-menu
                    :wishlist-href="route('wishlist')"
                    :order-href="auth()->check() ? (auth()->user()->isAdmin() ? route('admin.order') : route('myorder')) : route('login')"
                    :logout-action="route('logout')"
                    :login-href="route('login')" />
            </div>
        @else
            <div class="header-icons">
                <a href="{{ route('home') }}" class="text-sm font-light text-white/90 hover:text-white hover:underline">View Store</a>
            </div>
        @endif
    </div>
</header>

