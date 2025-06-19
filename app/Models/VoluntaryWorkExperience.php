<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoluntaryWorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'voluntary_work_experience_not_applicable',
        'voluntary_work_experiences_data',
    ];

    protected $casts = [
        'voluntary_work_experiences_data' => 'array',
        'voluntary_work_experience_not_applicable' => 'boolean',
        
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
