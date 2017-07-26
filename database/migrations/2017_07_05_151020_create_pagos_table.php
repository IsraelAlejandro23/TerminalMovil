<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_office_id')->unsigned()->foreign()->references("id")->on("sucursales");
            $table->integer('user_id')->unsigned()->foreign()->references("id")->on("users");
            $table->string('user_name');
            $table->string('email_client');
            $table->string('method');
            $table->string('pay_method');
            $table->integer('shipping_method_id')->unsigned()->foreign()->references("id")->on("envio_metodo");
            $table->decimal('subtotal', 14 , 2);
            $table->decimal('iva_amount', 14,2);
            $table->float('iva_percent');
            $table->decimal('shippingamt', 14,2);
            $table->decimal('amount', 14, 2);
            $table->string('currency', 5);
            $table->string('description');
            $table->integer('status_id')->unsigned()->foreign()->references('id')->on('pago_status')->nullable();
            $table->string('status_name')->nullable()->default(null);
            $table->string('ip_adress');
            $table->timestamp('external_creation_date')->nullable()->default(null);
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
        Schema::dropIfExists('pagos');
    }
}
