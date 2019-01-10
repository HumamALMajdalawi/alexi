<?php

use Illuminate\Database\Seeder;

class RateNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\RateName::truncate();
        $rates = [
            "Screed coat",
            "LVT",
            "Wide plank",
            "Thin Plank",
            "Tiles",
            "Vinyl fitting",
            "Carpet preparation",
            "Carpet fitting",
            "Full stick carpet",
            "Nosings and Stairs",
            "Wood fitting without scotia",
            "Wood fitting with scotia",
        ];

        foreach ($rates as $rate)  
            \App\Models\RateName::create(['name' => $rate]);
        
    
    }
}
