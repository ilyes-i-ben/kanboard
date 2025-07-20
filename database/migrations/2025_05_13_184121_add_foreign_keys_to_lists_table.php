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
        Schema::table('lists', function (Blueprint $table) {
            $table
                ->foreign(['board_id'], 'lists_ibfk_1')
                ->references(['id'])
                ->on('boards')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lists', function (Blueprint $table) {
            $table->dropForeign('lists_ibfk_1');
        });
    }
};
