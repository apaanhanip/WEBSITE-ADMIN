<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $orders = Order::with(['items', 'transaction'])
            ->when($request->search, function ($query, $search) {
                $query->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            })
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        if ($request->ajax() && $request->has('single')) {
            $order = Order::with(['items', 'transaction'])->findOrFail($request->single);

            return response()->json([
                'html' => view('orders._detail', compact('order'))->render(),
            ]);
        }

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): JsonResponse
    {
        $order->load(['items', 'transaction']);

        return response()->json([
            'html' => view('orders._detail', compact('order'))->render(),
        ]);
    }

    public function updateStatus(OrderStatusRequest $request, Order $order): JsonResponse
    {
        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui.',
            'status' => $order->status,
            'status_label' => $order->status_label,
            'status_color' => $order->status_color,
        ]);
    }
}
