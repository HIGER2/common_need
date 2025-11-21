<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'purchase_request_id',
        'purchase_global_id',
        'uuid',
        'liaison_officer_id',
        'total_item',
        'total_amount',
        'total_quantity',
        'supplier_id',
        'date',
        'reference',
        'status'
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseGlobal::class, 'purchase_global_id');
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
        return $this->hasOne(Delivery::class);
    }

    protected static function boot()
    {
        parent::boot();
        // Exemple : event lors de la création
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->date = Carbon::today();
            do {
                $ref = 'OR-' . strtoupper(Str::random(8));
            } while (self::where('reference', $ref)->exists());

            $model->reference = $ref;
        });
    }
}
