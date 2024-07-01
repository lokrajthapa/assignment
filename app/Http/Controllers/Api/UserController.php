<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
/**
*    @OA\info(
*    title="laravel password api",
*     version="1.0.0"
*   )
*/

class UserController extends Controller
{
    //Post [name, email, password]

    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Register a new user",
     *     description="Register a new user with the given details.",
     *     tags={"Register"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "role", "user_type", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="role", type="string", example="Admin"),
     *             @OA\Property(property="user_type", type="string", example="standard"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="strongpassword")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="role", type="string", example="Admin"),
     *                 @OA\Property(property="user_type", type="string", example="standard"),
     *                 @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2023-06-30T12:34:56Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2023-06-30T12:34:56Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation error message")
     *         )
     *     )
     * )
     */

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
         "role"=>$request->role,
         "user_type"=>$request->user_type,
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
