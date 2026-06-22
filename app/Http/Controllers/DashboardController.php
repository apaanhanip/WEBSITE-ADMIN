<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMenu = Menu::count();
        $totalCategory = Category::count();
        $totalOrder = Order::count();
        $totalTransaction = Transaction::count();
        $totalRevenue = Transaction::sum('amount');

        $recentOrders = Order::with('items')
            ->latest()
            ->take(8)
            ->get();

        $orderStatusSummary = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $weeklySales = $this->getWeeklySalesChart();

        $topMenus = DB::table('order_items')
            ->select('menu_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->groupBy('menu_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalMenu',
            'totalCategory',
            'totalOrder',
            'totalTransaction',
            'totalRevenue',
            'recentOrders',
            'orderStatusSummary',
            'weeklySales',
            'topMenus'
        ));
    }

    protected function getWeeklySalesChart(): array
    {
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $labels = [];
        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $labels[] = $date->translatedFormat('D, d M');

            $amount = Transaction::whereDate('transaction_date', $date->toDateString())->sum('amount');
            $data[] = (float) $amount;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
