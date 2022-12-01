<?php

namespace App\Http\Controllers\Web\Revenues;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    private $orderRepo;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepo = $orderRepository;
    }

    public function index()
    {
        return view('revenues.index', [
            'revenues' => $this->orderRepo->getRevenueReportByBetweenDate(\request('from'), \request('to'))
                
        ]);
    }

    public function generatePDF()
    {
        $dateparse = Carbon::parse(request('filter_date')) ?? now();
        $dateFilter = $dateparse->format('M d, Y');
        if (request('filter') == 'month') {
            $dateFilter = $dateparse->format('M, Y');
        } elseif (request('filter') == 'year') {
            $dateFilter = $dateparse->format('Y');
        }

        $revenues = $this->orderRepo
            ->getRevenueReportByBetweenDate(\request('from'), \request('to'));
        $pdf = PDF::loadView('pdf.generate-revenue', [
            'revenues' => $revenues,
            'dateFilter' => $dateFilter
        ])->setPaper('a4', 'portrait');

        return $pdf->stream($dateFilter . '_incomes_' . now()->format('H-i-s') . '.pdf');

    }
}
