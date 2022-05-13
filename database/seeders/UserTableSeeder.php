<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->code = 'user-code-1234';
        $user->name = 'User Emon';
        $user->email = 'user@emon.com';
        $user->password = 'password';
        $user->level = 'user';
        $user->save();

        $admin = new User();
        $admin->code = 'admin-code-1234';
        $admin->name = 'Admin Emon';
        $admin->email = 'admin@emon.com';
        $admin->password = 'password';
        $admin->level = 'admin';
        $admin->save();

        $coordinator = new User();
        $coordinator->code = 'coordinator-code-1234';
        $coordinator->name = 'Coordinator Emon';
        $coordinator->email = 'coordinator@emon.com';
        $coordinator->password = 'password';
        $coordinator->level = 'coordinator';
        $coordinator->save();
    }
}
