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
    Schema::table('payments', function (Blueprint $table) {

        $table->foreignId('group_id')
              ->after('id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('user_id')
              ->after('group_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->decimal('amount', 12, 2)
              ->after('user_id');

        $table->enum('status', [
            'pending',
            'paid'
        ])->default('pending')
          ->after('amount');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('payments', function (Blueprint $table) {

        $table->dropForeign(['group_id']);
        $table->dropForeign(['user_id']);

        $table->dropColumn([
            'group_id',
            'user_id',
            'amount',
            'status'
        ]);

    });
}
};
