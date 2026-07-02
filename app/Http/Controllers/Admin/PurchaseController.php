<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Purchase::with(['user', 'product'])
            ->when($request->filled('q'), fn ($q) => $q->where('order_code', 'like', '%'.$request->q.'%')
                ->orWhere('product_name', 'like', '%'.$request->q.'%'))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Purchase $purchase): View
    {
        $purchase->load(['user', 'product']);

        return view('admin.orders.show', compact('purchase'));
    }
}
