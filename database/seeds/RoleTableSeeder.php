<?php

use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Role::truncate();
        $role_employee = new Role();
        $role_employee->name = 'Superadmin';
        $role_employee->description = 'Super admin';
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = 'Admin';
        $role_manager->description = 'Admin';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Branch admin';
        $role_manager->description = 'Branch admin';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'General staff';
        $role_manager->description = 'General staff';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Developer';
        $role_manager->description = 'Developer';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Fitter';
        $role_manager->description = 'Fitter';
        $role_manager->save();

    }
}
