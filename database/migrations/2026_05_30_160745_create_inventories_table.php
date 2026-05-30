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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['drink', 'equipment']);
            $table->string('name');
            $table->integer('stock_qty')->default(0);
            $table->decimal('price', 10, 2)->nullable(); // Nullable, only for drink
            $table->enum('condition', ['Baik', 'Rusak', 'Sedang Diperbaiki'])->nullable(); // Nullable, only for equipment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
