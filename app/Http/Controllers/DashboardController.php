<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesOrder;

class DashboardController extends Controller
{


public function index()
{
    $totalSalesAmount = SalesOrder::sum('total');
    $totalOrders = SalesOrder::count();
    $lowStockProducts = Product::where('quantity', '<', 5)->get(); // threshold can be changed

    return view('dashboard', compact(
        'totalSalesAmount',
        'totalOrders',
        'lowStockProducts'
    ));
}

}
