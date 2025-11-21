<?php

namespace App\Models;

use App\Models\PurchaseApproval;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        "pin",
        'role',
        'password',
        'center_id',
        'otp_expires_at',
        'status'
    ];

    protected $hidden = ['password', 'pin', 'remember_token'];

    // Relation avec les demandes
    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class, 'requester_id');
    }

    // Relation avec les approbations
    public function approvals()
    {
        return $this->hasMany(PurchaseApproval::class, 'approved_by');
    }

    // Relation avec les commandes confirmées
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'liaison_officer_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
