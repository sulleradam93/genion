<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JobPosition;


class Company extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'address'];

    public function jobPositions()
    {
        return $this->belongsToMany(JobPosition::class, 'company_jobs', 'company_id', 'job_id')
                    ->withPivot('base_hours', 'night_hours', 'weekend_hours');
    }

}