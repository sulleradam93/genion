<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\StudentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use DB;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $sortField = $request->get('sort_field', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');

        $students = Student::orderBy($sortField, $sortDirection)->get();

        return view('students.index', compact('students', 'sortField', 'sortDirection'));
    }


    public function show(Student $student)
    {
        $student->load('card');
        
        return view('students.show', compact('student'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email|max:255',
            'phone' => 'required|string|max:30',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:102400',
            'owner_name' => 'required|string',
            'bank_account_number' => 'required|string'
        ]);
    
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make($request->password ?? 'default_password'),
                'role' => 'student',
            ]
        );
    
        if (!$user) {
            return redirect()->back()->with('error', 'Hiba történt a felhasználó létrehozása közben.');
        }

        if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
            $cv = $request->file('cv');
    
            $hashName = $cv->hashName();
            while (file_exists(public_path('downloads/cv/' . $hashName))) {
                $hashName = $cv->hashName();
            }
            $cv->move(public_path('downloads/cv'), $hashName);
            $cvPath = $hashName;
        } else {
            $cvPath = null;
        }
    
        $card = StudentCard::create([
            'owner_name' => $request->owner_name,
            'bank_account_number' => $request->bank_account_number
        ]);
    
        if (!$card) {
            return redirect()->back()->with('error', 'Hiba történt a bankkártya adatainak mentése közben.');
        }

        $student = Student::create([
            'user_id' => $user->id,
            'card_id' => $card->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'gender' => $request->gender,
            'cv' => $cvPath,
        ]);
    
        if (!$student) {
            return redirect()->back()->with('error', 'Hiba történt a diák létrehozása közben.');
        }
    
        return redirect()->route('students.index')->with('success', 'Sikeres mentés');
    }
    
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('students')->ignore($id),
            ],
            'phone' => 'required|string|max:15',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:102400',
            'owner_name' => 'nullable|string',
            'bank_account_number' => 'nullable|string'
        ]);

        $student = Student::findOrFail($id);
        $user = User::findOrFail($student->user_id);

        if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
            $cv = $request->file('cv');
            $hashName = $cv->hashName();

            while (file_exists(public_path('downloads/cv/' . $hashName))) {
                $hashName = $cv->hashName();
            }

            $cv->move(public_path('downloads/cv'), $hashName);
            $cvPath = $hashName;
        } else {
            $cvPath = $student->cv;
        }

        $studentUpdated = $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'gender' => $request->gender,
            'cv' => $cvPath,
        ]);

        $userUpdated = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->has('owner_name') || $request->has('bank_account_number')) {
            $studentCard = $student->card;
    
            if ($studentCard) {
                $studentCardUpdated = $studentCard->update([
                    'owner_name' => $request->owner_name,
                    'bank_account_number' => $request->bank_account_number,
                ]);
    
                if (!$studentCardUpdated) {
                    return redirect()->back()->with('error', 'Hiba történt a kártyaadatok frissítése során.');
                }
            } else {
                return redirect()->back()->with('error', 'Nem található a kapcsolódó diák kártya.');
            }
        }

        if (!$studentUpdated || !$userUpdated) {
            return redirect()->back()->with('error', 'Hiba történt a diák adatainak frissítése során.');
        }

        return redirect()->route('students.index')->with('success', 'Diák sikeresen frissítve.');
    }



    public function destroy(Student $student)
    {
        if ($student->cv) {
            Storage::disk('public')->delete($student->cv);
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Diák sikeresen törölve.');
    }

    public function student_payments()
    {
        $student_payments = DB::table('student_payments')
            ->join('students', 'student_payments.student_id', '=', 'students.id')
            ->join('student_cards', 'students.card_id', '=', 'student_cards.id')
            ->select(
                'student_payments.*', 
                'student_cards.*', 
                'students.name as student_name'
            )
            ->orderBy('student_payments.fulfilled')
            ->orderBy('student_payments.work_date')
            ->get();

        return view('student_payments.index', compact('student_payments'));
    }
    
    public function current_student_payments()
    {
        $userId = Auth::id();

        $student_payments = DB::table('student_payments')
            ->join('students', 'student_payments.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('student_cards', 'students.card_id', '=', 'student_cards.id')
            ->where('users.id', $userId)
            ->select(
                'student_payments.*', 
                'student_cards.*', 
                'students.name as student_name', 
                'users.email as student_email'
            )
            ->get();

        return view('current_student_payments.index', compact('student_payments'));
    }

    public function change_paid($id)
    {
        DB::table('student_payments')
            ->where('id', $id)
            ->update(['fulfilled' => 1]);
    
        $student_payments = DB::table('student_payments')->get();
        
        return redirect()->route('student_payments.index');
    }
    
    public function change_not_paid($id)
    {
        DB::table('student_payments')
            ->where('id', $id)
            ->update(['fulfilled' => 0]);
    
        $student_payments = DB::table('student_payments')->get();
        
        return redirect()->route('student_payments.index');
    }
}
