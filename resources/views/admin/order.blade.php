@extends('layouts.admin')

@section('admin-content')
    <x-admin-order
        :selected="$selected"
        :total="$total"
        :orders="$orders"
        :paginator="$paginator">
        <x-slot:chart>
            <x-order-chart :data="$chartData" :labels="$chartLabels" />
        </x-slot:chart>
    </x-admin-order>
@endsection

