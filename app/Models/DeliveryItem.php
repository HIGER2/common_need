<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'product_id',
        'quantity_ordered',
        'quantity_received',
        'remarks',
    ];

    // Relation vers la livraison
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    // Relation vers le produit
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
