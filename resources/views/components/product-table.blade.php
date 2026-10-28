@props([
    'items' => [],
    'min' => 240,
])

@if (count($items))
    <div {{ $attributes->class('grid gap-3') }}
        style="grid-template-columns: repeat(auto-fill, minmax(min(100%, {{ (int) $min }}px), 1fr));">
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