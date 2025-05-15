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
        Schema::table('board_members', function (Blueprint $table) {
            $table->foreign(['board_id'], 'board_members_ibfk_1')->references(['id'])->on('boards')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'], 'board_members_ibfk_2')->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('board_members', function (Blueprint $table) {
            $table->dropForeign('board_members_ibfk_1');
            $table->dropForeign('board_members_ibfk_2');
        });
    }
};
