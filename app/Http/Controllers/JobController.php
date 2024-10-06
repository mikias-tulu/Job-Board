<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // Get all job postings
    public function index()
    {
        return Job::where('company_id', Auth::user()->company_id)->get();
    }

    // Store a new job posting
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'location' => 'required|string',
            'job_type' => 'required|string',
        ]);

        $job = Job::create([
            'title' => $request->title,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'company_id' => Auth::user()->company_id,
        ]);

        return response()->json($job, 201);
    }

    // Update an existing job posting
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        // Check if the job belongs to the current user's company
        if ($job->company_id !== Auth::user()->company_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $job->update($request->all());

        return response()->json($job, 200);
    }

    // Delete a job posting
    public function destroy($id)
    {
        $job = Job::findOrFail($id);

        if ($job->company_id !== Auth::user()->company_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $job->delete();

        return response()->json(null, 204);
    }
}
