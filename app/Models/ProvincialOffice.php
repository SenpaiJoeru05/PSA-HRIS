<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvincialOffice extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'provincial_offices';

    // The attributes that are mass assignable.
    protected $fillable = [
        'office_name', // Assuming this is the new column for the office name
        'employee_id', // Foreign key to the Employee model
    ];
    protected $attributes = [
        'office_name' => 'Default Office Name', // Default value if none is provided
    ];

    /**
     * Get the employee associated with the provincial office.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
