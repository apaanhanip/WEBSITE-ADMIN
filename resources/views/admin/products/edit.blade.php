@extends('layouts.app')

@section('title', 'แก้ไขสินค้า')
@section('page-title', 'แก้ไขสินค้า')

@section('content')
<div class="card max-w-3xl">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.products._form')
    </form>
</div>
@endsection
