<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\UserJob;
use App\Http\Resources\ApplicationResource;


class ApplicationController extends Controller
{

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx',
            'cover_letter' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $resumePath = $request->file('resume')->store('resumes');
        $coverLetterPath = $request->file('cover_letter')->store('cover_letters');
        $userJobId=


        $jobApplication = JobApplication::create([
            'user_job_id'=>$userJobId,
            'title' => $request->title,
            'description' => $request->description,
            'resume' => $resumePath,
            'cover_letter' => $coverLetterPath,
        ]);

        $jobApplication->save();


         $userJob=$jobApplication->userJob;
         $user = $userJob->user;
         $user->notify(new JobApplicationSubmitted($jobApplication));
         return new ApplicationResource($jobApplication);

    }
}
