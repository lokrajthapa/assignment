<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserJobController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'company' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'application_instructions' => 'required|string',
        ]);

        $job = new UserJob($request->all());
        $job->user_id = auth()->user()->id;
        $job->save();

        return response()->json($job, 201);
    }

    public function index()
    {
        //exporting from relation
         $jobs = auth()->user()->userJobs;

        return response()->json(["jobs"=>$jobs]);
    }

    public function update(Request $request, UserJob $userJob)
    {
        $this->authorize('update', $userJob);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'company' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'application_instructions' => 'sometimes|required|string',
        ]);

        $userJob->update($request->all());

        return response()->json($userJob, 200);
    }

    public function destroy(UserJob $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return response()->json(null, 204);
    }



}
