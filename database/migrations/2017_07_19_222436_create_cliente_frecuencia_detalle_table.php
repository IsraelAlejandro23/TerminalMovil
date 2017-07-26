<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteFrecuenciaDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_frecuencia_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pago_id')->unsigned()->foreign()->references("id")->on("pagos");
            $table->integer('period_time')->nullable();
            $table->tinyInteger('email_sent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_frecuencia_detalle');
    }
}
