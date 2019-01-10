<?php

use Illuminate\Database\Seeder;

use App\Models\CompanyRates;

class company_rates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \App\Models\CompanyRates::truncate();

        $arr = [['type'=>'Carpet',
            'prices'=>['preparation'=>1,'installation'=>2,'protection'=>3,'Additions'=>4]],
            ['type'=>'Underlay',
            'prices'=>[ "some of strings"]],
            ['type'=>'Matwell',
            'prices'=>['Standard'=>5,'Protection'=>6,'Additions'=>7]],
            ['type'=>'DPM',
            'prices'=>['Standard'=>8,'Additions'=>9]],
            ['type'=>'LVT',
            'prices'=>['DPM'=>10,'Screed'=>11,'Plyboarding'=>12,'LVT1'=>13,'LVT2'=>14,'LVT3'=>15,'Protection'=>16,'Additions'=>17]],
            ['type'=>'Vinyl tiles',
            'prices'=>['DPM'=>18,'Screed'=>19,'Plyboarding'=>20,'LVT Installation'=>21,'Protection'=>22,'Additions'=>23]],
            ['type'=>'Screed',
            'prices'=>['Standard'=>24,'Additions'=>25]],
            ['type'=>'Domestic vinyl',
            'prices'=>['DPM'=>26,'Screed'=>27,'Plyboard'=>28,'Installation'=>29,'Protection'=>30,'Additions'=>31]],
            ['type'=>'Safety flooring',
            'prices'=>['DPM'=>32,'Screed'=>33,'Plyboard'=>34,'Installation'=>35,'Protection'=>36,
               'Additions'=>37]],
            ['type'=>'CAP and Cove',
            'prices'=>['Standard'=>38,'Additions'=>39]],
            ['type'=>'Wood',
            'prices'=>['DPM'=>40,'Screed'=>41,'Plyboard'=>42,'Installation'=>43,'Scotia'=>44,'Protection'=>45,
               'Additions'=>46]],
            ['type'=>'Laminate',
                'prices'=>['DPM'=>47,'Screed'=>48,'Plyboard'=>49,'Installation'=>50,'Scotia'=>51,'Protection'=>52,
                    'Additionals'=>53]],
            ['type'=>'Communal carpet',
                'prices'=>['Screed'=>54,'Plyboard'=>55,'Installation'=>56,'Protection'=>57
                    ,'Additionals'=>58]],
            ['type'=>'Nosings',
                'prices'=>['Standard'=>59,'Additions'=>60]],
            ];

            foreach ($arr as $a){
                CompanyRates::create(['type'=>$a['type'],'prices'=>json_encode($a['prices'])]);


            }
     //   \Illuminate\Support\Facades\DB::table('company_rates')->insert(implode(',',$arr));
    }

}
