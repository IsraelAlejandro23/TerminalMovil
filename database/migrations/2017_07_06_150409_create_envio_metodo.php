<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnvioMetodo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envio_metodo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coin_id')->unsigned()->foreign()->references("id")->on("monedas");
            $table->decimal('cost', 14, 2);
            $table->string('name_es')->nullable();
            $table->string('name_en')->nullable();
            $table->string('description_es')->nullable();
            $table->string('description_en')->nullable();
            $table->integer('ordering')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('envio_metodo');
    }
}
