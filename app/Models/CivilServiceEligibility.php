<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilServiceEligibility extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'civil_service_eligibilities';

    // Fillable attributes
    protected $fillable = [
        'employee_id',
        'civil_service_eligibility_not_applicable',
        'civil_service_data',
    ];

    // Cast attributes to their appropriate types
    protected $casts = [
        'civil_service_data' => 'array', // Cast JSON column to array
        'civil_service_eligibility_not_applicable' => 'boolean', // Cast to boolean
    ];

    // Define the relationship with the Employee model
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
