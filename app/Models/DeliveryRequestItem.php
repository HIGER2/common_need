<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DeliveryRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_request_id',
        'product_id',
        'quantity_ordered',
        'quantity_received',
        'subtotal_ordered',
        'subtotal_received',
        'unit_price',
        'name',
        'remarks',
    ];

    // Relation vers la livraison
    public function deliveryRequest()
    {
        return $this->belongsTo(DeliveryRequest::class);
    }

    // Relation vers le produit
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
