<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password',
        'center_id',
        'status'
    ];

    protected $hidden = ['password', 'remember_token'];

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
}
