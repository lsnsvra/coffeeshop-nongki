<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_material', function (Blueprint $table) {
            $table->id('MenuMaterialID');

            $table->unsignedInteger('ProductID');
            $table->unsignedBigInteger('MaterialID'); // FIX DI SINI

            $table->integer('QuantityNeeded');

            $table->dateTime('CreatedDate')->nullable();
            $table->dateTime('LastUpdatedDate')->nullable();

            $table->foreign('ProductID')
                ->references('ProductID')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('MaterialID')
                ->references('MaterialID')
                ->on('materials')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_material');
    }
};