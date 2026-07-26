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
    Schema::create('shopping_item_users', function (Blueprint $table) {

        $table->id();

        // Barang dari shopping_lists
        $table->foreignId('shopping_list_id')
              ->constrained('shopping_lists')
              ->cascadeOnDelete();

        // Pemilik barang
        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_item_users');
    }
};
