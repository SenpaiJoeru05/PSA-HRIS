<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherInformation extends Model
{
    protected $fillable = [
        'employee_id',
        'special_skills_and_hobbies',
        'non_academic_distinctions',
        'members_in_organization',
        'related_to_appointing_authority',
        'related_details_third_degree',
        'related_to_appointing_authority_fourth_degree',
        'related_details_fourth_degree',
        'guilty_of_offense',
        'offense_details',
        'criminally_charged',
        'charged_details',
        'charged_date',
        'charged_status',
        'convicted_of_crime',
        'conviction_details',
        'separated_from_service',
        'separation_details',
        'candidate_in_election',
        'resigned_for_campaign',
        'resignation_details',
        'immigrant_or_resident',
        'immigrant_details',
        'member_of_indigenous_group',
        'indigenous_group_details',
        'person_with_disability',
        'disability_id',
        'solo_parent',
        'solo_parent_id',
    ];

    protected $casts = [
        'special_skills_and_hobbies' => 'array',
        'non_academic_distinctions' => 'array',
        'members_in_organization' => 'array',
        'related_to_appointing_authority' => 'boolean',
        'related_to_appointing_authority_fourth_degree' => 'boolean',
        'guilty_of_offense' => 'boolean',
        'criminally_charged' => 'boolean',
        'convicted_of_crime' => 'boolean',
        'separated_from_service' => 'boolean',
        'candidate_in_election' => 'boolean',
        'resigned_for_campaign' => 'boolean',
        'immigrant_or_resident' => 'boolean',
        'member_of_indigenous_group' => 'boolean',
        'person_with_disability' => 'boolean',
        'solo_parent' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

