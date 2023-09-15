<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required'],
        ]);

        $role = Role::find($validatedData['role']);
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ];

        if ($role) {
            $user = User::create($userData);
            if ($user) {
                RoleUser::create([
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                ]);

                return response()->json([
                    'user' => $user,
                    'message' => "User Created Successfully",
                ], 200);
            } else {
                return response()->json(['error' => 'User Could not be created'], 401);
            }
        } else {
            return response()->json(['error' => 'Invalid role'], 404);
        }

    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $credentials = $request->all();
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->status == 'active') {
                $token = $user->createToken('Login Token')->accessToken;

                // You can add custom logic to handle roles here
                $roles = $user->roles()->pluck('name')->toArray();
                $userDetails = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'token' => $token,
                    'roles' => $roles,
                ];
            } else {
                return response()->json(['error' => 'Cannot Log in! User is not active.'], 403);
            }

            return response()->json([
                'item' => $userDetails,
            ]);
        }

        return response()->json(['error' => 'Incorrect Email or Password'], 401);
    }
}
