@extends('layouts.admin')

@section('title', 'Admin Rickroll Tracker — mijusan')

@section('admin-content')
    <section class="w-full rounded-2xl border border-sand bg-white p-4 sm:p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-8">
        <div class="flex items-center justify-between border-b border-sand pb-4">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-[32px] font-bold leading-tight text-black">Rickroll Tracker</h1>
                <p class="mt-1 text-xs sm:text-sm text-muted">Users & guests redirected by footer links to Never Gonna Give You Up</p>
            </div>
            <a href="{{ route('rickroll') }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex h-9 items-center gap-1.5 rounded-lg bg-danger px-3 text-xs sm:text-sm font-medium text-white transition hover:brightness-95">
                <x-icon name="youtube" :size="16" />
                <span>Test Link</span>
            </a>
        </div>

        <div class="mt-4 flex min-h-[48px] items-center border-t border-muted/40 px-1 sm:px-3">
            <p class="text-xs sm:text-sm md:text-base font-medium text-black">
                Total Tracked : {{ $clicks->total() }} (Total Clicks : {{ $clicks->sum('click_count') }})
            </p>
        </div>

        {{-- Table Header --}}
        <div class="hidden border-t border-muted/40 px-3 py-3 text-xs font-semibold tracking-wider text-muted uppercase md:grid md:grid-cols-[1.5fr_2fr_1fr_1.5fr] md:items-center md:gap-4">
            <span>Username</span>
            <span>Email</span>
            <span class="text-center">Click Count</span>
            <span class="text-right">Latest Timestamp</span>
        </div>

        <ul>
            @forelse ($clicks as $click)
                <li class="flex flex-col gap-1 border-t border-muted/20 px-2 py-2.5 text-xs md:text-sm font-light text-black md:grid md:min-h-[54px] md:grid-cols-[1.5fr_2fr_1fr_1.5fr] md:items-center md:gap-4 md:py-0">
                    <div class="flex items-center justify-between md:block">
                        <span class="font-medium text-ink leading-tight truncate" title="{{ $click->username ?? 'Anonymous' }}">
                            {{ $click->username ?? 'Anonymous' }}
                        </span>
                        <span class="md:hidden inline-flex items-center rounded-full bg-brand/10 px-2.5 py-0.5 text-xs font-semibold text-brand-text">
                            {{ $click->click_count }} {{ Str::plural('click', $click->click_count) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between md:block">
                        <span class="text-muted md:text-ink truncate font-mono text-[11px] md:text-xs" title="{{ $click->email }}">
                            {{ $click->email ?? '-' }}
                        </span>
                        <span class="text-[10px] text-muted md:hidden">
                            {{ $click->last_clicked_at ? $click->last_clicked_at->format('d/m/Y H:i:s') : '-' }}
                        </span>
                    </div>

                    <div class="hidden md:flex justify-center">
                        <span class="inline-flex items-center rounded-full bg-brand/10 px-3 py-0.5 text-xs font-semibold text-brand-text">
                            {{ $click->click_count }}
                        </span>
                    </div>

                    <span class="hidden md:block text-xs text-muted md:text-right font-mono">
                        {{ $click->last_clicked_at ? $click->last_clicked_at->format('d/m/Y H:i:s') : '-' }}
                    </span>
                </li>
            @empty
                <li class="border-t border-muted/40 px-2.5 py-8 text-center text-muted">
                    No one has fallen for the rickroll yet! ;)
                </li>
            @endforelse
        </ul>

        @if ($clicks->hasPages())
            <div class="mt-6 border-t border-muted/40 pt-6">
                {{ $clicks->links() }}
            </div>
        @endif
    </section>
@endsection

