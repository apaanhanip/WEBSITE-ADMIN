<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="name" class="form-label">Nama Menu</label>
        <input type="text" name="name" id="name" value="{{ old('name', $menu->name ?? '') }}"
               class="form-input" required>
    </div>
    <div>
        <label for="category_id" class="form-label">Kategori</label>
        <select name="category_id" id="category_id" class="form-input" required>
            <option value="">Pilih kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $menu->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="price" class="form-label">Harga (Rp)</label>
        <input type="number" name="price" id="price" min="0" step="100"
               value="{{ old('price', $menu->price ?? '') }}" class="form-input" required>
    </div>
    <div class="md:col-span-2">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea name="description" id="description" rows="3" class="form-input">{{ old('description', $menu->description ?? '') }}</textarea>
    </div>
    <div>
        <label for="menu-image" class="form-label">Gambar Menu</label>
        <input type="file" name="image" id="menu-image" accept="image/*" class="form-input file:mr-4 file:rounded-lg file:border-0 file:bg-coffee-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-coffee-800">
    </div>
    <div>
        <label class="form-label">Status Ketersediaan</label>
        <label class="mt-2 flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="is_available" value="1"
                   class="h-5 w-5 rounded border-coffee-300 text-coffee-700 focus:ring-coffee-500"
                   {{ old('is_available', $menu->is_available ?? true) ? 'checked' : '' }}>
            <span class="text-sm text-coffee-700">Tersedia</span>
        </label>
    </div>
    <div class="md:col-span-2">
        <label class="form-label">Preview Gambar</label>
        <img id="image-preview" src="{{ isset($menu) && $menu->image ? $menu->image_url : '' }}"
             alt="Preview" class="{{ (isset($menu) && $menu->image) ? '' : 'hidden' }} mt-2 h-40 w-40 rounded-xl object-cover border border-coffee-200">
    </div>
</div>
