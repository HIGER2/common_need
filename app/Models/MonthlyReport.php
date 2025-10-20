<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
