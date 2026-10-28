@extends('layouts.admin')

@section('title', 'Admin Add User — mijusan')

@section('admin-content')
    <section class="w-full rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-9 max-w-2xl">
        <div class="flex items-center gap-4 border-b border-sand pb-4">
            <a href="{{ route('admin.account') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-cream-dark text-ink transition hover:bg-brand hover:text-white" aria-label="Back">
                <x-icon name="arrow-left" :size="20" />
            </a>
            <h1 class="text-[32px] font-bold leading-tight text-black">Add User</h1>
        </div>

        @if ($errors->any())
            <div class="mt-6 rounded-lg bg-red-50 p-4 text-sm text-red-600 border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.account.store') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-base font-medium text-ink">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink outline-none transition focus:border-brand focus:bg-white"
                       placeholder="e.g. Jane Doe">
            </div>

            <div>
                <label for="username" class="block text-base font-medium text-ink">Username (Optional)</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}"
                       class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink outline-none transition focus:border-brand focus:bg-white"
                       placeholder="e.g. janedoe">
            </div>

            <div>
                <label for="email" class="block text-base font-medium text-ink">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink outline-none transition focus:border-brand focus:bg-white"
                       placeholder="user@example.com">
            </div>

            <div>
                <label for="password" class="block text-base font-medium text-ink">Password</label>
                <input type="password" name="password" id="password" required
                       class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink outline-none transition focus:border-brand focus:bg-white"
                       placeholder="••••••••">
            </div>

            <div>
                <label for="role" class="block text-base font-medium text-ink">Role</label>
                <select name="role" id="role"
                        class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink outline-none transition focus:border-brand focus:bg-white">
                    <option value="Customer" {{ old('role') === 'Customer' ? 'selected' : '' }}>Customer</option>
                    <option value="Administrator" {{ old('role') === 'Administrator' ? 'selected' : '' }}>Administrator</option>
                    @if (auth()->check() && auth()->user()->isCreator())
                        <option value="Creator" {{ old('role') === 'Creator' ? 'selected' : '' }}>Creator</option>
                    @endif
                </select>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit"
                        class="inline-flex h-11 items-center justify-center rounded-lg bg-warning px-6 text-sm md:text-base font-medium text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
                    Create User
                </button>
                <a href="{{ route('admin.account') }}" class="text-sm text-muted hover:text-ink">Cancel</a>
            </div>
        </form>
    </section>
@endsection

