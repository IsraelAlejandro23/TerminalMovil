<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id');
            $table->string('method');
            $table->string('device_session_id')->nullable();
            $table->integer('autorization')->nullable();
            $table->datetime('external_creation_date')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('status', 50)->nullable()->default(null);
            $table->string('transaction_type', 30)->nullable();
            $table->string('external_id', 50)->nullable();
            $table->string('issuing_bank')->nullable();
            $table->string('card_type', 20)->nullable();
            $table->tinyInteger('msi')->nullable();
            $table->integer('payment_plan')->nullable();
            $table->string('card_mode', 15)->nullable();
            $table->string('string_error')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pago_detalles');
    }
}
