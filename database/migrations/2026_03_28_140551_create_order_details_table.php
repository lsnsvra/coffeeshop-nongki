<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('order_details', function (Blueprint $table) {

        $table->increments('DetailID'); // PRIMARY KEY

        $table->integer('OrderID');
        $table->integer('ProductID');

        $table->integer('Qty');
        $table->integer('Harga');
        $table->integer('Subtotal');

        $table->string('CompanyCode', 20)->nullable();

        $table->tinyInteger('Status')->default(1);
        $table->tinyInteger('IsDeleted')->default(0);

        $table->string('CreatedBy', 32)->nullable();
        $table->dateTime('CreatedDate')->nullable();

        $table->string('LastUpdatedBy', 32)->nullable();
        $table->dateTime('LastUpdatedDate')->nullable();
    });
}

public function down()
{
    Schema::dropIfExists('order_details');
}
};
