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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('liaison_officer_id')->nullable();
            $table->unsignedBigInteger('purchase_global_id')->nullable();
            $table->bigInteger('total_item')->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->bigInteger('total_quantity')->default(0);
            $table->date('date')->nullable();
            $table->string('reference')->nullable();
            $table->enum('status', ['sent', 'pending', 'approved', 'rejected', 'received', 'delivered', 'completed', 'cancelled'])->default('sent');

            // $table->foreign('purchase_request_id')->references('id')->on('purchase_requests')->onDelete('set null');
            $table->foreign('purchase_global_id')->references('id')->on('purchase_globals')->onDelete('set null');
            $table->foreign('liaison_officer_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
