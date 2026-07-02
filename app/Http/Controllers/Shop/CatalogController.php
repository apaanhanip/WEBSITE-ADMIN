<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function category(Request $request, ServiceCategory $serviceCategory): View
    {
        abort_unless($serviceCategory->is_active, 404);

        $products = $serviceCategory->products()
            ->where('is_active', true)
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->orderByDesc('is_featured')
            ->orderByDesc('sold_count')
            ->paginate(12)
            ->withQueryString();

        $categories = ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('shop.category', compact('serviceCategory', 'products', 'categories'));
    }

    public function product(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load('category');

        $related = Product::where('service_category_id', $product->service_category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('shop.product', compact('product', 'related'));
    }
}
