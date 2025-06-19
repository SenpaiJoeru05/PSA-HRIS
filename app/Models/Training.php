<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type_of_ld', 'employees', 'start_date', 'end_date', 'number_of_hours', 'conducted_by',
    ];

    protected $casts = [
        'employees' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_training');
    }

}
