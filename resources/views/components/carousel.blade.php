<div class="carousel" data-carousel>
    <button type="button" class="carousel__btn carousel__btn--prev" data-carousel-prev aria-label="Sebelumnya">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>

    <div {{ $attributes->class(['carousel__track']) }} data-carousel-track>
        {{ $slot }}
    </div>

    <button type="button" class="carousel__btn carousel__btn--next" data-carousel-next aria-label="Berikutnya">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
</div>
