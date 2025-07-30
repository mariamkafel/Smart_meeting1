<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    // Get all users
    public function getAllUsers()
    {
        $users = Users::all();
        return response()->json($users);
    }

    // Get user by ID
    public function getUserById($id)
    {
        $user = Users::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    // Create new user
    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'FirstName' => 'required|string|max:100',
            'LastName' => 'required|string|max:100',
            'Email' => 'required|email|unique:users,Email',
            'PasswordHash' => 'required|string|max:255',
            'Role' => 'required|string|max:50',
            'Department' => 'required|string|max:100',
            'IsActive' => 'required|boolean',
            'ProfileImageUrl' => 'nullable|string|max:500',
            'LastSeenDate' => 'nullable|date',
        ]);

        $validated['CreatedDate'] = now();
        $validated['UpdatedDate'] = now();

        $newUser = Users::create($validated);
        return response()->json($newUser, 201);
    }

    // Update user
    public function updateUser(Request $request, $id)
    {
        $user = Users::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->all());
        return response()->json($user);
    }

    // Delete user

public function deleteUser($id)
{
    $deleted = DB::table('users')->where('Id', $id)->delete();

    if ($deleted === 0) {
        return response()->json(['message' => 'Delete failed or user not found'], 404);
    }

    return response()->json([
        'message' => 'Deleted directly via query',
        'status' => 200,
    ]);
}

}
