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
        Schema::table('cards', function (Blueprint $table) {
            $table
                ->foreign(['list_id'], 'cards_ibfk_1')
                ->references(['id'])
                ->on('lists');

            $table
                ->foreign(['created_by'], 'cards_ibfk_2')
                ->references(['id'])
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign('cards_ibfk_1');
            $table->dropForeign('cards_ibfk_2');
        });
    }
};
