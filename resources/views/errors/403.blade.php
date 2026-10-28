@extends('layouts.app')

@section('title', '403 Forbidden — mijusan')

@section('content')
    <section class="section flex min-h-[60vh] items-center justify-center py-16">
        <div class="mx-auto max-w-md px-4 text-center">
            <div class="rounded-2xl border border-sand bg-white p-8 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-12">
                <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-danger mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                    </svg>
                </span>

                <h1 class="font-heading text-4xl font-semibold text-ink">403</h1>
                <h2 class="mt-2 font-heading text-xl font-medium text-ink">Access Restricted</h2>
                <p class="mt-3 text-sm text-muted">
                    {{ $exception->getMessage() ?: 'You do not have permission to access this area.' }}
                </p>

                <div class="mt-8 flex flex-col gap-3">
                    <a href="{{ route('home') }}"
                       class="flex h-11 w-full items-center justify-center rounded-lg bg-brand text-sm font-medium text-white transition hover:bg-brand-dark">
                        Return to Home
                    </a>
                    @if (auth()->check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex h-11 w-full cursor-pointer items-center justify-center rounded-lg border border-sand bg-cream text-sm font-normal text-ink transition hover:bg-cream-dark">
                                Switch Account (Log Out)
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

