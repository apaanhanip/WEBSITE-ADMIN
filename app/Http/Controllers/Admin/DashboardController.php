<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockItem;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'revenue' => Purchase::where('status', 'completed')->sum('total'),
            'orders' => Purchase::count(),
            'users' => User::count(),
            'products' => Product::count(),
            'topup' => WalletTransaction::where('type', 'topup')->where('status', 'success')->sum('amount'),
            'stock' => StockItem::where('status', 'available')->count(),
        ];

        $recentOrders = Purchase::with('user')->latest()->limit(8)->get();

        $lowStock = Product::where('is_active', true)
            ->where('delivery_type', 'auto_stock')
            ->withCount(['stockItems as available' => fn ($q) => $q->where('status', 'available')])
            ->orderBy('available')
            ->limit(6)
            ->get();

        // Last 7 days sales chart
        $days = collect(range(6, 0))->map(fn ($i) => Carbon::today()->subDays($i));
        $salesByDay = Purchase::where('status', 'completed')
            ->where('created_at', '>=', Carbon::today()->subDays(6))
            ->get()
            ->groupBy(fn ($p) => $p->created_at->toDateString());

        $chart = [
            'labels' => $days->map(fn ($d) => $d->format('d/m'))->values(),
            'data' => $days->map(fn ($d) => (float) ($salesByDay->get($d->toDateString())?->sum('total') ?? 0))->values(),
        ];

        $topProducts = Product::orderByDesc('sold_count')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStock', 'chart', 'topProducts'));
    }
}
