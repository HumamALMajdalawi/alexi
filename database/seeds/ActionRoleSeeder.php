<?php

use Illuminate\Database\Seeder;

class ActionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        \App\Models\RoleAction::truncate();
        $general = [1,
            5,
            4,
            3,
            15,
            14,
            13,
            11,
            19,
            20,
            21,
            16,
            17,
            48,
            47,
            46,
            44,
            52,
            53,
            54,
            49,
            50,
            55,
            71,
            73,
            74,
            75,
            66,
            68,
            69,
            70,
            64,
            61,
            63,
            65,
            80,
            79,
            78,
            76];
        for ($i = 1; $i <= 5; $i++) {
            foreach ($general as $action)
                \App\Models\RoleAction::create(['role_id' => $i, 'action_id' => $action]);
        }

    }
}
