<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'division_id',
        'agency_employee_id',
        'first_name',
        'last_name',
        'middle_name',
        'extension_name',
        'position',
        'employment_status',
        'date_hired',
        'date_resigned',
        'date_retired',
    ];

    //  Add the computed full name attribute
     protected $appends = ['full_name'];

     public function getFullNameAttribute()
     {
         return "{$this->first_name} {$this->middle_name} {$this->last_name} {$this->extension_name}";
     }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function personalInformation(): HasOne
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function familyBackground(): HasOne
    {
        return $this->hasOne(FamilyBackground::class);
    }

    public function educationalBackground()
{
    return $this->hasOne(EducationalBackground::class);
}


    public function civilServiceEligibilities(): HasMany
    {
        return $this->hasMany(CivilServiceEligibility::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function voluntaryWorkExperiences(): HasMany
    {
        return $this->hasMany(VoluntaryWorkExperience::class);
    }

    public function learningDevelopment(): HasMany
    {
        return $this->hasMany(LearningDevelopment::class);
    }

    public function otherInformation(): HasOne
    {
        return $this->hasOne(OtherInformation::class);
    }

    public function references(): HasMany
    {
        return $this->hasMany(Reference::class);
    }
    public function provincialOffice()
    {
        return $this->hasOne(ProvincialOffice::class);
    }
    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'employee_training');
    }
}
