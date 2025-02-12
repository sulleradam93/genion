<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('company_payment_pdf.pdf.title') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>{{ __('company_payment_pdf.pdf.title') }}</h2>
    <table>
        <tr>
            <th>{{ __('company_payment_pdf.pdf.company') }}</th>
            <td>{{ $company_payment->company_name }}</td>
        </tr>
        <tr>
            <th>{{ __('company_payment_pdf.pdf.amount') }}</th>
            <td>{{ number_format($company_payment->total_salary) }} Ft</td>
        </tr>
        <tr>
            <th>{{ __('company_payment_pdf.pdf.date') }}</th>
            <td>{{ $company_payment->work_date }}</td>
        </tr>
        <tr>
            <th>{{ __('company_payment_pdf.pdf.status') }}</th>
            <td>{{ $company_payment->fulfilled ? __('company_payment_pdf.pdf.fulfilled') : __('company_payment_pdf.pdf.pending') }}</td>
        </tr>
    </table>
</body>
</html>
