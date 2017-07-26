<?php

use Illuminate\Database\Seeder;

class SucursalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$sucursales = array(
    		array(
    			'id_externo' => 2,
    		     'nombre_sucursal' => 'Circunvalación'
    		),
	        array(
    			'id_externo' => 8,
    		    'nombre_sucursal' => 'López Mateos'
    		),
    		array(
    			'id_externo' => 16,
    		    'nombre_sucursal' => 'Aviación'
    		),
    		array(
    			'id_externo' => 24,
    		    'nombre_sucursal' => 'Álamo'
    		),
    		array(
    			'id_externo' => 32,
    		    'nombre_sucursal' => 'Calzada Independencia'
    		),
    	);

    	for($i = 0; $i < count($sucursales) ; $i++) {
    		DB::table('sucursales')->insert([
    			'extern_id' => $sucursales[$i]['id_externo'],
    			'branch_office_name' => $sucursales[$i]['nombre_sucursal']
    		]);
    	}
    }
}
