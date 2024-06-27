<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

// Open Routes
Route::post("register",[UserController::class,"register"]);
Route::post("login",[UserController::class,"login"]);

//protected middlewire
Route::group([
"middleware"=>["auth:api"]
], function(){
  Route::get("profile",[UserController::class,"profile"]);
  Route::get("logout",[UserController::class,"logout"]);
});




// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');
