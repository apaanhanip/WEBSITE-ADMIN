@if ($errors->any())
<div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
    <p class="font-semibold mb-2">Terjadi kesalahan:</p>
    <ul class="list-disc list-inside space-y-1">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
