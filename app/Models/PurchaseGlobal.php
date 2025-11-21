<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PurchaseGlobal extends Model
{
    protected $fillable = ['requester_id', 'budget_officer_id', 'date', "reference", 'total_amount', 'total_item', 'total_quantity', 'status', 'remarks'];

    public function budgetOfficer()
    {
        return $this->belongsTo(User::class, 'budget_officer_id');
    }

    public function approvals()
    {
        return $this->hasMany(PurchaseGlobalApproval::class);
    }

    public function latestApproval()
    {
        return $this->hasOne(PurchaseGlobalApproval::class)->latestOfMany();
    }

    public function purchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::class);
    }

    public function requests()
    {
        return $this->hasMany(PurchaseRequest::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }


    protected static function boot()
    {
        parent::boot();
        // Exemple : event lors de la création
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->date = Carbon::today();

            do {
                $ref = 'PG-' . strtoupper(Str::random(8));
            } while (self::where('reference', $ref)->exists());

            $model->reference = $ref;
        });
    }
}
