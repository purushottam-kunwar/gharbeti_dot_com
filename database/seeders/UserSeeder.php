<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // find role for super admin
            $role = Role::where('name', 'super_admin')->first();

            if (isset($role->id)) {

                // run seeder to create a super admin,
                $user = User::create([
                    'name' => 'Gharbeti Super Admin',
                    'email' => 'superAdmin@gharbeti.com',
                    'password' => Hash::make('superAdmin@123'),
                    'status' => 'active',
                ]);

                // create role user
                RoleUser::create([
                    'role_id' => $role->id,
                    'user_id' => $user->id
                ]);
            }
        } catch (QueryException $e) {
            // Check for integrity constraint violation error
            $errorCode = $e->errorInfo[1];
            if ($errorCode === 1062) {
                // Duplicate entry error occurred, handle it here
                echo "User already exists. Skipping creation.\n";
            } else {
                // Other query exception occurred,
                echo "Error: " . $e->getMessage() . "\n";
            }
        }

    }
}
