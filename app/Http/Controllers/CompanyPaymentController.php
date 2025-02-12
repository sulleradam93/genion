<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use DB;

class CompanyPaymentController extends Controller
{

    public function downloadPdf($id)
    {
        $company_payment = DB::table('company_payments')
            ->join('companies', 'company_payments.company_id', '=', 'companies.id')
            ->select('company_payments.*', 'companies.name as company_name')
            ->where('company_payments.id', $id)
            ->first();

        if (!$company_payment) {
            return redirect()->back()->with('error', 'A fizetési rekord nem található.');
        }

        $pdf = Pdf::loadView('pdf.company_payment', compact('company_payment'));

        return $pdf->download('company_payment_' . $company_payment->id . '.pdf');
    }

}
