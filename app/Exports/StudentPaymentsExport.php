<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class StudentPaymentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('student_payments')
            ->join('students', 'student_payments.student_id', '=', 'students.id')
            ->join('student_cards', 'students.card_id', '=', 'student_cards.id')
            ->select(
                'students.name as student_name',
                'student_cards.owner_name',
                'student_cards.bank_account_number',
                'student_payments.total_salary',
                'student_payments.fulfilled',
                'student_payments.work_date'
            )
            ->where('student_payments.fulfilled', 0)
            ->orderBy('student_payments.fulfilled')
            ->orderBy('student_payments.work_date')
            ->get();
    }

    public function headings(): array
    {
        return [
            __('student_payment_xls.headings.student_name'),
            __('student_payment_xls.headings.owner_name'),
            __('student_payment_xls.headings.bank_account'),
            __('student_payment_xls.headings.amount'),
            __('student_payment_xls.headings.fulfilled'),
            __('student_payment_xls.headings.work_date'),
        ];    
    }
}
