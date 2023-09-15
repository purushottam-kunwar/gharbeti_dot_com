<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class LoginController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8', 'confirmed'],
                'bio' => 'nullable',
                'date_of_birth' => 'required|string',
                'gender' => 'required|string',
                'contact_info' => 'nullable|string',
                'province' => 'required|string',
                'district' => 'required|string',
                'local_body' => 'required|string',
                'ward_no' => 'required|string',
                'tole_or_village' => 'nullable|string',
                'house_no' => 'nullable|string',
                'role' => ['required'],
            ]);

            $role = Role::find($validatedData['role']);
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (isset($role['id'])) {
                $user = User::create($userData);
                if (isset($user['id'])) {

                    // create role user
                    $roleUserParams = [
                        'user_id' => $user->id,
                        'role_id' => $role->id,
                    ];

                    $roleUser = RoleUser::create($roleUserParams);
                    if (isset($roleUser['id'])) {

                        // create user address
                        $addressParams = [
                            'province' => $request->province,
                            'district' => $request->district,
                            'local_body' => $request->local_body,
                            'tole_or_village' => $request->tole_or_village,
                            'ward_no' => $request->ward_no,
                            'house_no' => $request->house_no,
                            'remarks' => $request->remarks,
                            'user_id' => $user->id,
                        ];

                        $address = Address::create($addressParams);

                        if (isset($address['id'])) {

                            // create user_profile
                            $userProfileParams = [
                                'bio' => $request->bio,
                                'date_of_birth' => $request->date_of_birth,
                                'gender' => $request->gender,
                                'contact_info' => $request->contact_info,
                                'status' => $request->status,
                                'role_id' => $role->id,
                                'user_id' => $user->id,
                                'address_id' => $address->id,
                            ];

                            $userProfile = UserProfile::create($userProfileParams);
                            if (isset($userProfile['id'])) {
                                DB::commit();
                                $response["code"] = 200;
                                $response["status"] = "success";
                                $response["message"] = 'User Created Successfully';
                                $response["data"] = $userProfile;
                            } else {
                                DB::rollBack();
                                $response["code"] = 400;
                                $response["status"] = "error";
                                $response["message"] = "Failed to create user profile";
                            }
                        } else {
                            DB::rollBack();
                            $response["code"] = 400;
                            $response["status"] = "error";
                            $response["message"] = "Failed to create address";
                        }

                    } else {
                        DB::rollBack();
                        $response["code"] = 400;
                        $response["status"] = "error";
                        $response["message"] = "Failed to create role user";
                    }
                } else {
                    DB::rollBack();
                    $response["code"] = 400;
                    $response["status"] = "error";
                    $response["message"] = "Failed to create user";
                }
            } else {
                DB::rollBack();
                $response["code"] = 400;
                $response["status"] = "error";
                $response["message"] = "Role can not find";
            }
        } catch (Exception $error) {
            DB::rollBack();
            $response["code"] = 400;
            $response["status"] = "error";
            $response["message"] = $error->getMessage() . "=====" . $error->getLine();
        }
        return response()->json($response, $response["code"]);
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
