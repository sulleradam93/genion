<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentCard extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['owner_name', 'bank_account_number'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'card_id', 'id');
    }
}
