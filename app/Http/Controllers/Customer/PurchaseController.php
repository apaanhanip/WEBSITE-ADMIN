<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\PurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class PurchaseController extends Controller
{
    public function store(Request $request, Product $product, PurchaseService $service): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $user = Auth::guard('web')->user();

        try {
            $purchase = $service->purchase($user, $product, (int) $data['quantity']);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('account.orders.show', $purchase)
            ->with('success', 'สั่งซื้อสำเร็จ! ข้อมูลสินค้าแสดงด้านล่าง');
    }
}
