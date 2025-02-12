<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CompanyJob;

class Student extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['user_id', 'card_id', 'name', 'email', 'phone', 'address', 'gender', 'birth_date', 'cv'];

    public function companyJobs()
    {
        return $this->belongsToMany(CompanyJob::class, 'work_records')
                    ->withPivot('work_date_begin', 'work_date_end', 'total_salary');
    }

    public function card()
    {
        return $this->hasOne(StudentCard::class, 'id', 'card_id');
    }
}
