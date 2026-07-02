@include('components.alert')

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="name" class="form-label">ชื่อหมวดหมู่ *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="form-input" required>
    </div>
    <div>
        <label for="icon" class="form-label">ไอคอน (อีโมจิ)</label>
        <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}" class="form-input" placeholder="📱" maxlength="8">
    </div>
    <div>
        <label for="sort_order" class="form-label">ลำดับการแสดง</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="form-input" min="0">
    </div>
    <div class="sm:col-span-2">
        <label for="tagline" class="form-label">คำโปรย</label>
        <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $category->tagline) }}" class="form-input">
    </div>
    <div class="sm:col-span-2">
        <label for="description" class="form-label">คำอธิบาย</label>
        <textarea name="description" id="description" rows="3" class="form-input">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="sm:col-span-2">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-coffee-300 text-coffee-700 focus:ring-coffee-500" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
            <span class="text-sm text-coffee-800">เปิดใช้งาน</span>
        </label>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="btn-primary">บันทึก</button>
    <a href="{{ route('admin.categories.index') }}" class="btn-secondary">ยกเลิก</a>
</div>
