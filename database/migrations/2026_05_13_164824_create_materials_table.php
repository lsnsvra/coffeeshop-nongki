<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id('MaterialID');
            $table->string('NamaMaterial');
            $table->string('Unit');
            $table->integer('Stock')->default(0);
            $table->tinyInteger('Status')->default(1);
            $table->tinyInteger('IsDeleted')->default(0);
            $table->dateTime('CreatedDate')->nullable();
            $table->dateTime('LastUpdatedDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
