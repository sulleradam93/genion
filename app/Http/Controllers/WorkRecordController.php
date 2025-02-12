<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkRecord;
use App\Models\Student;
use App\Models\Company;
use App\Models\CompanyJob;
use App\Models\JobPosition;
use App\Services\AppService;

class WorkRecordController extends Controller
{
    protected $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

    public function index()
    {
        //$workRecords->load(['student', 'companyJob.company', 'companyJob.jobPosition']);

        $workRecords = WorkRecord::select('work_records.*', 
        'students.name as student_name',
        'companies.name as company_name',
        'job_positions.title as job_title')
        ->join('students', 'students.id', '=', 'work_records.student_id')
        ->join('company_jobs', 'company_jobs.id', '=', 'work_records.company_job_id')
        ->join('companies', 'companies.id', '=', 'company_jobs.company_id')
        ->join('job_positions', 'job_positions.id', '=', 'company_jobs.job_id')
        ->orderBy('work_records.id', 'asc')
        ->get();
        
        return view('work_records.index', compact('workRecords'));
    }

    public function create()
    {
        $students = Student::all();
        $companies = Company::all();
        $jobPositions = JobPosition::all();
        return view('work_records.create', compact('students', 'companies', 'jobPositions'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'company_id' => 'required|exists:companies,id',
            'job_id' => 'required|exists:job_positions,id',
            'work_date_begin' => 'required|date',
            'work_date_end' => 'required|date',
            'base_hours' => 'required|numeric|min:0|max:24',
            'base_salary' => 'required|numeric|max:99999999999',
            'night_hours' => 'required|numeric|max:24',
            'night_salary' => 'required|numeric|max:99999999999',
            'weekend_hours' => 'required|numeric|max:24',
            'weekend_salary' => 'required|numeric|max:99999999999',
            'total_salary' => 'required|numeric|max:99999999999',
            'comment' => 'nullable|string|max:255',
        ]);

        $companyJob = CompanyJob::where('company_id', $request->company_id)
                                ->where('job_id', $request->job_id)
                                ->first();

        if (!$companyJob) {
            return back()->withErrors(['error' => 'Nem található a megadott cég és munkakör kombináció']);
        }

        $validatedData['company_job_id'] = $companyJob->id;

        $data_salaries = [
            'base_hours' => $request->base_hours,
            'base_salary' => $request->base_salary,
            'night_hours' => $request->night_hours,
            'night_salary' => $request->night_salary,
            'weekend_hours' => $request->weekend_hours,
            'weekend_salary' => $request->weekend_salary
        ];

        $validatedData['calculated'] = json_encode($data_salaries);
                
        WorkRecord::create($validatedData);

        return redirect()->route('work_records.index')->with('success', 'Sikeres mentés');
    }

    public function show(string $id)
    {
        $workRecord = WorkRecord::select('work_records.*', 
        'students.name as student_name',
        'companies.name as company_name',
        'job_positions.title as job_title')
    ->join('students', 'students.id', '=', 'work_records.student_id')
    ->join('company_jobs', 'company_jobs.id', '=', 'work_records.company_job_id')
    ->join('companies', 'companies.id', '=', 'company_jobs.company_id')
    ->join('job_positions', 'job_positions.id', '=', 'company_jobs.job_id')->where('work_records.id', $id)
    ->first();
        return view('work_records.show', compact('workRecord'));
    }
    
    public function edit(string $id)
    {
        $workRecord = WorkRecord::select('work_records.*', 
        'students.id as student_id',
        'students.name as student_name',
        'companies.id as company_id',
        'companies.name as company_name',
        'job_positions.id as job_id',
        'job_positions.title as job_title')
        ->join('students', 'students.id', '=', 'work_records.student_id')
        ->join('company_jobs', 'company_jobs.id', '=', 'work_records.company_job_id')
        ->join('companies', 'companies.id', '=', 'company_jobs.company_id')
        ->join('job_positions', 'job_positions.id', '=', 'company_jobs.job_id')
        ->where('work_records.id', $id)
        ->first();

        $students = Student::all();
        $companies = Company::all();
        $jobPositions = $this->appService->getJobPositionsByCompany($workRecord->company_id, 'related');

        $calculated = json_decode($workRecord->calculated, true);

        $workRecord->base_hours = $calculated['base_hours'] ?? null;
        $workRecord->base_salary = $calculated['base_salary'] ?? null;
        $workRecord->night_hours = $calculated['night_hours'] ?? null;
        $workRecord->night_salary = $calculated['night_salary'] ?? null;
        $workRecord->weekend_hours = $calculated['weekend_hours'] ?? null;
        $workRecord->weekend_salary = $calculated['weekend_salary'] ?? null;

        return view('work_records.edit', compact(
            'workRecord', 
            'students', 
            'companies', 
            'jobPositions'
        ));
    }

    public function update(Request $request, WorkRecord $workRecord)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'company_id' => 'required|exists:companies,id',
            'job_id' => 'required|exists:job_positions,id',
            'work_date_begin' => 'required|date',
            'work_date_end' => 'required|date',
            'base_hours' => 'required|numeric|min:0|max:24',
            'base_salary' => 'required|numeric|max:99999999999',
            'night_hours' => 'required|numeric|max:24',
            'night_salary' => 'required|numeric|max:99999999999',
            'weekend_hours' => 'required|numeric|max:24',
            'weekend_salary' => 'required|numeric|max:99999999999',
            'total_salary' => 'required|numeric|max:99999999999',
            'comment' => 'nullable|string|max:255',
        ]);
        
        $companyJob = CompanyJob::where('company_id', $request->company_id)
                                ->where('job_id', $request->job_id)
                                ->first();

        if (!$companyJob) {
            return back()->withErrors(['error' => 'Nem található a megadott cég és munkakör kombináció']);
        }
        
        $validatedData['company_job_id'] = $companyJob->id;
        
        $data_salaries = [
            'base_hours' => $request->base_hours,
            'base_salary' => $request->base_salary,
            'night_hours' => $request->night_hours,
            'night_salary' => $request->night_salary,
            'weekend_hours' => $request->weekend_hours,
            'weekend_salary' => $request->weekend_salary
        ];

        $validatedData['calculated'] = json_encode($data_salaries);

        $workRecord->update($validatedData);

        return redirect()->route('work_records.index')->with('success', 'Sikeres frissítés');
    }

    public function destroy(string $id)
    {
        $workRecord = WorkRecord::findOrFail($id);
        $workRecord->delete();

        return redirect()->route('work_records.index')->with('success', 'Sikeres törlés');
    }
}
