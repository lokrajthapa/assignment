<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\UserJob;

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


        $jobApplication = JobApplication::create([
            'title' => $request->title,
            'description' => $request->description,
            'resume' => $resumePath,
            'cover_letter' => $coverLetterPath,
        ]);
         $userJob=$jobApplication->userJob;
         $user = $userJob->user;
         $user->notify(new JobApplicationSubmitted($userJob));
         return response()->json($jobApplication, 201);
    }
}
