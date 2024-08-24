<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $year = Carbon::now()->year;
        $targetMonthlyIncome = 3500000;

        // Data untuk pendapatan bulanan
        $revenueData = DB::table('transactions')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as revenue'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('revenue', 'month')
            ->toArray();

        $revenueByMonth = array_fill(1, 12, 0);
        foreach ($revenueData as $month => $revenue) {
            $revenueByMonth[$month] = $revenue;
        }

        $currentMonth = Carbon::now()->month;
        $totalIncomeCurrentMonth = $revenueByMonth[$currentMonth];
        $percentageAchieved = $totalIncomeCurrentMonth / $targetMonthlyIncome * 100;

        // Data untuk pendapatan hari ini
        $today = Carbon::today();
        $totalIncomeToday = Transaction::whereDate('created_at', $today)
            ->sum('total_price');

        // Data untuk revenue per produk
        $productRevenue = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.uuid')
            ->select('products.image_thumbnail', 'products.name', 'products.price', DB::raw('SUM(transaction_items.sub_total) as revenue'))
            ->groupBy('products.image_thumbnail', 'products.name', 'products.price')
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                if ($item->revenue >= 1000000) {
                    $item->priority = 'High';
                } elseif ($item->revenue >= 500000) {
                    $item->priority = 'Medium';
                } else {
                    $item->priority = 'Low';
                }
                return $item;
            });

        return view('home', [
            'revenueData' => $revenueByMonth,
            'currentYear' => $year,
            'totalIncomeToday' => $totalIncomeToday,
            'targetMonthlyIncome' => $targetMonthlyIncome,
            'percentageAchieved' => $percentageAchieved,
            'productRevenue' => $productRevenue
        ]);
    }
}
