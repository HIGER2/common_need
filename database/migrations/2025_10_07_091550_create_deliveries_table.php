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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('reference')->unique()->nullable();
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->unsignedBigInteger('received_by')->nullable();

            $table->date('date')->nullable();
            $table->bigInteger('quantity_ordered')->default(0);
            $table->bigInteger('quantity_received')->default(0);
            $table->decimal('total_received', 15, 2)->default(0);
            $table->decimal('total_ordered', 15, 2)->default(0);
            $table->string('grn_number')->nullable();
            $table->text('remarks')->nullable();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('set null');
            $table->foreign('received_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
