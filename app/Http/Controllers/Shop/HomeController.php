<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ServiceCategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = ServiceCategory::where('is_active', true)
            ->withCount(['activeProducts as products_count'])
            ->orderBy('sort_order')
            ->get();

        $sections = ServiceCategory::where('is_active', true)
            ->with(['activeProducts' => fn ($q) => $q->orderByDesc('is_featured')->orderByDesc('sold_count')->limit(8)])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn ($cat) => $cat->activeProducts->isNotEmpty());

        $recentSales = Purchase::where('status', 'completed')
            ->latest()
            ->limit(15)
            ->get(['product_name', 'created_at']);

        $stats = [
            'products' => Product::where('is_active', true)->count(),
            'categories' => $categories->count(),
            'sales' => Purchase::where('status', 'completed')->count(),
        ];

        return view('shop.home', compact('categories', 'sections', 'recentSales', 'stats'));
    }
}
