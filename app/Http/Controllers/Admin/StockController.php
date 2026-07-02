<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(Product $product): View
    {
        $items = $product->stockItems()->latest()->paginate(20);
        $availableCount = $product->stockItems()->where('status', 'available')->count();
        $soldCount = $product->stockItems()->where('status', 'sold')->count();

        return view('admin.products.stock', compact('product', 'items', 'availableCount', 'soldCount'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'items' => ['required', 'string'],
        ], [
            'items.required' => 'กรุณากรอกข้อมูลสต็อก',
        ]);

        $lines = collect(preg_split('/\r\n|\r|\n/', $data['items']))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values();

        if ($lines->isEmpty()) {
            return back()->with('error', 'ไม่พบข้อมูลสต็อกที่ถูกต้อง');
        }

        foreach ($lines as $line) {
            StockItem::create([
                'product_id' => $product->id,
                'content' => $line,
                'status' => 'available',
            ]);
        }

        return back()->with('success', 'เพิ่มสต็อก '.$lines->count().' รายการสำเร็จ');
    }

    public function destroy(Product $product, StockItem $stockItem): RedirectResponse
    {
        abort_unless($stockItem->product_id === $product->id, 404);

        if ($stockItem->status === 'sold') {
            return back()->with('error', 'ไม่สามารถลบสต็อกที่ขายไปแล้ว');
        }

        $stockItem->delete();

        return back()->with('success', 'ลบสต็อกสำเร็จ');
    }
}
