<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    {{-- Detail kategori --}}
    <div class="space-y-5">
        <div>
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}"
                   class="form-input" placeholder="Contoh: Coffee" required>
        </div>
        <div>
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" rows="3" class="form-input"
                      placeholder="Deskripsi singkat kategori...">{{ old('description', $category->description ?? '') }}</textarea>
        </div>
        <div>
            <label for="is_active" class="form-label">Status</label>
            @php $activeValue = (int) old('is_active', isset($category) ? (int) $category->is_active : 1); @endphp
            <select name="is_active" id="is_active" class="form-input" required>
                <option value="1" {{ $activeValue === 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $activeValue === 0 ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <p class="mt-1.5 text-xs text-coffee-400">Kategori nonaktif tetap tersimpan namun ditandai tidak aktif.</p>
        </div>
    </div>

    {{-- Pilihan menu --}}
    <div class="space-y-4">
        @isset($category)
            <div>
                <p class="form-label">Menu dalam kategori ini ({{ $category->menus->count() }})</p>
                @if($category->menus->isEmpty())
                    <div class="rounded-xl border border-dashed border-coffee-200 bg-cream-50 p-3 text-sm text-coffee-400">
                        Belum ada menu pada kategori ini.
                    </div>
                @else
                    <div class="flex flex-wrap gap-2 rounded-xl border border-coffee-100 bg-cream-50 p-3">
                        @foreach($category->menus as $current)
                            <span class="badge bg-brand-100 text-brand-700">{{ $current->name }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        @endisset

        <div>
            <label class="form-label">{{ isset($category) ? 'Tambah menu ke kategori ini' : 'Pilih menu untuk kategori ini' }}</label>
            @if($assignableMenus->isEmpty())
                <div class="rounded-xl border border-dashed border-coffee-200 bg-cream-50 p-4 text-sm text-coffee-400">
                    Tidak ada menu yang bisa dipilih. Tambahkan menu terlebih dahulu di halaman Menu.
                </div>
            @else
                <div class="max-h-72 space-y-1 overflow-y-auto rounded-xl border border-coffee-100 p-2">
                    @foreach($assignableMenus as $option)
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg px-2 py-2 transition hover:bg-cream-50">
                            <input type="checkbox" name="menu_ids[]" value="{{ $option->id }}"
                                   class="h-4 w-4 rounded border-coffee-300 text-brand-600 focus:ring-brand-400"
                                   {{ in_array($option->id, old('menu_ids', [])) ? 'checked' : '' }}>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-sm font-medium text-coffee-800">{{ $option->name }}</span>
                                <span class="block text-xs text-coffee-400">
                                    Rp {{ number_format($option->price, 0, ',', '.') }} · {{ $option->category?->name ?? 'Tanpa kategori' }}
                                </span>
                            </span>
                        </label>
                    @endforeach
                </div>
                <p class="mt-1.5 text-xs text-coffee-400">Centang menu untuk memindahkannya ke kategori ini.</p>
            @endif
        </div>
    </div>
</div>
