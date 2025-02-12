<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);
    
        $new_company = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('g6Htr7Ja9_v1kddg2'),
            'phone' => $request->phone,
            'role' => 'company'
        ]);
    
        if (!$new_company) {
            return redirect()->back()->with('error', 'A felhasználó létrehozása sikertelen.');
        }
    
        $company = Company::create([
            'user_id' => $new_company->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
    
        if (!$company) {
            $new_company->delete();
            return redirect()->back()->with('error', 'A cég létrehozása sikertelen.');
        }
    
        return redirect()->route('companies.index')->with('success', 'Cég sikeresen létrehozva.');
    }
    

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('companies')->ignore($id),
            ],
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        $company = Company::findOrFail($id);
        $user = $company->user;

        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('companies.index')->with('success', 'Cég sikeresen frissítve.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Cég sikeresen törölve.');
    }

    public function company_payments()
    {
        $company_payments = DB::table('company_payments')
            ->join('companies', 'company_payments.company_id', '=', 'companies.id')
            ->select(
                'company_payments.*', 
                'companies.name as company_name'
            )
            ->orderBy('company_payments.fulfilled')
            ->orderBy('company_payments.work_date')
            ->get();

        
        return view('company_payments.index', compact('company_payments'));
    }

    public function current_company_payments()
    {
        $userId = Auth::id();

        $company_payments = DB::table('company_payments')
            ->join('companies', 'company_payments.company_id', '=', 'companies.id')
            ->join('users', 'companies.user_id', '=', 'users.id')
            ->where('users.id', $userId)
            ->select(
                'company_payments.*', 
                'companies.name as company_name', 
                'users.email as company_email'
            )
            ->get();

        return view('current_company_payments.index', compact('company_payments'));
    }


    public function change_paid($id)
    {
        DB::table('company_payments')
            ->where('id', $id)
            ->update(['fulfilled' => 1]);
    
        $company_payments = DB::table('company_payments')->get();
        
        return redirect()->route('company_payments.index');
    }
    
    public function change_not_paid($id)
    {
        DB::table('company_payments')
            ->where('id', $id)
            ->update(['fulfilled' => 0]);

        $company_payments = DB::table('company_payments')->get();
        
        return redirect()->route('company_payments.index');
    }
    
}
