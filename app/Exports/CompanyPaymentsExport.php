<?php

namespace App\Exports;

use Illuminate\Http\Request;
use DB;

class CompanyPaymentsExport
{
    public function exportXml()
    {
        $payments = DB::table('company_payments')
            ->join('companies', 'company_payments.company_id', '=', 'companies.id')
            ->select('company_payments.*', 'companies.name as company_name')
            ->get();

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><company_payments></company_payments>');

        foreach ($payments as $payment) {
            $paymentNode = $xml->addChild('payment');
            $paymentNode->addChild('company_name', $payment->company_name);
            $paymentNode->addChild('amount', $payment->total_salary);
            $paymentNode->addChild('status', $payment->fulfilled);
            $paymentNode->addChild('period', $payment->work_date);
        }

        header('Content-Type: text/xml');
        header('Content-Disposition: attachment; filename="company_payments.xml"');

        echo $xml->asXML();

        exit;
    }
}
