@props([
    'action' => '#',
    'registerHref' => '#',
])

<div {{ $attributes->class('w-full max-w-[440px] rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-6') }}>
    <h1 class="border-b border-ink pb-1 font-heading text-[36px] font-medium leading-tight tracking-tight text-ink">Login</h1>

    <form method="POST" action="{{ $action }}" class="mt-4">
        @csrf

        <label for="login-email" class="block text-base font-normal text-black">Email</label>
        <input id="login-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
               class="mt-1 h-[54px] w-full rounded-lg border border-black bg-white px-4 text-base text-ink outline-none transition-colors duration-200 focus:border-brand focus:ring-2 focus:ring-brand/30 @error('email') border-danger @enderror">
        @error('email')
            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
        @enderror

        <label for="login-password" class="mt-2 block text-base font-normal text-black">Password</label>
        <input id="login-password" type="password" name="password" required autocomplete="current-password"
               class="mt-1 h-[54px] w-full rounded-lg border border-black bg-white px-4 text-base text-ink outline-none transition-colors duration-200 focus:border-brand focus:ring-2 focus:ring-brand/30 @error('password') border-danger @enderror">
        @error('password')
            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
        @enderror

        <button type="submit"
                class="mt-8 flex h-12 w-full cursor-pointer items-center justify-center rounded-lg bg-brand text-[18px] font-normal text-white transition-colors duration-200 hover:bg-brand-dark focus-visible:bg-brand-dark outline-none">
            Log in
        </button>
    </form>

    <p class="mt-8 text-base font-normal text-black">
        Don't have an account yet?
        <a href="{{ $registerHref }}" class="text-brand-text hover:underline">Register Here</a>
    </p>
</div>