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
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->after('id')
                ->index();
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->unique(
                ['user_id', 'anime_id'],
                'favorites_user_id_anime_id_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropUnique('favorites_user_id_anime_id_unique');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex('reviews_user_id_index');
            $table->dropColumn('user_id');
        });
    }
};
