<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{
    public function index()
    {
        $jobPositions = JobPosition::all();
        return view('job_positions.index', compact('jobPositions'));
    }

    public function create()
    {
        return view('job_positions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        JobPosition::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('job_positions.index')->with('success', 'Munkapozíció sikeresen létrehozva.');
    }

    public function show(JobPosition $jobPosition)
    {
        return view('job_positions.show', compact('jobPosition'));
    }

    public function edit(JobPosition $jobPosition)
    {
        return view('job_positions.edit', compact('jobPosition'));
    }

    public function update(Request $request, JobPosition $jobPosition)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $jobPosition->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('job_positions.index')->with('success', 'Munkapozíció sikeresen frissítve.');
    }

    public function destroy(JobPosition $jobPosition)
    {
        $jobPosition->delete();
        return redirect()->route('job_positions.index')->with('success', 'Sikeres törlés');
    }
}
