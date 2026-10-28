@props([
    'action' => '#',
    'loginHref' => '#',
])

<div {{ $attributes->class('w-full max-w-[440px] rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-6') }}>
    <h1 class="border-b border-ink pb-1 font-heading text-[36px] font-medium leading-tight tracking-tight text-ink">Register</h1>

    <form method="POST" action="{{ $action }}" class="mt-4">
        @csrf

        <label for="register-email" class="block text-base font-normal text-black">Email</label>
        <input id="register-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
               class="mt-1 h-[54px] w-full rounded-lg border border-black bg-white px-4 text-base text-ink outline-none transition-colors duration-200 focus:border-brand focus:ring-2 focus:ring-brand/30 @error('email') border-danger @enderror">
        @error('email')
            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
        @enderror

        <label for="register-password" class="mt-2 block text-base font-normal text-black">Password</label>
        <input id="register-password" type="password" name="password" required autocomplete="new-password"
               class="mt-1 h-[54px] w-full rounded-lg border border-black bg-white px-4 text-base text-ink outline-none transition-colors duration-200 focus:border-brand focus:ring-2 focus:ring-brand/30 @error('password') border-danger @enderror">
        @error('password')
            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
        @enderror

        <label for="register-password-confirmation" class="mt-2 block text-base font-normal text-black">Confirm your password</label>
        <input id="register-password-confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
               class="mt-1 h-[54px] w-full rounded-lg border border-black bg-white px-4 text-base text-ink outline-none transition-colors duration-200 focus:border-brand focus:ring-2 focus:ring-brand/30">

        <button type="submit"
                class="mt-8 flex h-12 w-full cursor-pointer items-center justify-center rounded-lg bg-brand text-[18px] font-normal text-white transition-colors duration-200 hover:bg-brand-dark focus-visible:bg-brand-dark outline-none">
            Register
        </button>
    </form>

    <p class="mt-8 text-base font-normal text-black">
        Already have an account?
        <a href="{{ $loginHref }}" class="text-brand-text hover:underline">Login Here</a>
    </p>
</div>