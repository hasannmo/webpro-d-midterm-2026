@extends('layouts.admin')

@section('admin-content')
    <x-admin-dashboard
        :selected="$selected"
        :total-order="$totalOrder"
        :total-user="$totalUser"
        :order-href="route('admin.order')"
        :user-href="route('admin.account')">
        <x-slot:chart>
            <x-order-chart :data="$chartData" :labels="$chartLabels" />
        </x-slot:chart>
    </x-admin-dashboard>
@endsection

