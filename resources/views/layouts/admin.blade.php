@extends('layouts.app')

@section('title', 'Admin ' . ucfirst($active ?? 'Dashboard') . ' — mijusan')

@section('content')
    <div class="min-h-[calc(100vh-200px)] bg-cream">
        <div class="mx-auto flex w-full max-w-[1440px] flex-col items-start gap-4 p-3 sm:p-4 md:flex-row md:gap-6 md:px-8 md:py-10">
            <x-dashboard-menu :active="$active" />

            <div class="w-full flex-1 min-w-0">
                @yield('admin-content')
            </div>
        </div>
    </div>
@endsection

