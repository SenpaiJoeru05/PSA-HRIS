<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningDevelopment extends Model
{
    protected $table = 'learning_development';
        protected $fillable = [
        'employee_id',
        'learning_development_experiences_data',
        'learning_development_not_applicable',
    ];
    protected $casts = [
        'learning_development_experiences_data' => 'array',
        'learning_development_not_applicable' => 'boolean',
    ];

    // Define relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
