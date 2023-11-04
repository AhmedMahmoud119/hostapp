<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->longText('data')->nullable();
            $table->string('item_id');
            $table->string('currency');
            $table->integer('period_in_month');
            $table->float('price')->default(0);
            $table->string('category');
            $table->string('type');
            $table->string('status')->default('active'); // active   disactive

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
