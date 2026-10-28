@props([
    'data' => [12, 19, 15, 27, 22, 34, 30],
    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    'height' => 480,
    'title' => 'Orders',
])

@php
    $maxVal = max(array_merge($data, [1]));
    $viewWidth = 800;
    $viewHeight = 440;

    $paddingTop = 28;
    $paddingBottom = 42;
    $paddingLeft = 52;
    $paddingRight = 36;

    $plotWidth = $viewWidth - $paddingLeft - $paddingRight;
    $plotHeight = $viewHeight - $paddingTop - $paddingBottom;

    $count = count($data);
    $stepX = $count > 1 ? $plotWidth / ($count - 1) : $plotWidth;

    $points = [];
    foreach ($data as $i => $val) {
        $x = $paddingLeft + ($i * $stepX);
        $y = $paddingTop + $plotHeight - (($val / $maxVal) * $plotHeight);
        $points[] = [
            'x' => $x,
            'y' => $y,
            'val' => $val,
            'label' => $labels[$i] ?? ''
        ];
    }

    $polylineStr = implode(' ', array_map(fn($p) => "{$p['x']},{$p['y']}", $points));

    // Create smooth area string
    $areaStr = "{$points[0]['x']}," . ($paddingTop + $plotHeight) . " ";
    $areaStr .= $polylineStr;
    $areaStr .= " " . end($points)['x'] . "," . ($paddingTop + $plotHeight);

    $gridLinesCount = 4;
@endphp

<div class="relative flex h-full w-full flex-col justify-between p-2.5 sm:p-4 md:p-6" data-chart-root>
    <div class="relative flex-1 w-full min-h-0">
        <svg viewBox="0 0 {{ $viewWidth }} {{ $viewHeight }}" class="h-full w-full" preserveAspectRatio="none">
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

            {{-- Data points & interactive hover targets --}}
            @foreach ($points as $index => $pt)
                <g class="chart-point-group cursor-pointer group"
                   data-val="{{ $pt['val'] }}"
                   data-label="{{ $pt['label'] }}"
                   data-x="{{ ($pt['x'] / $viewWidth) * 100 }}"
                   data-y="{{ ($pt['y'] / $viewHeight) * 100 }}">

                    {{-- Invisible larger hit area --}}
                    <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="18" fill="transparent" />

                    {{-- Visible circle --}}
                    <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="5.5"
                            fill="#ffffff" stroke="#f47b2c" stroke-width="3.5"
                            class="transition-transform duration-200 group-hover:scale-150 group-hover:stroke-brand-dark"
                            style="transform-origin: {{ $pt['x'] }}px {{ $pt['y'] }}px; transform-box: view-box;" />

                    {{-- Axis text --}}
                    <text x="{{ $pt['x'] }}" y="{{ $paddingTop + $plotHeight + 20 }}"
                          text-anchor="middle" fill="#7a6e65" font-size="13" font-family="sans-serif"
                          class="transition-colors group-hover:fill-brand-text group-hover:font-semibold">
                        {{ $pt['label'] }}
                    </text>
                </g>
            @endforeach
        </svg>

        {{-- Floating HTML Tooltip --}}
        <div data-tooltip hidden
             class="pointer-events-none absolute z-30 whitespace-nowrap rounded-xl border border-sand bg-white/95 px-3 py-1.5 shadow-[0_4px_16px_rgb(43_36_32/0.14)] backdrop-blur-sm transition-[left,top] duration-75">
            <p class="text-xs font-semibold text-ink" data-tooltip-time></p>
            <p class="text-xs font-medium text-brand-text"><span data-tooltip-val></span> orders</p>
        </div>
    </div>
</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-chart-root]').forEach((root) => {
                const tooltip = root.querySelector('[data-tooltip]');
                const tooltipTime = root.querySelector('[data-tooltip-time]');
                const tooltipVal = root.querySelector('[data-tooltip-val]');

                root.querySelectorAll('.chart-point-group').forEach((group) => {
                    group.addEventListener('mouseenter', () => {
                        const val = group.dataset.val;
                        const label = group.dataset.label;
                        const x = parseFloat(group.dataset.x);
                        const y = parseFloat(group.dataset.y);

                        tooltipTime.textContent = label;
                        tooltipVal.textContent = val;

                        // Align tooltip horizontally to prevent clipping on left or right
                        let transformX = '-50%';
                        if (x < 12) {
                            transformX = '0%'; // Align left edge with point if near left border
                        } else if (x > 88) {
                            transformX = '-100%'; // Align right edge with point if near right border
                        }

                        // Position vertically
                        if (y <= 25) {
                            tooltip.style.left = `${x}%`;
                            tooltip.style.top = `calc(${y}% + 18px)`;
                            tooltip.style.transform = `translate(${transformX}, 0)`;
                        } else {
                            tooltip.style.left = `${x}%`;
                            tooltip.style.top = `calc(${y}% - 14px)`;
                            tooltip.style.transform = `translate(${transformX}, -100%)`;
                        }

                        tooltip.hidden = false;
                    });

                    group.addEventListener('mouseleave', () => {
                        tooltip.hidden = true;
                    });
                });
            });
        });
    </script>
@endonce
