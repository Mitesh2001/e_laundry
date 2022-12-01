<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $services = (new ServiceRepository())->getAll();
        $products = (new ProductRepository())->getAll();
        $income = (new OrderRepository())->getByStatus('Completed')->sum('amount');
        $revenues = (new OrderRepository())->getRevenueReportByBetweenDate(
            now()->format('Y-m-d'),
            now()->addDay(1)->format('Y-m-d')
        );

        $confirmOrder = (new OrderRepository())->getByStatus('Order confirmed')->count();
        $completeOrder = (new OrderRepository())->getByStatus('Delivered')->count();
        $pendingOrder = (new OrderRepository())->getByStatus('Pending')->count();
        $onPregressOrder = (new OrderRepository())->getByStatus('Processing')->count();
        $cancelledOrder = (new OrderRepository())->getByStatus('Cancelled')->count();


        return view('dashboard.index', compact(
            'customers', 'services', 'products', 'revenues', 'income', 'confirmOrder', 'completeOrder', 'pendingOrder', 'onPregressOrder', 'cancelledOrder'
        ));
    }
}
