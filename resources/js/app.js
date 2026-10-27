// Carousel: tombol prev/next menggeser track; swipe/trackpad tetap bisa.
document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('[data-carousel-track]');
    const prev = carousel.querySelector('[data-carousel-prev]');
    const next = carousel.querySelector('[data-carousel-next]');

    const update = () => {
        const max = track.scrollWidth - track.clientWidth - 1;
        prev.hidden = track.scrollLeft <= 0;
        next.hidden = track.scrollLeft >= max;
    };

    const scrollByPage = (dir) =>
        track.scrollBy({ left: dir * track.clientWidth * 0.8, behavior: 'smooth' });

    prev.addEventListener('click', () => scrollByPage(-1));
    next.addEventListener('click', () => scrollByPage(1));
    track.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
    update();
});
