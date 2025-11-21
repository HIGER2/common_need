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
        Schema::create('delivery_request_items', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->default();
            $table->unsignedBigInteger('delivery_request_id')->nullable();      // Référence à la livraison
            $table->unsignedBigInteger('product_id')->nullable();       // Produit concerné
            $table->bigInteger('quantity_ordered')->default(0);     // Quantité commandée
            $table->bigInteger('quantity_received')->default(0); // Quantité réellement reçue
            $table->decimal('subtotal_ordered', 12, 2)->default(0);
            $table->decimal('subtotal_received', 12, 2)->default(0);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->string('name')->nullable();
            $table->text('remarks')->nullable();            // Commentaire si produit manquant/détérioré
            // Relations
            $table->foreign('delivery_request_id')->references('id')->on('delivery_requests')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_items');
    }
};
