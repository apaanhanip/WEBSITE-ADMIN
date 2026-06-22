@extends('layouts.app')

@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu')

@section('content')
<div class="max-w-3xl">
    <div class="card">
        <form action="{{ route('menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('menus._form', ['menu' => $menu])
            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Perbarui Menu</button>
                <a href="{{ route('menus.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
