<div class="space-y-5">
    <div>
        <label for="name" class="form-label">Nama Kategori</label>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}"
               class="form-input" placeholder="Contoh: Coffee" required>
    </div>
    <div>
        <label for="description" class="form-label">Deskripsi</label>
        <textarea name="description" id="description" rows="3" class="form-input"
                  placeholder="Deskripsi kategori...">{{ old('description', $category->description ?? '') }}</textarea>
    </div>
</div>
