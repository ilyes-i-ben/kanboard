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
            $table->boolean('is_terminal')->after('position')->default(false);

            $table->unsignedBigInteger('created_by')->nullable();
            $table
                ->foreign(['created_by'], 'lists_ibfk_2')
                ->references(['id'])
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lists', function (Blueprint $table) {
            $table->dropForeign('lists_ibfk_2');
            $table->dropColumn('created_by');
            $table->dropColumn('is_terminal');
        });
    }
};
