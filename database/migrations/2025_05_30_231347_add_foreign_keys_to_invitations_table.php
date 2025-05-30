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
        Schema::table('invitations', function (Blueprint $table) {
            $table
                ->foreign(['board_id'], 'invitations_ibfk_1')
                ->references(['id'])
                ->on('boards');

            $table
                ->foreign(['inviter_id'], 'invitations_ibfk_2')
                ->references(['id'])
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropForeign('boards_ibfk_1');
            $table->dropForeign('boards_ibfk_2');
        });
    }
};
