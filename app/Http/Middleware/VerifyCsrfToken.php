<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class VerifyCsrfToken
{
    protected $except = [
        'students',
        'companies',
        'job_positions',
        'company_jobs',
        'work_records',
        'company_payments',
        'student_payments',
        'managers',
    ];
}    