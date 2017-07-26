<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->foreign()->references("id")->on("usuarios")->onDelete("cascade");
            $table->integer('role_id')->unsigned()->index()->foreign()->references("id")->on("roles")->onDelete("cascade");
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
        Schema::dropIfExists('roles_usuarios');
    }
}
