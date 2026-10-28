@extends('layouts.admin')

@section('title', 'Admin Product Management — mijusan')

@section('admin-content')
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-700 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <x-admin-product
        :products="$products"
        :add-href="route('admin.product.create')" />
@endsection


