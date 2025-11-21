<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $fillable = ['month', 'year', 'center_id', 'liaison_officer_id', 'total_amount', 'report_file'];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function liaisonOfficer()
    {
        return $this->belongsTo(User::class, 'liaison_officer_id');
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
