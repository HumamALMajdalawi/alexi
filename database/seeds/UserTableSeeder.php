<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    public function run()
    {
//        \App\Models\User::truncate();
        $role_developer = Role::where('name', 'Developer')->first();
        $role_superadmin = Role::where('name', 'Superadmin')->first();
        /*$developer = new User();
        $developer->name = 'Developer Name';
        $developer->email = 'developer@example.com';
        $developer->password = bcrypt('secret');
        $developer->save();
        $developer->roles()->attach($role_developer);
        $superadmin = new User();
        $superadmin->name = 'superadmin Name';
        $superadmin->email = 'superadmin@example.com';
        $superadmin->password = bcrypt('secret');
        $superadmin->save();
        $superadmin->roles()->attach($role_superadmin);*/
    }
}
