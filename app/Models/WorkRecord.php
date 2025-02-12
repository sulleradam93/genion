<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkRecord extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = "work_records";

    protected $fillable = ['student_id', 'company_job_id', 'work_date_begin', 'work_date_end', 'total_salary', 'calculated', 'comment'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function companyJob()
    {
        return $this->belongsTo(CompanyJob::class, 'company_job_id');
    }
}
