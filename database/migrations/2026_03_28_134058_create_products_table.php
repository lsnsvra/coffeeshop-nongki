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
    Schema::create('products', function (Blueprint $table) {

        $table->increments('ProductID'); // PRIMARY KEY

        $table->string('NamaKopi', 100);
        $table->integer('Ukuran');
        $table->integer('Harga');
        $table->integer('Stok');
        $table->string('image')->nullable();

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
    Schema::dropIfExists('products');
}
};
