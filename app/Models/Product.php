<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'delivery_type',
        'is_active',
        'is_featured',
        'sold_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function stockItems(): HasMany
    {
        return $this->hasMany(StockItem::class);
    }

    public function availableStock(): HasMany
    {
        return $this->hasMany(StockItem::class)->where('status', 'available');
    }

    public function getAvailableStockCountAttribute(): int
    {
        return $this->stockItems()->where('status', 'available')->count();
    }

    public function getInStockAttribute(): bool
    {
        return $this->delivery_type === 'manual' || $this->available_stock_count > 0;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
