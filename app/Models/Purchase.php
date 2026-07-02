<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'user_id',
        'product_id',
        'product_name',
        'unit_price',
        'quantity',
        'total',
        'status',
        'delivered_content',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public const STATUS_LABELS = [
        'completed' => 'สำเร็จ',
        'pending' => 'รอดำเนินการ',
        'failed' => 'ไม่สำเร็จ',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stockItems(): HasMany
    {
        return $this->hasMany(StockItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'completed' => 'green',
            'pending' => 'yellow',
            'failed' => 'red',
            default => 'blue',
        };
    }
}
