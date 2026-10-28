@props([
    'data' => [12, 19, 15, 27, 22, 34, 30],
    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    'height' => 480,
    'title' => 'Orders',
])

@php
    $maxVal = max(array_merge($data, [1]));
    $paddingTop = 40;
    $paddingBottom = 40;
    $paddingLeft = 50;
    $paddingRight = 30;
    $viewWidth = 800;
    $viewHeight = $height;

    $plotWidth = $viewWidth - $paddingLeft - $paddingRight;
    $plotHeight = $viewHeight - $paddingTop - $paddingBottom;

    $count = count($data);
    $stepX = $count > 1 ? $plotWidth / ($count - 1) : $plotWidth;

    $points = [];
    foreach ($data as $i => $val) {
        $x = $paddingLeft + ($i * $stepX);
        $y = $paddingTop + $plotHeight - (($val / $maxVal) * $plotHeight);
        $points[] = ['x' => $x, 'y' => $y, 'val' => $val, 'label' => $labels[$i] ?? ''];
    }

    $polylineStr = implode(' ', array_map(fn($p) => "{$p['x']},{$p['y']}", $points));

    // Create smooth area string
    $areaStr = "{$points[0]['x']}," . ($paddingTop + $plotHeight) . " ";
    $areaStr .= $polylineStr;
    $areaStr .= " " . end($points)['x'] . "," . ($paddingTop + $plotHeight);

    $gridLinesCount = 4;
@endphp

<div class="relative flex h-full w-full flex-col justify-between p-4 md:p-6">
    <div class="relative flex-1 w-full overflow-hidden">
        <svg viewBox="0 0 {{ $viewWidth }} {{ $viewHeight }}" class="h-full w-full overflow-visible" preserveAspectRatio="none">
            <defs>
                <linearGradient id="chartGradient-{{ md5($polylineStr) }}" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#f47b2c" stop-opacity="0.35" />
                    <stop offset="100%" stop-color="#f47b2c" stop-opacity="0.0" />
                </linearGradient>
            </defs>

            {{-- Grid horizontal lines and Y axis values --}}
            @for ($g = 0; $g <= $gridLinesCount; $g++)
                @php
                    $lineY = $paddingTop + ($plotHeight / $gridLinesCount) * $g;
                    $gridVal = round($maxVal - ($maxVal / $gridLinesCount) * $g);
                @endphp
                <line x1="{{ $paddingLeft }}" y1="{{ $lineY }}" x2="{{ $viewWidth - $paddingRight }}" y2="{{ $lineY }}"
                      stroke="#efe4d8" stroke-dasharray="4 4" stroke-width="1.2" />
                <text x="{{ $paddingLeft - 12 }}" y="{{ $lineY + 4 }}"
                      text-anchor="end" fill="#7a6e65" font-size="12" font-family="sans-serif">{{ $gridVal }}</text>
            @endfor

            {{-- Filled Area --}}
            <polygon points="{{ $areaStr }}" fill="url(#chartGradient-{{ md5($polylineStr) }})" />

            {{-- Line --}}
            <polyline fill="none" stroke="#f47b2c" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" points="{{ $polylineStr }}" />

            {{-- Data points & tooltips --}}
            @foreach ($points as $pt)
                <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="5" fill="#ffffff" stroke="#f47b2c" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150" />
                <text x="{{ $pt['x'] }}" y="{{ $paddingTop + $plotHeight + 24 }}"
                      text-anchor="middle" fill="#7a6e65" font-size="13" font-family="sans-serif">{{ $pt['label'] }}</text>
            @endforeach
        </svg>
    </div>
</div>

