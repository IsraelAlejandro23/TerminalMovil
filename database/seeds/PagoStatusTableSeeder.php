<?php

use Illuminate\Database\Seeder;

class PagoStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       //Creamos array con los status de los Pagos

       $pagos_status = array (

            array(
              'name' => 'Pendiente',
              'color' => '#06F',
              'ordering' => 1,
            ),
            array(
              'name' => 'Confirmado por comprador',
              'color' => null,
              'ordering' => 2,
            ),
            array(
              'name' => 'Pagado',
              'color' => '#063',
              'ordering' => 3,
            ),
            array(
              'name' => 'Cancelado',
              'color' => '#900',
              'ordering' => 5,
            ),
            array(
              'name' => 'Reembolsado',
              'color' => '#F60',
              'ordering' => 6,
            ),
            array(
              'name' => 'Transportado',
              'color' => '#000',
              'ordering' => 7,
            ),
            array(
              'name' => 'Pagado y entregado',
              'color' => '#066',
              'ordering' => 4,
            ),
            array(
              'name' => 'Cambio',
              'color' => '#ac00ec',
              'ordering' => 8,
            ),

       );


       	for($i = 0; $i < count($pagos_status) ; $i++) {
          DB::table('pago_status')->insert([
              'name' => $pagos_status[$i]['name'],
              'color' => $pagos_status[$i]['color'],
              'ordering' => $pagos_status[$i]['ordering'],
          ]);
        }
    }
}
