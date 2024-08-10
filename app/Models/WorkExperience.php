<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'work_experiences';

    protected $fillable = [
        'employee_id',
        'work_experience_not_applicable',
        'work_experiences_data',
    ];

    protected $casts = [
        'work_experiences_data' => 'array', // Cast JSON column to array
        'work_experience_not_applicable' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
