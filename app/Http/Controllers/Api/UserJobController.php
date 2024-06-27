<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserJob;
use Illuminate\Support\Facades\Gate;

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

        $userJob = new UserJob($request->all());
        $userJob->user_id = auth()->user()->id;
        $userJob->save();

        return response()->json($job, 201);
    }

    public function index(Request $request)
    {
        //exporting from relation
        // $userJobs = auth()->user()->userJobs;

        $query = UserJob::query();

        if ($request->has('keywords')) {
            $keywords = $request->input('keywords');
            $query->where(function ($q) use ($keywords) {
                $q->where('location', 'LIKE', "%{$keywords}%")
                  ->orWhere('company', 'LIKE', "%{$keywords}%");
            });
        }
        $userJobs = $query->paginate(10);

        return response()->json($userJobs, 200);
    }






       // return response()->json(["jobs"=>$userJobs]);


    public function update(Request $request, UserJob $userJob)
    {

        Gate::authorize('update', $userJob);

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

    public function destroy(UserJob $userJob)
    {

        Gate::authorize('delete', $userJob);

        $userJob->delete();

        return response()->json(null, 204);
    }



}
