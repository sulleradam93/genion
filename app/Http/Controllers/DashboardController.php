<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            return redirect()->route('students.index');
        } elseif ($user->hasRole('company')) {
            return redirect()->route('company_payments.current_company_payments');
        } elseif ($user->hasRole('student')) {
            return redirect()->route('student_payments.current_student_payments');
        }

        return abort(403, 'Nincs jogosultságod az oldal megtekintéséhez.');
    }
}
