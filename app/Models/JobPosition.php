<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class JobPosition extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
    ];
    
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_jobs', 'job_id', 'company_id')
                    ->withPivot('base_hours', 'night_hours', 'weekend_hours');
    }
}
