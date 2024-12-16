<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;

class ReportContoller extends Controller
{
    public function index()
    {
        $ordersTotal = Order::sum('total_price');
        $menuTotal = Menu::count();
        $ordersCount = Order::count();
        $customersCount = Order::distinct('customer_id')->count('customer_id');
        $total = ['orders' => $ordersTotal, 'menu' => $menuTotal, 'ordersCount' => $ordersCount, 'customersCount' => $customersCount];
        return view('admin.reports.index', [
            'summary' => $total,
        ]);
    }
}
