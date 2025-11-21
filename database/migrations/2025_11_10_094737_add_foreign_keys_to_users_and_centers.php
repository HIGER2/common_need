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
        // FK centers.liaison_officer_id → users.id
        Schema::table('centers', function (Blueprint $table) {
            $table->foreign('liaison_officer_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });

        // FK users.center_id → centers.id
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('center_id')
                ->references('id')
                ->on('centers')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('centers', function (Blueprint $table) {
            $table->dropForeign(['liaison_officer_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['center_id']);
        });
    }
};
