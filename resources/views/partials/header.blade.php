<header class="site-header">
    <div class="site-header__inner">
        <a href="{{ route('home') }}" class="logo">mijusan</a>

        <form class="search-bar" action="{{ route('home') }}" method="GET" role="search">
            <input type="search" name="q" value="{{ request('q') }}"
                   placeholder="Searching for simplicity?" aria-label="Search">
            <button type="submit" aria-label="Search"><x-icon name="search" :size="20" /></button>
        </form>

        <div class="header-icons">
            <a href="{{ route('wishlist') }}" aria-label="Wishlist"><x-icon name="heart" :size="28" /></a>
            <button type="button" aria-label="Menu"><x-icon name="menu" :size="36" /></button>
        </div>
    </div>
</header>
