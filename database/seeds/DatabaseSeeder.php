<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //$this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
//          $this->call(UserTableSeeder::class);
//          $this->call(LookupSeeder::class);
//          $this->call(SettingSeeder::class);
        $this->call(ActionsSeeder::class);
        $this->call(ActionRoleSeeder::class);
    //    $this->call(SiteSeeder::class);
        $this->call(RateNameTableSeeder::class);
         $this->call(company_rates::class);

    }
}
