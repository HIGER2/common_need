<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'unit', 'supplier_id', 'status'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseRequestItems()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function deliveryItems()
    {
        return $this->hasMany(DeliveryItem::class);
    }
}
