<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyBackground extends Model
{
    protected $table = 'family_background'; // Specify the correct table name
    protected $fillable = [
        'employee_id',
        'spouse_not_applicable',
        'spouse_last_name',
        'spouse_first_name',
        'spouse_middle_name',
        'spouse_name_extension',
        'father_not_applicable',
        'father_last_name',
        'father_first_name',
        'father_middle_name',
        'father_name_extension',
        'mother_not_applicable',
        'mother_maiden_surname',
        'mother_first_name',
        'mother_middle_name',
        'mother_name_extension',
        'children_not_applicable',
        'children',
    ];

    protected $casts = [
        'children' => 'json', 
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
