<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_global_id', "reference", 'supplier_id', 'status', 'date', 'total_amount', 'total_item', 'total_quantity', 'remarks'];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function approvals()
    {
        return $this->hasMany(PurchaseApproval::class);
    }

    public function purchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Exemple : event lors de la création
            $model->uuid = Str::uuid();
            $model->date = Carbon::today();
            do {
                $ref = 'R-' . strtoupper(Str::random(8));
            } while (self::where('reference', $ref)->exists());
            $model->reference = $ref;
        });
    }
}
