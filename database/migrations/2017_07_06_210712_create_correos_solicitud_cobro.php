<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorreosSolicitudCobro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correos_solicitud_cobro', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_office_id')->unsigned()->foreign()->references("id")->on("sucursales");
            $table->integer('user_id')->unsigned()->foreign()->references("id")->on("users");
            $table->string('user_email');
            $table->string('user_name');
            $table->integer('email_sent');
            $table->boolean('shipping_frecuency')->default(false);
            $table->integer('frecuency')->nullable();
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
        Schema::dropIfExists('correos_solicitud_cobro');
    }
}
