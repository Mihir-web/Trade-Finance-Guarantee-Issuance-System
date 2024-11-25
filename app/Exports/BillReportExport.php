<?php
namespace App\Exports;

use App\Http\Controllers\BillsController;
use App\Models\bills;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BillReportExport implements FromView
{
    protected $request = [];

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $filter = $this->request;
        unset($filter['token']);
        
            $bills = bills::with('user')->get();
      
        

        return view('bills.export_excel', [
            'bills' => $bills
        ]);
    }
}