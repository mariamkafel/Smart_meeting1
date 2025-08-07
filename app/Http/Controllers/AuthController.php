<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash; //used for hahing the password 
use  Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth; 
class AuthController extends Controller
{

    //Regester API (formdata)
    public function register(Request $request)
    {
        $request->validate([
            "FirstName" => "required|string|max:100",
            "LastName" => "required|string|max:100",
            'Email' => 'required|email|unique:users,Email',
            "password" => "required|confirmed",
            "Role" => "required|string|max:50",
            "Department" => "required|string|max:100",
        ]);

        // Data save
        Users::create([
            "FirstName" => $request->FirstName,
            "LastName" => $request->LastName,
            "Email" => $request->Email,
            "PasswordHash" => Hash::make($request->password),
            "Role" => $request->Role,
            "Department" => $request->Department,
            "IsActive" => true, // Default to active
            "CreatedDate" => now(),
            "UpdatedDate" => now(),
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "New user created successfully"
        ], 201);
    }

    // Login API (POST, formdata)
public function login(Request $request)
{
    $credentials = $request->validate([

        'Email' => 'required|email',
        'password' => 'required'
    ]);

    // Manually verify credentials
    $user = Users::where('Email', $credentials['Email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->PasswordHash)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    // Generate token
    try {
        $token = JWTAuth::fromUser($user);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Could not create token',
            'error' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'status' => 200,
        'token' => $token,
        'user' => $user
    ]);
}

    // profile API (GET)
    public function profile() {
        $userData= Auth::user();   ;//both are helper functions
        return response()->json ([
            "status"=>200,
            "message"=>"profile data",
            "user"=>$userData
        ]);
    }

    //Refresh Token API (GET)
    public function refreshToken() {
         $newToken = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json([
            "status"=>200,
            "message"=>"New Access token generated",
            "token"=>$newToken
        ]);
    }
    // logout API (GET)
    public function logout() {
       JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            "status"=>true,
            "message"=>"user logged out successfully"
        ]);
    }
}
