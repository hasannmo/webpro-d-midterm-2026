@extends('layouts.app')

@section('title', 'Sign Up — mijusan')

@section('content')
    <section class="section py-16 md:py-24">
        <div class="mx-auto max-w-md px-4">
            <div class="rounded-2xl border border-sand bg-white p-8 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-10">
                <div class="flex items-center gap-4 border-b border-sand pb-4">
                    <a href="{{ route('home') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-cream-dark text-ink transition hover:bg-brand hover:text-white" aria-label="Back to home">
                        <x-icon name="arrow-left" :size="18" />
                    </a>
                    <h1 class="font-serif text-3xl font-semibold text-ink">Create Account</h1>
                </div>

                @if ($errors->any())
                    <div class="mt-5 rounded-lg bg-red-50 p-3 text-sm text-red-600 border border-red-200">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-ink">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                               class="mt-1.5 w-full rounded-xl border border-sand bg-cream px-4 py-2.5 text-base text-ink outline-none transition focus:border-brand focus:bg-white"
                               placeholder="e.g. Jane Doe">
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-ink">Username (Optional)</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                               class="mt-1.5 w-full rounded-xl border border-sand bg-cream px-4 py-2.5 text-base text-ink outline-none transition focus:border-brand focus:bg-white"
                               placeholder="e.g. janedoe">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-ink">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="mt-1.5 w-full rounded-xl border border-sand bg-cream px-4 py-2.5 text-base text-ink outline-none transition focus:border-brand focus:bg-white"
                               placeholder="your.email@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-ink">Password</label>
                        <input type="password" name="password" id="password" required
                               class="mt-1.5 w-full rounded-xl border border-sand bg-cream px-4 py-2.5 text-base text-ink outline-none transition focus:border-brand focus:bg-white"
                               placeholder="At least 6 characters">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-ink">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="mt-1.5 w-full rounded-xl border border-sand bg-cream px-4 py-2.5 text-base text-ink outline-none transition focus:border-brand focus:bg-white"
                               placeholder="Repeat password">
                    </div>

                    <button type="submit"
                            class="mt-2 flex h-12 w-full cursor-pointer items-center justify-center rounded-lg bg-brand text-base font-normal text-white transition-colors duration-200 hover:bg-brand-dark focus-visible:bg-brand-dark outline-none">
                        Sign Up
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-muted">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-brand-text hover:underline">Sign In</a>
                </p>
            </div>
        </div>
    </section>
@endsection

