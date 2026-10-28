@extends('layouts.app')

@section('title', 'Admin ' . ucfirst($active ?? 'Dashboard') . ' — mijusan')

@section('content')
    <div class="min-h-[calc(100vh-200px)] bg-cream">
        <div class="mx-auto flex w-full max-w-[1440px] flex-col items-start gap-6 px-4 py-8 md:flex-row md:px-8 md:py-12">
            <x-dashboard-menu :active="$active" />

            <div class="w-full flex-1">
                @yield('admin-content')
            </div>
        </div>
    </div>
@endsection

