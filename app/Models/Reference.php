<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'employee_id',
        'reference_detail_data',
        'government_id_type',
        'government_id_type_specification',
        'government_id_number',
        'government_id_date_place',
    ];

    protected $casts = [
        'government_detail_data' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
