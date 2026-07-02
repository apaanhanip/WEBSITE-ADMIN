@extends('layouts.app')

@section('title', 'เพิ่มหมวดหมู่')
@section('page-title', 'เพิ่มหมวดหมู่')

@section('content')
<div class="card max-w-2xl">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        @include('admin.categories._form')
    </form>
</div>
@endsection
