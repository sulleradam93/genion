<?php

namespace App\Http\Controllers;

use App\Models\CompanyJob;
use App\Models\Company;
use App\Models\JobPosition;
use Illuminate\Http\Request;
use App\Services\AppService;

class CompanyJobController extends Controller
{
    protected $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

    public function getJobPositionsByCompanyRespJson($companyId, $type)
    {
        $jobPositions = $this->appService->getJobPositionsByCompany($companyId, $type);
        
        if ($jobPositions->isEmpty()) {
            return response()->json([], 200);
        }

        return response()->json($jobPositions);
    }

    public function getHourlySalariesByCompanyIdJobIdRespJson($companyId, $jobId)
    {
        $jobPosition = CompanyJob::select('base_salary', 'night_salary', 'weekend_salary')
            ->where('company_id', $companyId)
            ->where('job_id', $jobId)
            ->first();

        if (!$jobPosition) {
            return response()->json([], 200);
        }

        return response()->json($jobPosition);
    }

    public function index()
    {
        $companyJobs = CompanyJob::with(['company', 'jobPosition'])->get();
        return view('company_jobs.index', compact('companyJobs'));
    }

    public function create()
    {
        $companies = Company::all();
        $jobPositions = JobPosition::all();
        return view('company_jobs.create', compact('companies', 'jobPositions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'job_id' => 'required|exists:job_positions,id',
            'base_salary' => 'required|integer|min:0|max:99999999999',
            'night_salary' => 'nullable|integer|max:99999999999',
            'weekend_salary' => 'nullable|integer|max:99999999999',
        ]);

        if(empty($request->night_salary)){
            $request->night_salary = $request->base_salary;
        }

        if(empty($request->weekend_salary)){
            $request->weekend_salary = $request->base_salary;
        }

        CompanyJob::create($request->all());
        return redirect()->route('company_jobs.index');
    }

    public function show(CompanyJob $companyJob)
    {
        return view('company_jobs.show', compact('companyJob'));
    }

    public function edit(string $id)
    {
        $companies = Company::all();
        $companyJob = CompanyJob::select('company_jobs.*', 
        'companies.id as company_id',
        'companies.name as company_name',
        'job_positions.id as job_id',
        'job_positions.title as job_title')
    ->join('companies', 'companies.id', '=', 'company_jobs.company_id')
    ->join('job_positions', 'job_positions.id', '=', 'company_jobs.job_id')
    ->where('company_jobs.id', $id)
    ->first();
        $jobPositions = $jobPositions = $this->appService->getJobPositionsByCompany($companyJob->company_id, 'unrelated');
        return view('company_jobs.edit', compact('companyJob', 'companies', 'jobPositions'));
    }

    public function update(Request $request, CompanyJob $companyJob)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'job_id' => 'required|exists:job_positions,id',
            'base_salary' => 'required|integer|min:0|max:99999999999',
            'night_salary' => 'required|integer|max:99999999999',
            'weekend_salary' => 'required|integer|max:99999999999',
        ]);

        $companyJob->update([
            'company_id' => $request->company_id,
            'job_id' => $request->job_id,
            'base_salary' => $request->base_salary,
            'night_salary' => empty($request->night_salary)?$request->base_salary:$request->night_salary,
            'weekend_salary' => empty($request->weekend_salary)?$request->base_salary:$request->weekend_salary,
        ]);

        return redirect()->route('company_jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(CompanyJob $companyJob)
    {
        $companyJob->delete();
        return redirect()->route('company_jobs.index')->with('success', 'Job deleted successfully.');
    }    
}
