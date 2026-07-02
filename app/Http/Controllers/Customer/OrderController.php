<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Auth::guard('web')->user()
            ->purchases()
            ->with('product')
            ->paginate(15);

        return view('shop.account.orders', compact('orders'));
    }

    public function show(Purchase $purchase): View
    {
        abort_unless($purchase->user_id === Auth::guard('web')->id(), 403);

        return view('shop.account.order', compact('purchase'));
    }
}
