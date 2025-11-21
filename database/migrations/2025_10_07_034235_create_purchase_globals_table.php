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
        Schema::create('purchase_globals', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('reference')->unique()->nullable();
            $table->unsignedBigInteger('requester_id')->nullable();
            $table->unsignedBigInteger('budget_officer_id')->nullable();
            $table->bigInteger('total_item')->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->bigInteger('total_quantity')->default(0);
            $table->enum('status', ['pending', 'partially_approved', 'approved', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();
            $table->date('date')->nullable();

            $table->foreign('budget_officer_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('requester_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_globals');
    }
};
