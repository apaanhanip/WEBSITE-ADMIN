@include('components.alert')

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="name" class="form-label">ชื่อสินค้า *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-input" required>
    </div>
    <div>
        <label for="service_category_id" class="form-label">หมวดหมู่ *</label>
        <select name="service_category_id" id="service_category_id" class="form-input" required>
            <option value="">เลือกหมวดหมู่</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('service_category_id', $product->service_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="price" class="form-label">ราคา (บาท) *</label>
        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="form-input" step="0.01" min="0" required>
    </div>
    <div>
        <label for="delivery_type" class="form-label">รูปแบบการจัดส่ง *</label>
        <select name="delivery_type" id="delivery_type" class="form-input" required>
            <option value="auto_stock" {{ old('delivery_type', $product->delivery_type) === 'auto_stock' ? 'selected' : '' }}>อัตโนมัติ (ตัดจากสต็อก)</option>
            <option value="manual" {{ old('delivery_type', $product->delivery_type) === 'manual' ? 'selected' : '' }}>Manual (แอดมินจัดส่งเอง)</option>
        </select>
    </div>
    <div>
        <label for="image" class="form-label">รูปภาพ</label>
        <input type="file" name="image" id="image" accept="image/*" class="form-input">
        @if($product->image)
            <img src="{{ $product->image_url }}" class="mt-2 h-16 rounded-lg object-cover">
        @endif
    </div>
    <div class="sm:col-span-2">
        <label for="description" class="form-label">คำอธิบาย</label>
        <textarea name="description" id="description" rows="4" class="form-input">{{ old('description', $product->description) }}</textarea>
    </div>
    <div class="flex gap-6 sm:col-span-2">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-coffee-300 text-coffee-700 focus:ring-coffee-500" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
            <span class="text-sm text-coffee-800">เปิดขาย</span>
        </label>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-coffee-300 text-coffee-700 focus:ring-coffee-500" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
            <span class="text-sm text-coffee-800">สินค้าแนะนำ</span>
        </label>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="btn-primary">บันทึก</button>
    <a href="{{ route('admin.products.index') }}" class="btn-secondary">ยกเลิก</a>
</div>
