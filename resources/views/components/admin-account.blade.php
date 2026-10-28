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

    @if (session('success'))
        <div class="mt-4 rounded-lg bg-green-50 p-4 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mt-4 rounded-lg bg-red-50 p-4 text-red-700 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

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
                <span class="font-medium text-ink md:font-light">{{ $user['username'] ?? $user['name'] }}</span>
                <a href="mailto:{{ $user['email'] }}" class="w-fit text-brand-text underline">{{ $user['email'] }}</a>
                <span class="inline-block rounded-full px-2.5 py-0.5 text-sm {{ $user['role'] === 'Administrator' ? 'bg-brand/10 text-brand-text font-medium' : 'text-black' }}">
                    {{ $user['role'] }}
                </span>
                <span class="md:text-right">{{ $date($user['date']) }}</span>
                <button type="button"
                        data-manage-user
                        data-id="{{ $user['id'] }}"
                        data-username="{{ $user['username'] ?? $user['name'] }}"
                        data-email="{{ $user['email'] }}"
                        data-role="{{ $user['role'] }}"
                        data-update-url="{{ route('admin.account.update', ['id' => $user['id']]) }}"
                        data-delete-url="{{ route('admin.account.delete', ['id' => $user['id']]) }}"
                        class="mt-2 inline-flex h-12 w-[90px] cursor-pointer items-center justify-center rounded-md bg-sage px-3 text-[18px] font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none md:mt-0">
                    Manage
                </button>
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

{{-- Manage User Modal --}}
<div id="manageUserModal" hidden class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-[2px]">
    <div class="relative w-full max-w-md rounded-2xl border border-sand bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-sand pb-3">
            <h3 class="font-heading text-2xl font-medium text-ink">Manage User</h3>
            <button type="button" id="closeManageModal" class="text-muted hover:text-ink text-2xl font-light">&times;</button>
        </div>

        <div class="mt-4">
            <p class="text-sm text-muted">User Account</p>
            <p id="modalUserDisplay" class="font-medium text-lg text-ink"></p>
            <p id="modalEmailDisplay" class="text-sm text-brand-text"></p>
        </div>

        {{-- Role Update Form --}}
        <form id="updateRoleForm" method="POST" action="" class="mt-5 border-t border-sand pt-4">
            @csrf
            @method('PATCH')
            <label for="modalRoleSelect" class="block text-sm font-medium text-ink">Change Role</label>
            <div class="mt-2 flex gap-3">
                <select name="role" id="modalRoleSelect" class="flex-1 rounded-lg border border-sand bg-cream-dark px-3 py-2 text-base text-ink outline-none focus:border-brand">
                    <option value="Customer">Customer</option>
                    <option value="Administrator">Administrator</option>
                </select>
                <button type="submit" class="rounded-lg bg-brand px-5 py-2 text-sm font-medium text-white transition hover:bg-brand-dark">
                    Save Role
                </button>
            </div>
        </form>

        {{-- Delete User Form --}}
        <form id="deleteUserForm" method="POST" action="" class="mt-6 border-t border-sand pt-4" onsubmit="return confirm('Are you sure you want to permanently remove this user?');">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-danger">Remove User</p>
                    <p class="text-xs text-muted">This action will delete user data.</p>
                </div>
                <button type="submit" class="rounded-lg bg-danger px-4 py-2 text-sm font-medium text-white transition hover:opacity-90">
                    Remove
                </button>
            </div>
        </form>
    </div>
</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('manageUserModal');
            const closeBtn = document.getElementById('closeManageModal');
            const userDisplay = document.getElementById('modalUserDisplay');
            const emailDisplay = document.getElementById('modalEmailDisplay');
            const roleSelect = document.getElementById('modalRoleSelect');
            const updateForm = document.getElementById('updateRoleForm');
            const deleteForm = document.getElementById('deleteUserForm');

            const closeModal = () => {
                modal.hidden = true;
            };

            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            document.querySelectorAll('[data-manage-user]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const username = btn.dataset.username;
                    const email = btn.dataset.email;
                    const role = btn.dataset.role;
                    const updateUrl = btn.dataset.updateUrl;
                    const deleteUrl = btn.dataset.deleteUrl;

                    userDisplay.textContent = username;
                    emailDisplay.textContent = email;
                    roleSelect.value = role;
                    updateForm.action = updateUrl;
                    deleteForm.action = deleteUrl;

                    modal.hidden = false;
                });
            });
        });
    </script>
@endonce

