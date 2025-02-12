<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobPositionController;
use App\Http\Controllers\CompanyJobController;
use App\Http\Controllers\WorkRecordController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CompanyPaymentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Exports\StudentPaymentsExport;
use App\Exports\CompanyPaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('change', [LanguageController::class, 'change'])->name("lang.change");
});

Route::get('/', function () {
    return redirect()->route('dashboard.index');
})->name('home');

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('job_positions', JobPositionController::class);
    Route::resource('company_jobs', CompanyJobController::class);
    Route::resource('work_records', WorkRecordController::class);
    Route::resource('managers', ManagerController::class);
    Route::get('company_payments', [CompanyController::class, 'company_payments'])->name('company_payments.index');
    Route::patch('company_payments/change_paid/{id}', [CompanyController::class, 'change_paid'])->name('company_payments.change_paid');
    Route::patch('company_payments/change_not_paid/{id}', [CompanyController::class, 'change_not_paid'])->name('company_payments.change_not_paid');
    Route::get('student_payments', [StudentController::class, 'student_payments'])->name('student_payments.index');
    Route::patch('student_payments/change_paid/{id}', [StudentController::class, 'change_paid'])->name('student_payments.change_paid');
    Route::patch('student_payments/change_not_paid/{id}', [StudentController::class, 'change_not_paid'])->name('student_payments.change_not_paid');
    Route::get('/export-student-payments', function () {
        return Excel::download(new StudentPaymentsExport, 'student_payments.xlsx');
    });
    Route::get('company_payments/pdf/{id}', [CompanyPaymentController::class, 'downloadPdf'])
    ->name('company_payments.pdf');
    Route::get('/export-company-payments', [CompanyPaymentsExport::class, 'exportXml'])->name('company_payments.exportXml');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('managers', ManagerController::class);
});

Route::middleware(['auth', 'role:company'])->group(function () {
    Route::get('company/payments', [CompanyController::class, 'current_company_payments'])->name('company_payments.current_company_payments');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('student/payments', [StudentController::class, 'current_student_payments'])->name('student_payments.current_student_payments');
});

Route::get('/register', function () {
    abort(404);
});
Route::post('/register', function () {
    abort(404);
});

require __DIR__.'/auth.php';
