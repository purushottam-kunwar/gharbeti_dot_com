<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin'],
            ['name' => 'admin'],
            ['name' => 'gharbeti'],
            ['name' => 'user'],
        ];
        foreach ($roles as $role) {
            $roleData = Role::where('name', $role['name'])->first();
            if (!isset($roleData->id)) {
                Role::create($role);
            }
        }
    }
}
