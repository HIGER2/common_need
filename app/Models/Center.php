<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'liaison_officer_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function monthlyReports()
    {
        return $this->hasMany(MonthlyReport::class);
    }
}
