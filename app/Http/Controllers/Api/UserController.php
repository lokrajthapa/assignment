<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Post [name, email, password]
    public function register(Request $request){
        //validation
        $request->validate([
          "name"=>"required|string",
          "email"=>"required|string|email|unique:users",
          "password"=>"required|confirmed"
        ]);

       User::create(
        [
         "name"=>$request->name,
           "email"=>$request->email,
           'password' => Hash::make($request->password)
        ]
       );

       return response()->json([
          "status"=>true,
          "message"=>"User registered successfully",
          "data"=>[]
       ]);


        //user creation


    }

     //Post [email, password]
     public function login(Request $request){

        $request->validate([
                    "email"=>"required|email|string",
                    "password"=>"required"
               ]);
         //User object
        $user = User::where("email", $request->email)->first();


if(!empty($user)){
//User exists

        if(Hash::check($request->password, $user->password)){
        //   password matched
        $token = $user->createToken("mytoken")->accessToken;

        return response()->json([
            "status"=>true,
            "message"=>"login successful",
            "token"=>$token,
            "data"=>[]
        ]);
     }
                else{
                    return response()->json([
                        "status"=>false,
                        "messsage"=>"Pasword didn't match",
                        "data"=>[]
                        ]);

                }
  }
  else
  {
    return response()->json([
    "status"=>false,
    "messsage"=>"Invalid email value",
     "data"=>[]
    ]);

  }

     }
     // GET [Auth:Token]
     public function profile()
     {

    $userData=auth()->user();
      return response()->json([
        "status"=>true,
        "message"=>"Profile information",
        "data"=>$userData
      ]);

     }

       // GET [Auth:Token]
    public function logout()
    {
        $token=auth()->user()->token();
        $token->revoke();
        return response()->json([
        "status"=>true,
        "message"=>" user  logout sucessfully"
        ]);

       }
}
