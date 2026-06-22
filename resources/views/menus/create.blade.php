@extends('layouts.app')

@section('title', 'Tambah Menu')
@section('page-title', 'Tambah Menu')

@section('content')
<div class="max-w-3xl">
    <div class="card">
        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('menus._form')
            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Simpan Menu</button>
                <a href="{{ route('menus.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
