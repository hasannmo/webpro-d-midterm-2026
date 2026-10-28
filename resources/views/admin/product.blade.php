@extends('layouts.admin')

@section('admin-content')
    <x-admin-product
        :products="$products"
        add-href="#" />
@endsection

