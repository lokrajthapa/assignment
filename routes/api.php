<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserJobController;
use App\Http\Controllers\Api\ApplicationController;


// Open Routes
Route::post("register",[UserController::class,"register"])->name('user.register');
Route::post("login",[UserController::class,"login"])->name('user.login');

//job search for all user //  testdone
Route::get('/alljobs', [UserJobController::class, 'alljobs']);




//protected middlewire
Route::group([
"middleware"=>["auth:api"]
], function(){
//   Route::get("profile",[UserController::class,"profile"]);
  Route::get("logout",[UserController::class,"logout"])->name('user.logout');

  //jobs   //test done
  Route::post('jobs', [UserJobController::class, 'store'])->name('jobs.store');
  Route::get('/jobs', [UserJobController::class, 'index'])->name('jobs.index');
  Route::put('/job/{userJob}', [UserJobController::class, 'update'])->name('job.update');
  Route::delete('/job/{userJob}', [UserJobController::class, 'destroy'])->name('job.delete');

  //for all submission job and approval
   Route::get('/allJobSubmissions', [UserJobController::class, 'jobSubmissions'])->name('allsubmittedJob');
   Route::put('/updateJobStatus/{userJob}',[UserJobController::class, 'updateJobStatus'])->name('updateJobStatus');

   //for job seeker   //testdone
    Route::post('/submitApplication',[ApplicationController::class,'store'])->name('submitJobApplication');



});







// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

// Route::get('/testing',function(){
//     return view('testing');
// });
