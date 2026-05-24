<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->increments('CartID');

            $table->unsignedInteger('UserID');
            $table->unsignedInteger('ProductID');

            $table->integer('Qty')->default(1);

            $table->tinyInteger('Status')->default(1);
            $table->tinyInteger('IsDeleted')->default(0);

            $table->dateTime('CreatedDate')->nullable();
            $table->dateTime('LastUpdatedDate')->nullable();

            $table->foreign('UserID')
                ->references('UserID')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('ProductID')
                ->references('ProductID')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};