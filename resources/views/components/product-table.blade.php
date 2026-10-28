@props([
    'items' => [],
    'min' => 240,
])

@if (count($items))
    <div {{ $attributes->class('grid grid-cols-2 gap-2.5 sm:gap-3.5 md:gap-4 md:grid-cols-[repeat(auto-fill,minmax(min(100%,240px),1fr))]') }}>
        @foreach ($items as $item)
            <x-main-card
                :name="$item['name']"
                :price="$item['price']"
                :image="$item['image']"
                :second-image="$item['secondImage'] ?? null"
                :href="$item['href'] ?? '#'" />
        @endforeach
    </div>
@endif