@extends('layouts.admin')

@section('admin-content')
    <x-admin-account
        :users="$users"
        :total="$total"
        :paginator="$paginator"
        add-href="#" />
@endsection

