@extends('layouts.app')

@section('title', 'แก้ไขหมวดหมู่')
@section('page-title', 'แก้ไขหมวดหมู่')

@section('content')
<div class="card max-w-2xl">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.categories._form')
    </form>
</div>
@endsection
