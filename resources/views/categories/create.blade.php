@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="max-w-3xl">
    <div class="card">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            @include('categories._form')
            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('categories.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
