<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::where('status', '!=', 'Deleted')->get();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving users', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = User::create($request->all());
            
            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating user', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(User $user)
    {
        try {
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving user', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $user->update($request->all());
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating user', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->update(['status' => 'Deleted']);
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting user', 'error' => $e->getMessage()], 500);
        }
    }

    public function getUserStatistics()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $deletedUsers = User::where('status', 'Deleted')->count();
       
        $blockedUsers = User::where('status', 'blocked')->count();

        return response()->json([
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'deleted_users' => $deletedUsers,
            'blocked_users' => $blockedUsers,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}
