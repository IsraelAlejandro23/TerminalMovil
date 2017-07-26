<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosSucursales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_sucursales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->foreign()->references("id")->on("usuarios");
            $table->integer('branch_office_id')->unsigned()->index()->foreign()->references("id")->on("sucursales");
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
        Schema::dropIfExists('usuarios_sucursales');
    }
}
