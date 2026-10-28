@extends('layouts.admin')

@section('title', 'Admin Account Management — mijusan')

@section('admin-content')
    <x-admin-account
        :users="$users"
        :total="$total"
        :paginator="$paginator"
        :add-href="route('admin.account.create')" />
@endsection


