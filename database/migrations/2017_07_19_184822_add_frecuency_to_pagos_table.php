<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFrecuencyToPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->integer('frecuency')->nullable()->after('ip_adress');
            $table->string('frecuency_token', 30)->nullable()->after('frecuency');
            $table->tinyInteger('email_sent')->nullable()->after('frecuency_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagos', function (Blueprint $table) {
            //
        });
    }
}
