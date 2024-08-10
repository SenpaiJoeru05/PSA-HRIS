<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'elementary_school_name',
        'elementary_highest_level',
        'elementary_period_from',
        'elementary_period_to',
        'elementary_awards_received',
        'elementary_educational_attainment',
        'secondary_school_name',
        'secondary_highest_level',
        'secondary_period_from',
        'secondary_period_to',
        'secondary_awards_received',
        'secondary_educational_attainment',
        'vocational_not_applicable',
        'vocational_school_name',
        'vocational_highest_level',
        'vocational_period_from',
        'vocational_period_to',
        'vocational_awards_received',
        'vocational_educational_attainment',
        'college_school_name',
        'college_highest_level',
        'college_period_from',
        'college_period_to',
        'college_awards_received',
        'college_educational_attainment',
        'graduate_not_applicable',
        'graduate_school_name',
        'graduate_highest_level',
        'graduate_period_from',
        'graduate_period_to',
        'graduate_awards_received',
        'graduate_educational_attainment',
    ];

    /**
     * Get the employee that owns the educational background.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}