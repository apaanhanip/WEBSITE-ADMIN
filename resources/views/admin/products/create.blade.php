@extends('layouts.app')

@section('title', 'เพิ่มสินค้า')
@section('page-title', 'เพิ่มสินค้า')

@section('content')
<div class="card max-w-3xl">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form')
    </form>
</div>
@endsection
