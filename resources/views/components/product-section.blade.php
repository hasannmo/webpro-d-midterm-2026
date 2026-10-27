@props(['title', 'products', 'carousel' => false])

<section class="section">
    <div class="section__inner">
        <h2 class="section-title">{{ $title }}</h2>

        @if ($carousel)
            <x-carousel class="carousel__track--products">
                @foreach ($products as $image)
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/'.$image) }}" alt="{{ $title }} item {{ $loop->iteration }}" loading="lazy">
                    </a>
                @endforeach
            </x-carousel>
        @else
            <div class="product-grid">
                @foreach ($products as $image)
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/'.$image) }}" alt="{{ $title }} item {{ $loop->iteration }}" loading="lazy">
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
