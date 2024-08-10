<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    protected $fillable = [
        'employee_id',
        'date_of_birth',
        'place_of_birth',
        'sex',
        'civil_status',
        'height',
        'weight',
        'blood_type',
        'gsis_id_no',
        'pagibig_id_no',
        'philhealth_no',
        'sss_no',
        'tin_no',
        'agency_employee_no',
        'citizenship',
        'citizenship_by',
        'dual_citizenship_country',
        'residential_province_id',
        'residential_city_id',
        'residential_barangay',
        'residential_subdivision_village',
        'residential_street',
        'residential_house_block_lot_no',
        'permanent_address_same_as_residential',
        'permanent_province',
        'permanent_city',
        'permanent_barangay',
        'permanent_subdivision',
        'permanent_street',
        'permanent_house_number',
        'telephone_number',
        'mobile_number',
        'email_address',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function residentialProvince()
    {
        return $this->belongsTo(Province::class, 'residential_province_id')->withDefault();
    }

    public function residentialCity()
    {
        return $this->belongsTo(City::class, 'residential_city_id')->withDefault();
    }
}
