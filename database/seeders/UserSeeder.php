<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'admin',
            'title' => 'Administrador'
        ]);
        // \App\Models\User::factory(10)->create();
        $user = User::create([
            "name" => "Admin",
            "username" => "admin",
            "email" => "admin@mail.com",
            "password" => "password" //Hash::make("password")
        ]);

        $user->assignRole($role->name);
    }
}
