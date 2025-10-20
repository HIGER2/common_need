<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_request_id', 'liaison_officer_id', 'supplier_id', 'order_date', 'order_number', 'status'];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function liaisonOfficer()
    {
        return $this->belongsTo(User::class, 'liaison_officer_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
