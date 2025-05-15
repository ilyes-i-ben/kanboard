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
        Schema::table('card_members', function (Blueprint $table) {
            $table
                ->foreign(['card_id'], 'card_members_ibfk_1')
                ->references(['id'])
                ->on('cards')
                ->onDelete('cascade');

            $table
                ->foreign(['user_id'], 'card_members_ibfk_2')
                ->references(['id'])
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_members', function (Blueprint $table) {
            $table->dropForeign('card_members_ibfk_1');
            $table->dropForeign('card_members_ibfk_2');
        });
    }
};
