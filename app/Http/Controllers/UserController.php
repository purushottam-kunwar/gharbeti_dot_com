<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /*
     * Returns the
     *  */
    public function loadUserToken()
    {
        $user = Auth::user();

        if ($user) {
            $station = $user->load('station:id,name,name_en,phone,email,website,lmbis_code,narc_code,flag', 'roles:name');
            return response()->json([
                'user' => $user
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function listUsers()
    {
        $users = User::with('roles', 'station')->get();
        if ($users) {
            return response()->json([
                'users' => $users
            ]);
        } else {
            return response()->json(['error' => 'Could Not find Users']);
        }
    }
}
