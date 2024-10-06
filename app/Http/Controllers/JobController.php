<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        return Job::all();
    }

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

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $job->update($request->all());
        return response()->json($job, 200);
    }

    public function destroy($id)
    {
        Job::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}

