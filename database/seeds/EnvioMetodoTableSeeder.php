<?php

use Illuminate\Database\Seeder;

class EnvioMetodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metodos_envio = array(

            array(
              'coin_id' => 1,
              'cost' => 140.00,
              'name_es' => '1 día República Mexicana',
              'name_en' => null,
              'description_es' => '1 día hábiles en toda la república mexicana',
              'description_en' => null,
              'ordering' => 1
            ),
            array(
              'coin_id' => 1,
              'cost' => 90.00,
              'name_es' => '2 días República Mexicana',
              'name_en' => null,
              'description_es' => '2 días hábiles en toda la república mexicana',
              'description_en' => null,
              'ordering' => 2
            ),
            array(
              'coin_id' => 1,
              'cost' => 0.00,
              'name_es' => '3 días República Mexicana',
              'name_en' => null,
              'description_es' => '3 días hábiles en toda la república mexicana',
              'description_en' => null,
              'ordering' => 3
            ),
        );

        for($i = 0; $i < count($metodos_envio) ; $i++) {
         DB::table('envio_metodo')->insert([
             'coin_id' => $metodos_envio[$i]['coin_id'],
             'cost' => $metodos_envio[$i]['cost'],
             'name_es' => $metodos_envio[$i]['name_es'],
             'name_en' => $metodos_envio[$i]['name_en'],
             'description_es' => $metodos_envio[$i]['description_es'],
             'description_en' => $metodos_envio[$i]['description_en'],
             'ordering' => $metodos_envio[$i]['ordering'],
         ]);
       }
    }
}
