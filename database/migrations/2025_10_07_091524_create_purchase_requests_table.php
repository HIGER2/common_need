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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('reference')->unique()->nullable();
            $table->unsignedBigInteger('purchase_global_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected', 'ordered', 'delivered', 'closed'])->default('pending');
            $table->date('date')->nullable();
            $table->bigInteger('total_item')->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->bigInteger('total_quantity')->default(0);
            $table->text('remarks')->nullable();

            $table->foreign('purchase_global_id')->references('id')->on('purchase_globals')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
