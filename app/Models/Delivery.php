<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'purchase_order_id',
        'received_by',
        'reference',
        'date',
        'quantity_ordered',
        'quantity_received',
        'total_received',
        'total_ordered',
        'grn_number',
        'remarks'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function deliveryRequest()
    {
        return $this->hasMany(DeliveryRequest::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }



    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->date = Carbon::today();
            do {
                $ref = 'D-' . strtoupper(Str::random(8));
            } while (self::where('reference', $ref)->exists());

            $model->reference = $ref;
        });
    }
}
