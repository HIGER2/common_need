<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PurchaseGlobalApproval extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_global_id',
        'approved_by',
        'level',
        'status',
        'approval_date',
        'date',
        'comment',
    ];

    // Relation vers le PurchaseGlobal
    public function global()
    {
        return $this->belongsTo(PurchaseGlobal::class, 'purchase_global_id');
    }

    // Relation vers l'utilisateur qui approuve
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    protected static function boot()
    {
        parent::boot();
        // Exemple : event lors de la création
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->date = Carbon::today();
        });
    }
}
