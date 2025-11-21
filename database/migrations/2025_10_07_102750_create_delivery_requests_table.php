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
        Schema::create('delivery_requests', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->enum('status', ['cancelled', 'received', 'delivered'])->default('received');
            $table->date('date')->nullable();
            $table->bigInteger('quantity_ordered')->default(0);
            $table->bigInteger('quantity_received')->default(0);
            $table->decimal('total_received', 15, 2)->default(0);
            $table->decimal('total_ordered', 15, 2)->default(0);
            $table->text('remarks')->nullable();

            $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_requests');
    }
};
