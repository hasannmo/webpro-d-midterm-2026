@props([
    'selected' => '7d',
    'navigate' => false,
    'param' => 'range',
    'options' => [
        '7d' => 'Last 7 Days',
        '1m' => 'Last 1 Month',
        '3m' => 'Last 3 Months',
        '6m' => 'Last 6 Months',
        '1y' => 'Last 1 Year',
    ],
])

<div data-range-select data-navigate="{{ $navigate ? 'true' : 'false' }}" data-param="{{ $param }}"
     {{ $attributes->class('relative inline-block') }}>
    <button type="button" data-trigger aria-haspopup="listbox" aria-expanded="false"
            class="group flex cursor-pointer items-center gap-2 text-base font-normal text-black outline-none focus-visible:text-brand-text">
        <span>Order Over Time : <span data-label>{{ $options[$selected] ?? reset($options) }}</span></span>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
             class="transition-transform duration-200 group-aria-expanded:rotate-180" aria-hidden="true">
            <path d="m6 9 6 6 6-6" />
        </svg>
    </button>

    <div data-menu role="listbox" hidden
         class="absolute left-0 top-full z-20 mt-2 min-w-[220px] rounded-xl border border-sand bg-white py-1 shadow-[0_8px_28px_rgb(43_36_32/0.10)]">
        @foreach ($options as $value => $label)
            <button type="button" role="option" data-value="{{ $value }}"
                    aria-selected="{{ $value === $selected ? 'true' : 'false' }}"
                    class="block w-full cursor-pointer px-4 py-2 text-left text-base text-black transition-colors duration-150 hover:bg-cream-dark focus-visible:bg-cream-dark outline-none {{ $value === $selected ? 'bg-cream-dark font-medium' : 'font-normal' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>
</div>

@once
    <script>
        document.querySelectorAll('[data-range-select]').forEach((root) => {
            const trigger = root.querySelector('[data-trigger]');
            const menu = root.querySelector('[data-menu]');
            const label = root.querySelector('[data-label]');
            const options = root.querySelectorAll('[data-value]');
            const navigate = root.dataset.navigate === 'true';
            const param = root.dataset.param;

            const close = () => {
                menu.hidden = true;
                trigger.setAttribute('aria-expanded', 'false');
            };

            const open = () => {
                menu.hidden = false;
                trigger.setAttribute('aria-expanded', 'true');
            };

            trigger.addEventListener('click', () => (menu.hidden ? open() : close()));

            options.forEach((option) => {
                option.addEventListener('click', () => {
                    options.forEach((o) => {
                        const active = o === option;
                        o.setAttribute('aria-selected', active ? 'true' : 'false');
                        o.classList.toggle('bg-cream-dark', active);
                        o.classList.toggle('font-medium', active);
                        o.classList.toggle('font-normal', !active);
                    });

                    const text = option.textContent.trim();
                    label.textContent = text;
                    close();

                    root.dispatchEvent(new CustomEvent('range-change', {
                        bubbles: true,
                        detail: { value: option.dataset.value, label: text },
                    }));

                    if (navigate) {
                        const url = new URL(window.location.href);
                        url.searchParams.set(param, option.dataset.value);
                        window.location.href = url.toString();
                    }
                });
            });

            document.addEventListener('click', (event) => {
                if (!root.contains(event.target)) close();
            });

            root.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    close();
                    trigger.focus();
                }
            });
        });
    </script>
@endonce