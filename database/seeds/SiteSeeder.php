<?php

use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Site::truncate();
        $sites = [
            "FUGGLESTON RED",
            "WOODLEY",
            "QUEENSGATE",
            "HARTLEY WINTNEY",
            "SALISBURY",
            "FORGEWOOD",
            "AYLESFORD",
            "BRISTOL",
            "HEADLEY FIELDS",
            "EPSOM",
            "FARNHAM",
            "MERTON RISE",
            "WINKFIELD",
            "ODIHAM",
        ];
        foreach ($sites as $site)
            \App\Models\Site::create(['name' => $site]);
    }
}
