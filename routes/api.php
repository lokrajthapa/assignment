<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserJobController;


// Open Routes
Route::post("register",[UserController::class,"register"]);
Route::post("login",[UserController::class,"login"]);

//protected middlewire
Route::group([
"middleware"=>["auth:api"]
], function(){
  Route::get("profile",[UserController::class,"profile"]);
  Route::get("logout",[UserController::class,"logout"]);

  //jobs
  Route::post('jobs', [UserJobController::class, 'store']);
  Route::get('/jobs', [UserJobController::class, 'index']);
  Route::put('/job/{userJob}', [UserJobController::class, 'update']);
  Route::delete('/job/{userJob}', [UserJobController::class, 'destroy']);
});




// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');
