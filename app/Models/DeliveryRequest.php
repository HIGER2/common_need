<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DeliveryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'delivery_id',
        'supplier_id',
        'status',
        'date',
        'quantity_ordered',
        'quantity_received',
        'total_received',
        'total_ordered',
        'remarks'
    ];

    public function items()
    {
        return $this->hasMany(DeliveryRequestItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->date = Carbon::today();
        });
    }
}
