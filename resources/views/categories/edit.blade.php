@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="max-w-3xl">
    <div class="card">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf @method('PUT')
            @include('categories._form', ['category' => $category])
            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Perbarui</button>
                <a href="{{ route('categories.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
