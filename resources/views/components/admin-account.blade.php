@props([
    'users' => [],
    'total' => 'xxxx',
    'addHref' => '#',
    'paginator' => null,
])

@php
    $format = fn ($value) => is_numeric($value) ? number_format($value, 0, ',', '.') : $value;
    $date = fn ($value) => $value instanceof \DateTimeInterface ? $value->format('d/m/Y H:i:s') : $value;
@endphp

<section {{ $attributes->class('w-full rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-9') }}>
    <h1 class="text-[32px] font-bold leading-tight text-black">Account Management</h1>

    <a href="{{ $addHref }}"
       class="mt-6 inline-flex h-[53px] items-center justify-center rounded-lg bg-warning px-3 text-[22px] font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
        Add User
    </a>

    <div class="mt-6 flex min-h-[82px] items-center border-t border-muted/40 px-2.5">
        <p class="text-[18px] font-medium text-black">Total User : {{ $format($total) }}</p>
    </div>

    {{-- Table Header --}}
    <div class="hidden border-t border-muted/40 px-2.5 py-3 text-[16px] font-semibold text-muted md:grid md:grid-cols-[1.4fr_1.6fr_1fr_1.6fr_auto] md:items-center md:gap-4">
        <span>Username</span>
        <span>Email Address</span>
        <span>Role</span>
        <span class="md:text-right">Created Date</span>
        <span class="w-[90px] text-center">Action</span>
    </div>

    <ul>
        @forelse ($users as $user)
            <li class="flex flex-col gap-1 border-t border-muted/40 px-2.5 py-4 text-[18px] font-light text-black md:grid md:min-h-[82px] md:grid-cols-[1.4fr_1.6fr_1fr_1.6fr_auto] md:items-center md:gap-4 md:py-0">
                <span class="font-medium text-ink md:font-light">{{ $user['username'] }}</span>
                <a href="mailto:{{ $user['email'] }}" class="w-fit text-brand-text underline">{{ $user['email'] }}</a>
                <span>{{ $user['role'] }}</span>
                <span class="md:text-right">{{ $date($user['date']) }}</span>
                <a href="{{ $user['manageHref'] ?? '#' }}"
                   class="mt-2 inline-flex h-12 w-[90px] items-center justify-center rounded-md bg-sage px-3 text-[18px] font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none md:mt-0">
                    Manage
                </a>
            </li>
        @empty
            <li class="border-t border-muted/40 px-2.5 py-6 text-center text-muted">
                No users found.
            </li>
        @endforelse
    </ul>

    @if ($paginator)
        <div class="mt-6 border-t border-muted/40 pt-6">
            {{ $paginator->links() }}
        </div>
    @endif
</section>
