<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class CompanyJob extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['company_id', 'job_id', 'base_salary', 'night_salary', 'weekend_salary'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'work_records')
                    ->withPivot('work_date_begin', 'work_date_end', 'total_salary');
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    
    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'job_id');
    }
}
