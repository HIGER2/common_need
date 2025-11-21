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
        Schema::create('purchase_global_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('purchase_global_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable(); // User qui approuve

            $table->tinyInteger('level')->default(1); // Niveau d'approbation

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            // $table->dateTime('date')->nullable();
            $table->dateTime('date')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('purchase_global_id')
                ->references('id')->on('purchase_globals')
                ->onDelete('set null');

            $table->foreign('approved_by')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_global_approvals');
    }
};
