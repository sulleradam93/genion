<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyJobController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('job-positions/{companyId}/{type}', [CompanyJobController::class, 'getJobPositionsByCompanyRespJson']);
Route::get('hourlysalaries/{companyId}/{jobId}', [CompanyJobController::class, 'getHourlySalariesByCompanyIdJobIdRespJson']);
