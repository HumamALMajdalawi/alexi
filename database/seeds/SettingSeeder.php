<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert([
      		'id' => 1
            ,'icon_name' => 'no_img.png'
            ,'app_name' => 'MCM'
            ,'skin' => 'blue'
            ,'owner' => 'mcmgic.com'
            ,'version' => '1.0'
            ,'per_page' => '10'
            ,'per_page_api' => '10'
            ,'datetime_format' => 'd/m/Y H:i:s'
        ]);

        $this->command->info('Settings table seeded');
/*
        DB::table('layouts')->insert(array(
            array('attribute'=>'skin','value'=>'blue'),
            array('attribute'=>'skin','value'=>'red'),
            array('attribute'=>'skin','value'=>'yellow'),
            array('attribute'=>'skin','value'=>'orange'),
            array('attribute'=>'skin','value'=>'black'),
            array('attribute'=>'skin','value'=>'pink'),
            array('attribute'=>'datetime_format','value'=>'d/m/Y H:i:s'),
            array('attribute'=>'datetime_format','value'=>'d:m:Y H:i:s')
        ));

        $this->command->info('Layout table seeded');*/
    }
}
