<?php

namespace Kartikey\PanelPulse\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Seller;
use Kartikey\PanelPulse\Models\Seller as ModelsSeller;

class SalesReportExport implements FromView
{
    protected $sellerId;

    public function __construct($sellerId)
    {
        $this->sellerId = $sellerId;
    }

    public function view(): View
    {
        $seller = ModelsSeller::find($this->sellerId);
        $data = [
            'seller' => $seller,
            'total_sales' => $seller->total_sales,
            'total_orders' => $seller->total_orders,
        ];

        return view('PanelPulse::exports.sales_report', $data);
    }
}