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
        Schema::create('card_members', function (Blueprint $table) {
            $table->integer('card_id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->timestamps();

            $table->primary(['card_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_members');
    }
};
