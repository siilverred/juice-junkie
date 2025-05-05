<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        // Set default date range to current month if not specified
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();
        
        // Get summary data
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalSales = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount');
        $totalProductsSold = OrderItem::whereHas('order', function($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })->sum('quantity');
        $activeCustomers = User::where('role', 'customer')
            ->whereHas('orders', function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->count();
        
        // Get monthly sales data for chart
        $monthlySalesData = $this->getMonthlySalesData($startDate, $endDate);
        
        // Get order status data for chart
        $orderStatusData = $this->getOrderStatusData($startDate, $endDate);
        
        // Get top selling products
        $topProducts = $this->getTopProducts($startDate, $endDate);
        
        return view('admin.reports.index', compact(
            'totalOrders', 
            'totalSales', 
            'totalProductsSold', 
            'activeCustomers',
            'monthlySalesData',
            'orderStatusData',
            'topProducts',
            'startDate',
            'endDate'
        ));
    }
    
    private function getMonthlySalesData($startDate, $endDate)
    {
        // Get sales data grouped by month
        $salesByMonth = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total_amount) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();
        
        // Prepare data for chart
        $labels = [];
        $data = [];
        
        // Get all months in the date range
        $currentDate = Carbon::parse($startDate)->startOfMonth();
        $lastDate = Carbon::parse($endDate)->startOfMonth();
        
        while ($currentDate->lte($lastDate)) {
            $monthYear = $currentDate->format('M Y');
            $labels[] = $monthYear;
            
            // Find sales for this month
            $monthlySale = $salesByMonth->first(function($sale) use ($currentDate) {
                return $sale->month == $currentDate->month && $sale->year == $currentDate->year;
            });
            
            $data[] = $monthlySale ? $monthlySale->total : 0;
            
            $currentDate->addMonth();
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    private function getOrderStatusData($startDate, $endDate)
    {
        // Get orders grouped by status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->get();
        
        // Prepare data for chart
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $labels = array_map('ucfirst', $statuses);
        $data = [];
        
        foreach ($statuses as $status) {
            $statusCount = $ordersByStatus->firstWhere('status', $status);
            
            $data[] = $statusCount ? $statusCount->total : 0;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    private function getTopProducts($startDate, $endDate)
    {
        // Get top selling products
        return Product::select(
                'products.id',
                'products.name',
                'products.image',
                'products.category_id',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_sales')
            )
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name', 'products.image', 'products.category_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->with('category')
            ->get();
    }
    
    public function downloadPdf(Request $request)
    {
        // Implementasi download PDF akan ditambahkan di sini
        return redirect()->route('admin.reports.index')->with('info', 'Fitur download PDF akan segera tersedia.');
    }
    
    public function downloadExcel(Request $request)
    {
        // Implementasi download Excel akan ditambahkan di sini
        return redirect()->route('admin.reports.index')->with('info', 'Fitur download Excel akan segera tersedia.');
    }
}