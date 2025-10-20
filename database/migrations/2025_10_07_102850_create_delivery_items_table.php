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
        Schema::create('delivery_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id');      // Référence à la livraison
            $table->unsignedBigInteger('product_id');       // Produit concerné
            $table->decimal('quantity_ordered', 12, 2)->default(0);     // Quantité commandée
            $table->decimal('quantity_received', 12, 2)->nullable(); // Quantité réellement reçue
            $table->text('remarks')->nullable();            // Commentaire si produit manquant/détérioré
            $table->timestamps();
            // Relations
            $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
