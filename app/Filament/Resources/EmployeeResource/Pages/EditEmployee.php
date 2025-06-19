<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\CivilServiceEligibility;
use App\Models\Employee;
use App\Models\LearningDevelopment;
use App\Models\Province;
use App\Models\City;
use App\Models\Division;
use App\Models\Reference;
use App\Models\VoluntaryWorkExperience;
use App\Models\WorkExperience;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Get;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Rawilk\FilamentPasswordInput\Password;


class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;
    public function mount(int|string $record): void
{
    parent::mount($record);
    
    // Retrieve employee data based on $recordId
    $employee = Employee::with([
        'user',
        'personalInformation', 
        'familyBackground', 
        'educationalBackground', 
        'civilServiceEligibilities', 
        'workExperiences', 
        'voluntaryWorkExperiences', 
        'learningDevelopment', 
        'otherInformation', 
        'references'
    ])->findOrFail($record);

    // Initialize data
    $childrenData = $employee->familyBackground->children ?? '[]';
    //Initialize data for Civil Service
    $civilServiceEligibility = $employee->civilServiceEligibilities->first();
    $civilServiceEligibilityData = $civilServiceEligibility ? $civilServiceEligibility->civil_service_data : [];
    //Initialize data for Work Experience
    $workExperiences = $employee->workExperiences->first();
    $workExperiencesData = $workExperiences ? $workExperiences->work_experiences_data : [];
    //Initialize data for Voluntary Work Experience
    $voluntaryWorkExperiencesData = $employee->voluntaryWorkExperiences->first()->voluntary_work_experiences_data ?? [];
     
    // Initialize data for Learning Development
     $learningDevelopment = $employee->learningDevelopment->first();
     $learningDevelopmentData = $learningDevelopment ? $learningDevelopment->learning_development_experiences_data : [];

     $reference = $employee->references->first();
     $referencesData = $reference->reference_detail_data ?? [];

    // Log the type and content of childrenData and civilServiceEligibilityData
    Log::info('Children Data Type: ' . gettype($childrenData));
    Log::info('Children Data Content: ' . print_r($childrenData, true));

    Log::info('Civil Service Eligibility Data Type: ' . gettype($civilServiceEligibilityData));
    Log::info('Civil Service Eligibility Data Content: ' . print_r($civilServiceEligibilityData, true));

    Log::info('Work Experience Data Type: ' . gettype($workExperiencesData));
    Log::info('Work Experience Data Content: ' . print_r($workExperiencesData, true));

    Log::info('Voluntary Work Experiences Data Type: ' . gettype($voluntaryWorkExperiencesData));

    Log::info('Learning Development Data Type: ' . gettype($learningDevelopmentData));
    Log::info('Learning Development Data Content: ' . print_r($learningDevelopmentData, true));

    Log::info('References Data Type: ' . gettype($referencesData));
    Log::info('References Data Content: ' . print_r($referencesData, true));



    
    // Decode JSON data if needed
    if (is_string($childrenData)) {
        $childrenData = json_decode($childrenData, true);
    }
    if (is_string($civilServiceEligibilityData)) {
        $civilServiceEligibilityData = json_decode($civilServiceEligibilityData, true);
    }
    if (is_string($workExperiencesData)) {
        $workExperiencesData = json_decode($workExperiencesData, true);
    }
    if (is_string($voluntaryWorkExperiencesData)) {
        $voluntaryWorkExperiencesData = json_decode($voluntaryWorkExperiencesData, true);
    }
    if (is_string($learningDevelopmentData)) {
        $learningDevelopmentData = json_decode($learningDevelopmentData, true);
    }
   if (is_string($referencesData)) {
    $referencesData = json_decode($referencesData, true);
    }
        $this->form->fill([
            'user' => [
               
                'email' => $employee->user->email,
                'profile_picture' => $employee->user->profile_picture,
                'role' => $employee->user->role,
            ],
                'division_id' => $employee->division_id ?? '',
                'agency_employee_id' =>$employee->agency_employee_id ??'',
                'first_name' =>$employee->first_name ??'',
                'last_name' =>$employee->last_name ??'',
                'middle_name' =>$employee->middle_name ??'',
                'extension_name' =>$employee->extension_name ??'',
                'position' =>$employee->position ??'',
                'employment_status' =>$employee->employment_status ??'',
                'date_hired' =>$employee->date_hired ??'',
                'date_resigned' =>$employee->date_resigned ??'',
                'date_retired' =>$employee->date_retired ??'',

            'personalInformation' => [
                'date_of_birth' => $employee->personalInformation->date_of_birth ?? '',
                'place_of_birth' => $employee->personalInformation->place_of_birth ?? '',
                'sex' => $employee->personalInformation->sex ?? '',
                'civil_status' => $employee->personalInformation->civil_status ?? '',
                'height' => $employee->personalInformation->height ?? '',
                'weight' => $employee->personalInformation->weight ?? '',
                'blood_type' => $employee->personalInformation->blood_type ?? '',
                'gsis_id_no' => $employee->personalInformation->gsis_id_no ?? '',
                'pagibig_id_no' => $employee->personalInformation->pagibig_id_no ?? '',
                'philhealth_no' => $employee->personalInformation->philhealth_no ?? '',
                'sss_no' => $employee->personalInformation->sss_no ?? '',
                'tin_no' => $employee->personalInformation->tin_no ?? '',
                'agency_employee_no' => $employee->personalInformation->agency_employee_no ?? '',
                'citizenship' => $employee->personalInformation->citizenship ?? '',
                'citizenship_by' => $employee->personalInformation->citizenship_by ?? '',
                'dual_citizenship_country' => $employee->personalInformation->dual_citizenship_country ?? '',
                // Residential Address
                'residential_province_id' => $employee->personalInformation->residential_province_id?? '',
                'residential_city_id' => $employee->personalInformation->residential_city_id?? '',
                'residential_barangay' => $employee->personalInformation->residential_barangay?? '',
                'residential_subdivision_village' => $employee->personalInformation->residential_subdivision_village?? '',
                'residential_street' => $employee->personalInformation->residential_street?? '',
                'residential_house_block_lot_no' => $employee->personalInformation->residential_house_block_lot_no?? '',
                // Permanent Address
                'permanent_address_same_as_residential' => $employee->personalInformation->permanent_address_same_as_residential?? '',
                'permanent_province' => $employee->personalInformation->permanent_province?? '',
                'permanent_city' => $employee->personalInformation->permanent_city?? '',
                'permanent_barangay' => $employee->personalInformation->permanent_barangay?? '',
                'permanent_subdivision' => $employee->personalInformation->permanent_subdivision?? '',
                'permanent_street' => $employee->personalInformation->permanent_street?? '',
                'permanent_house_number' => $employee->personalInformation->permanent_house_number?? '',
                // Contacts
                'telephone_number' => $employee->personalInformation->telephone_number?? '',
                'mobile_number' => $employee->personalInformation->mobile_number?? '',
                'email_address' => $employee->personalInformation->email_address?? '',
            ],
            'familyBackground' => [
            'spouse_not_applicable' => $employee->familyBackground->spouse_not_applicable ?? false,
            'spouse_last_name' => $employee->familyBackground->spouse_last_name ?? '',
            'spouse_first_name' => $employee->familyBackground->spouse_first_name ?? '',
            'spouse_middle_name' => $employee->familyBackground->spouse_middle_name ?? '',
            'spouse_name_extension' => $employee->familyBackground->spouse_name_extension ?? '',
            'father_not_applicable' => $employee->familyBackground->father_not_applicable ?? false,
            'father_last_name' => $employee->familyBackground->father_last_name ?? '',
            'father_first_name' => $employee->familyBackground->father_first_name ?? '',
            'father_middle_name' => $employee->familyBackground->father_middle_name ?? '',
            'father_name_extension' => $employee->familyBackground->father_name_extension ?? '',
            'mother_not_applicable' => $employee->familyBackground->mother_not_applicable ?? false,
            'mother_maiden_surname' => $employee->familyBackground->mother_maiden_surname ?? '',
            'mother_first_name' => $employee->familyBackground->mother_first_name ?? '',
            'mother_middle_name' => $employee->familyBackground->mother_middle_name ?? '',
            'mother_name_extension' => $employee->familyBackground->mother_name_extension ?? '',
            'children_not_applicable' => $employee->familyBackground->children_not_applicable ?? false,
            'children' => collect($childrenData ?? [])->map(function ($child) {
                return [
                    'id' => $child['id'] ?? '',
                    'children_surname' => $child['children_surname'] ?? '',
                    'children_first_name' => $child['children_first_name'] ?? '',
                    'children_middle_name' => $child['children_middle_name'] ?? '',
                    'children_name_extension' => $child['children_name_extension'] ?? '',
                ];
            })->toArray(),
            ],
  
            'educationalBackground' => [
                'elementary_school_name' => $employee->educationalBackground->elementary_school_name ?? '',
                'elementary_highest_level' => $employee->educationalBackground->elementary_highest_level ?? '',
                'elementary_period_from' => $employee->educationalBackground->elementary_period_from ?? '',
                'elementary_period_to' => $employee->educationalBackground->elementary_period_to ?? '',
                'elementary_awards_received' => $employee->educationalBackground->elementary_awards_received ?? '',
                'elementary_educational_attainment' => $employee->educationalBackground->elementary_educational_attainment ?? '',
    
                'secondary_school_name' => $employee->educationalBackground->secondary_school_name ?? '',
                'secondary_highest_level' => $employee->educationalBackground->secondary_highest_level ?? '',
                'secondary_period_from' => $employee->educationalBackground->secondary_period_from ?? '',
                'secondary_period_to' => $employee->educationalBackground->secondary_period_to ?? '',
                'secondary_awards_received' => $employee->educationalBackground->secondary_awards_received ?? '',
                'secondary_educational_attainment' => $employee->educationalBackground->secondary_educational_attainment ?? '',
    
                'vocational_not_applicable' => $employee->educationalBackground->vocational_not_applicable ?? false,
                'vocational_school_name' => $employee->educationalBackground->vocational_school_name ?? '',
                'vocational_highest_level' => $employee->educationalBackground->vocational_highest_level ?? '',
                'vocational_period_from' => $employee->educationalBackground->vocational_period_from ?? '',
                'vocational_period_to' => $employee->educationalBackground->vocational_period_to ?? '',
                'vocational_awards_received' => $employee->educationalBackground->vocational_awards_received ?? '',
                'vocational_educational_attainment' => $employee->educationalBackground->vocational_educational_attainment ?? '',
    
                'college_school_name' => $employee->educationalBackground->college_school_name ?? '',
                'college_highest_level' => $employee->educationalBackground->college_highest_level ?? '',
                'college_period_from' => $employee->educationalBackground->college_period_from ?? '',
                'college_period_to' => $employee->educationalBackground->college_period_to ?? '',
                'college_awards_received' => $employee->educationalBackground->college_awards_received ?? '',
                'college_educational_attainment' => $employee->educationalBackground->college_educational_attainment ?? '',
    
                'graduate_not_applicable' => $employee->educationalBackground->graduate_not_applicable ?? false,
                'graduate_school_name' => $employee->educationalBackground->graduate_school_name ?? '',
                'graduate_highest_level' => $employee->educationalBackground->graduate_highest_level ?? '',
                'graduate_period_from' => $employee->educationalBackground->graduate_period_from ?? '',
                'graduate_period_to' => $employee->educationalBackground->graduate_period_to ?? '',
                'graduate_awards_received' => $employee->educationalBackground->graduate_awards_received ?? '',
                'graduate_educational_attainment' => $employee->educationalBackground->graduate_educational_attainment ?? '',
            ],
            'civilServiceEligibilities' => [
            'civil_service_eligibility_not_applicable' => $civilServiceEligibility->civil_service_eligibility_not_applicable ?? false,
            'civil_service_data' => collect($civilServiceEligibilityData)->map(function ($eligibility) {
                return [
                    'id' => $eligibility['id'] ?? '',
                    'eligibility' => $eligibility['eligibility'] ?? '',
                    'rating' => $eligibility['rating'] ?? '',
                    'date_of_examination' => $eligibility['date_of_examination'] ?? '',
                    'place_of_examination' => $eligibility['place_of_examination'] ?? '',
                    'license_number' => $eligibility['license_number'] ?? '',
                    'date_of_validity' => $eligibility['date_of_validity'] ?? '',
                ];
            })->toArray(),
        ],

    
        
            
            'workExperiences' => [
                'work_experiences_data' => $workExperiencesData,
            ],
            
            'voluntaryWorkExperiences' => [
            'voluntary_work_not_applicable' => $employee->voluntaryWorkExperiences->first()->voluntary_work_not_applicable ?? false,
            'voluntary_work_experiences_data' => collect($voluntaryWorkExperiencesData)->map(function ($experience) {
                return [
                    'organization_name' => $experience['organization_name'] ?? '',
                    'from_date' => $experience['from_date'] ?? '',
                    'to_date' => $experience['to_date'] ?? '',
                    'hours' => $experience['hours'] ?? '',
                    'position' => $experience['position'] ?? '',
                ];
            })->toArray(),
        ],
                
        
     'learningDevelopment' => [
            'learning_development_experiences_data' => collect($learningDevelopmentData ?? [])->map(function ($experience) {
                return [
                    'id' => $experience['id'] ?? '',
                    'title' => $experience['title'] ?? '',
                    'learningdev_from_date' => $experience['learningdev_from_date'] ?? '',
                    'learningdev_to_date' => $experience['learningdev_to_date'] ?? '',
                    'learningdev_hours' => $experience['learningdev_hours'] ?? '',
                    'learningdev_type' => $experience['learningdev_type'] ?? '',
                    'learningdev_conducted_by' => $experience['learningdev_conducted_by'] ?? '',
                ];
            })->toArray(),
        ],


        'otherInformation' => [
            'special_skills_and_hobbies' => $employee->otherInformation->special_skills_and_hobbies ?? [],
            'non_academic_distinctions' => $employee->otherInformation->non_academic_distinctions ?? [],
            'members_in_organization' => $employee->otherInformation->members_in_organization ?? [],
            'related_to_appointing_authority' => $employee->otherInformation->related_to_appointing_authority ?? [],
            'related_details_third_degree' => $employee->otherInformation->related_details_third_degree ?? [],
            'related_to_appointing_authority_fourth_degree' => $employee->otherInformation->related_to_appointing_authority_fourth_degree ?? '',
            'related_details_fourth_degree' => $employee->otherInformation->related_details_fourth_degree ?? '',
            'guilty_of_offense' => $employee->otherInformation->guilty_of_offense,
            'offense_details' => $employee->otherInformation->offense_details ?? '',
            'criminally_charged' => $employee->otherInformation->criminally_charged,
            'charged_details' => $employee->otherInformation->charged_details ?? '',
            'charged_date' => $employee->otherInformation->charged_date ?? '',
            'charged_status' => $employee->otherInformation->charged_status ?? '',
            'convicted_of_crime' => $employee->otherInformation->convicted_of_crime,
            'conviction_details' => $employee->otherInformation->conviction_details ?? '',
            'separated_from_service' => $employee->otherInformation->separated_from_service,
            'separation_details' => $employee->otherInformation->separation_details ?? '',
            'candidate_in_election' => $employee->otherInformation->candidate_in_election,
            'resigned_for_campaign' => $employee->otherInformation->resigned_for_campaign,
            'resignation_details' => $employee->otherInformation->resignation_details ?? '',
            'immigrant_or_resident' => $employee->otherInformation->immigrant_or_resident,
            'immigrant_details' => $employee->otherInformation->immigrant_details ?? '',
            'member_of_indigenous_group' => $employee->otherInformation->member_of_indigenous_group,
            'indigenous_group_details' => $employee->otherInformation->indigenous_group_details ?? '',
            'person_with_disability' => $employee->otherInformation->person_with_disability,
            'disability_id' => $employee->otherInformation->disability_id ?? '',
            'solo_parent' => $employee->otherInformation->solo_parent,
            'solo_parent_id' => $employee->otherInformation->solo_parent_id ?? '',
            ],
            
            'references' => [
            'reference_detail_data' => collect($referencesData)->map(function ($reference) {
                return [
                    'id' => $reference['id'] ?? '',
                    'name' => $reference['name'] ?? '',
                    'address' => $reference['address'] ?? '',
                    'contact' => $reference['contact'] ?? '',
                ];
            })->toArray(),

            'government_id_type' => $reference->government_id_type ?? '',
            'government_id_type_specification' => $reference->government_id_type_specification ?? '',
            'government_id_number' => $reference->government_id_number ?? '',
            'government_id_date_place' => $reference->government_id_date_place ?? '',  // Ensure this field is correctly fetched
        ],

        ]);
    }
    
    public function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Employee Account')
                        ->schema([
                            Section::make('Employee Account')
                            ->schema([
                            Grid::make(3)
                                ->schema([
                                    // Profile Picture in the first column
                                    FileUpload::make('user.profile_picture')
                                        ->label('Profile Picture')
                                        ->avatar()
                                        ->disk('public')
                                        ->acceptedFileTypes(['image/*'])
                                        ->rules('image')
                                        ->imageEditor()
                                        ->circleCropper()
                                        ->columnSpan(1)
                                        ->extraAttributes(['class' => 'flex justify-center']),         
                                    
                                    // Form fields in the remaining columns
                                    Grid::make(2)
                                        ->schema([
                                            TextInput::make('user.email')
                                                ->label('Email')
                                                ->autocomplete('off')
                                                ->required()
                                                ->email()
                                                ->extraAttributes(['class' => 'flex justify-center']),
                                            Select::make('user.role')
                                                ->label('Role')
                                                ->columnSpan(1)
                                                ->options([
                                                    'admin' => 'Admin',
                                                    'employee' => 'Employee',
                                                ])
                                                ->default('employee')
                                                ->required(),
                                            Toggle::make('reset_password')
                                                ->label('Reset Password')
                                                ->reactive()
                                                ->columnSpan(2)
                                                ->default(false)
                                                ,
                                            Password::make('user.password')
                                                ->label('Password')
                                                ->password()
                                                ->hidden(fn ($get) => !$get('reset_password'))
                                                ->rules('nullable|min:8|regex:/[0-9]/') // Min length 8 and 
                                                ->extraAttributes(['class' => 'flex justify-center']),
                                            Password::make('user.password_confirmation')
                                                ->label('Confirm Password')
                                                ->password()
                                                ->hidden(fn ($get) => !$get('reset_password'))
                                                ->same('user.password')
                                                ->extraAttributes(['class' => 'flex justify-center']),
                                            
                                            
                                        ])
                                        ->columnSpan(2),
                                ])
                                ->columns(3),
                            ]),

                    Section::make('Employee Details')
                        ->schema([
                            Select::make('division_id')
                            ->label('Division')
                            ->columnSpan(2)
                            ->options(Division::all()->pluck('name', 'id')->toArray()),
                            
                            Select::make('employment_status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'Regular' => 'Active',
                                'Contractual' => 'Contractual',
                                'Probationary' => 'Probationary',
                                'Intern' => 'Intern',
                                'Resigned' => 'Resigned',
                                'Retired' => 'Retired',
                            ])
                            ->default('Regular'),

                            TextInput::make('agency_employee_id')
                                ->label('Employee ID')
                                ->columnSpan(4),

                            TextInput::make('position')
                                ->label('Position')
                                ->columnSpan(2),
                            
                            DatePicker::make('date_hired')
                                    ->label('Date Hired')
                                    ->columnSpan(2)
                                    ->required(),

                            DatePicker::make('date_resigned')
                                    ->label('Date Resigned')
                                    ->columnSpan(2)
                                    ->nullable(),
                            
                            DatePicker::make('date_retired')
                                    ->label('Date Retired')
                                    ->columnSpan(2)
                                    ->nullable(),

                            TextInput::make('first_name')
                                ->label('First Name')
                                ->columnSpan(4)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('personal_first_name', $state))
                                ->required(),

                            TextInput::make('last_name')
                                ->label('Last Name')
                                ->columnSpan(4)
                                ->required(),

                            TextInput::make('middle_name')
                                ->label('Middle Name')
                                ->columnSpan(4)
                                ->nullable(),
                            TextInput::make('extension_name')
                                ->label('Suffix')
                                ->columnSpan(4)
                                ->nullable(),
                        ])->columns(5),
                ]),
                Tabs\Tab::make('Personal Information')
                    ->schema([
                        Section::make()
                        ->schema([
                            Section::make('PERSONAL INFORMATION')
                                ->schema([
                                
                                DatePicker::make('personalInformation.date_of_birth')
                                    ->label('Date of Birth')
                                    ->required(),
                                TextInput::make('personalInformation.place_of_birth')
                                    ->label('Place of Birth')
                                    ->required(),
                                Select::make('personalInformation.sex')
                                    ->label('Sex')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                    ])
                                    ->required(),
                                Select::make('personalInformation.civil_status')
                                    ->label('Civil Status')
                                    ->options([
                                        'single' => 'Single',
                                        'married' => 'Married',
                                        'common law' =>'Common Law',
                                        'widowed' => 'Widowed',
                                        'separated' => 'Separated',
                                    ])
                                    ->required(),
                                TextInput::make('personalInformation.height')
                                    ->label('Height (m)')
                                    ->nullable(),
                                TextInput::make('personalInformation.weight')
                                    ->label('Weight (kg)')
                                    ->nullable(),
                                Select::make('personalInformation.blood_type')
                                    ->label('Blood Type')
                                    ->options([
                                        'A' => 'A',
                                        'B' => 'B',
                                        'AB' => 'AB',
                                        'O' => 'O',
                                        'other' => 'Other',
                                    ]),
                                TextInput::make('personalInformation.gsis_id_no')
                                    ->label('GSIS ID No.')
                                    ->nullable(),
                                TextInput::make('personalInformation.pagibig_id_no')
                                    ->label('PAG-IBIG ID No.')
                                    ->nullable(),
                                TextInput::make('personalInformation.philhealth_no')
                                    ->label('PHILHEALTH No.'),
                                TextInput::make('personalInformation.sss_no')
                                    ->label('SSS No.')
                                    ->nullable(),
                                TextInput::make('personalInformation.tin_no')
                                    ->label('TIN No.')
                                    ->nullable(),
                                TextInput::make('personalInformation.agency_employee_no')
                                    ->label('Agency Employee No.')
                                    ->nullable(),
                                Select::make('personalInformation.citizenship')
                                    ->label('Citizenship')
                                    ->options([
                                        'filipino' => 'Filipino',
                                        'dual_citizen' => 'Dual Citizenship',
                                    ])
                                    ->reactive() 
                                    ->required(),
                                TextInput::make('personalInformation.citizenship_by')
                                    ->label('Citizenship By')
                                    ->disabled(fn ($get) => $get('personalInformation.citizenship') === 'filipino')
                                    ->nullable(),
                                TextInput::make('personalInformation.dual_citizenship_country')
                                    ->label('Dual Citizenship Country')
                                    ->disabled(fn ($get) => $get('personalInformation.citizenship') === 'filipino')
                                    ->nullable(),
                                ])->Icon('heroicon-o-user')
                                ->columns(4),
    
                                Section::make('RESIDENTIAL ADDRESS')
                                ->schema([
                                    Select::make('personalInformation.residential_province_id')
                                    ->live(onBlur: true)
                                    
                                    ->label('Residential Address - Province')
                                    ->placeholder('Province')
                                    ->options(Province::all()->pluck('name', 'id')->toArray())
                                
                                    ->hiddenLabel()
                                    ->required(),
                        
                                Select::make('personalInformation.residential_city_id')
                                    ->label('Residential Address - City/Municipality')
                                    ->placeholder('City/Municipality')
                                    ->options(fn($get) => $get('personalInformation.residential_province_id') 
                                        ? City::where('province_id', $get('personalInformation.residential_province_id'))->pluck('name', 'id')->toArray() 
                                        : [])
                                        ->hiddenLabel()
                                        ->required(),
                                    TextInput::make('personalInformation.residential_barangay')
                                        ->label('Residential Address - Barangay')
                                        ->placeholder('Barangay')
                                        ->hiddenLabel()
                                        ->required(),
                                    TextInput::make('personalInformation.residential_subdivision_village')
                                        ->label('Residential Address - Subdivision')
                                        ->placeholder('Subdivision')
                                        ->hiddenLabel()
                                        ->nullable(),
                                    TextInput::make('personalInformation.residential_street')
                                        ->label('Residential Address - Street')
                                        ->placeholder('Street')
                                        ->hiddenLabel()
                                        ->nullable(),
                                    TextInput::make('personalInformation.residential_house_block_lot_no')
                                        ->label('Residential Address - House/Block/Lot No.')
                                        ->placeholder('House/Block/Lot No.')
                                        ->hiddenLabel()
                                        ->nullable(),
                                ])->columns(3),
    
                            Section::make('PERMANENT ADDRESS')
                                ->schema([
                                    Checkbox::make('personalInformation.permanent_address_same_as_residential')
                                        ->columnSpanFull()
                                        ->default(false)
                                        ->live(onBlur: true)
                                        // 
                                        ->label('Same with the Residential')
                                        ->reactive()
                                       
                                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                            if ($state) {
                                                // Retrieve names using IDs
                                                $provinceName = Province::find($get('personalInformation.residential_province_id'))->name ?? null;
                                                $cityName = City::find($get('personalInformation.residential_city_id'))->name ?? null;
            
                                                // Copy residential address to permanent address and disable the fields
                                                $set('personalInformation.permanent_province', $provinceName);
                                                $set('personalInformation.permanent_city', $cityName);
                                                $set('personalInformation.permanent_barangay', $get('personalInformation.residential_barangay'));
                                                $set('personalInformation.permanent_subdivision', $get('personalInformation.residential_subdivision_village'));
                                                $set('personalInformation.permanent_street', $get('personalInformation.residential_street'));
                                                $set('personalInformation.permanent_house_number', $get('personalInformation.residential_house_block_lot_no'));
                                            } else {
                                                // Reset permanent address fields if not same as residential
                                                $set('personalInformation.permanent_province', null);
                                                $set('personalInformation.permanent_city', null);
                                                $set('personalInformation.permanent_barangay', null);
                                                $set('personalInformation.permanent_subdivision', null);
                                                $set('personalInformation.permanent_street', null);
                                                $set('personalInformation.permanent_house_number', null);
                                            }
                                        }),
    
                                    Group::make([
                                        TextInput::make('personalInformation.permanent_province')
                                            ->label('Permanent Address - Province')
                                            ->placeholder('Province')
                                            ->placeholder('Select Province')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('personalInformation.permanent_address_same_as_residential')),
                                        TextInput::make('personalInformation.permanent_city')
                                            ->label('Permanent Address - City/Municipality')
                                            ->placeholder('City/Municipality')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('personalInformation.permanent_address_same_as_residential')),
                                        TextInput::make('personalInformation.permanent_barangay')
                                            ->label('Permanent Address - Barangay')
                                            ->placeholder('Barangay')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('personalInformation.permanent_address_same_as_residential')),
                                        TextInput::make('personalInformation.permanent_subdivision')
                                            ->label('Permanent Address - Subdivision')
                                            ->placeholder('Subdivision')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('personalInformation.permanent_address_same_as_residential')),
                                        TextInput::make('personalInformation.permanent_street')
                                            ->label('Permanent Address - Street')
                                            ->placeholder('Street')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('personalInformation.permanent_address_same_as_residential')),
                                        TextInput::make('personalInformation.permanent_house_number')
                                            ->label('Permanent Address - House/Block/Lot No.')
                                            ->placeholder('House/Block/Lot No.')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('personalInformation.permanent_address_same_as_residential')),
                                    ])->columns(3),
                                    ]),
                                Section::make('CONTACTS')
                                    ->schema([
                                        TextInput::make('personalInformation.telephone_number')
                                            ->label('Telephone Number')
                                            ->nullable(),
                                        TextInput::make('personalInformation.mobile_number')
                                            ->label('Mobile Number')
                                            ->required(),
                                        TextInput::make('personalInformation.email_address')
                                            ->label('Email Address')
                                            ->nullable(),
                                    ])->columns(2),
                         ])
                     ]),

                

                Tabs\Tab::make('Family Background')
                    ->schema([
                        Section::make('FAMILY BACKGROUND')
                    ->schema([
                    Section::make('Spouce Information')
                    ->schema([
                            //Spouce Info
                            Checkbox::make('familyBackground.spouse_not_applicable')
                            ->columnSpanFull()
                            ->live()
                            ->default(false)
                            
                            ->label('Please Check if not applicable'),
                            Group::make([
                                TextInput::make('familyBackground.spouse_last_name')
                                ->hiddenLabel()
                                    ->placeholder('Spouse\'s Surname'),
                                TextInput::make('familyBackground.spouse_first_name')
                                ->hiddenLabel()
                                    ->placeholder('Spouse\'s First Name'),
                                TextInput::make('familyBackground.spouse_middle_name')
                                ->hiddenLabel()
                                    ->placeholder('Spouse\'s Middle Name'),
                                TextInput::make('familyBackground.spouse_name_extension')
                                ->hiddenLabel()
                                    ->placeholder('Spouse\'s Name Extension')        
                            ])->columns(4)
                            ->hidden(fn (Get $get) => $get('familyBackground.spouse_not_applicable')),
                            ]),
                        Section::make('Father Information')
                        ->schema([
                                //Father Info
                                Checkbox::make('familyBackground.father_not_applicable')
                                ->columnSpanFull()
                                ->live()
                                ->default(false)
                                ->label('Please Check if not applicable'),

                                Group::make([
                                TextInput::make('familyBackground.father_last_name')
                                ->hiddenLabel()
                                ->placeholder('Father\'s Surname'),
                                TextInput::make('familyBackground.father_first_name')
                                ->hiddenLabel()   
                                ->placeholder('Father\'s First Name'),
                                TextInput::make('familyBackground.father_middle_name')
                                ->hiddenLabel()
                                ->placeholder('Father\'s Middle Name'),
                                TextInput::make('familyBackground.father_name_extension')
                                ->hiddenLabel()
                                ->placeholder('Father\'s Name Extension'),
                                ])->columns(4)
                                ->hidden(fn (Get $get) => $get('familyBackground.father_not_applicable')),
                                ]),
                    
                        Section::make('Mother Information')
                        ->schema([
                        //Mothers Info
                        Checkbox::make('familyBackground.mother_not_applicable')
                        ->columnSpanFull()
                        ->live()
                        ->default(false)
                        
                        ->label('Please Check if not applicable'),
                            Group::make([
                                TextInput::make('familyBackground.mother_maiden_surname')
                                ->hiddenLabel()
                                    ->placeholder('Mother\'s Maiden Surname'),
                                TextInput::make('familyBackground.mother_first_name')
                                ->hiddenLabel()
                                    ->placeholder('Mother\'s First Name'),
                                TextInput::make('familyBackground.mother_middle_name')
                                ->hiddenLabel()
                                    ->placeholder('Mother\'s Middle Name'),
                                TextInput::make('familyBackground.mother_name_extension')
                                ->hiddenLabel()
                                    ->placeholder('Mother\'s Name Extension')
                            ])->columns(4)
                            ->hidden(fn (Get $get) => $get('familyBackground.mother_not_applicable')),
                        ]),
        
                        Section::make('Children Information')
                        ->schema([
                            Checkbox::make('familyBackground.children_not_applicable')
                                ->columnSpanFull()
                                ->live()
                                ->default(false)
                                
                                ->label('Please Check if not applicable'),
                            Repeater::make('familyBackground.children')
                                ->schema([
                                    TextInput::make('children_surname')
                                        ->label('Children\'s Surname')
                                        ->placeholder('Surname')
                                        ->hiddenLabel(),
                                    TextInput::make('children_first_name')
                                        ->label('Children\'s First Name')
                                        ->placeholder('First Name')
                                        ->hiddenLabel(),
                                    TextInput::make('children_middle_name')
                                        ->label('Children\'s Middle Name')
                                        ->placeholder('Middle Name')
                                        ->hiddenLabel(),
                                    TextInput::make('children_name_extension')
                                        ->label('Children\'s Name Extension')
                                        ->placeholder('Name Extension')
                                        ->hiddenLabel()
                                ])->columns(4)
                                  ->hidden(fn (Get $get) => $get('familyBackground.children_not_applicable')),
                        ])
                        ])->Icon('heroicon-o-user-group')
                        
                    ]),
                    Tabs\Tab::make('Educational Background')
                    ->schema([
                        Section::make('EDUCATIONAL BACKGROUND')
                        ->schema([
                            
                            Section::make('Elementary')
                                ->schema([
                                    TextInput::make('educationalBackground.elementary_school_name')
                                        ->label('School Name')
                                        ->columnSpanFull()
                                        ->placeholder('Enter Elementary School Name'),
                                    TextInput::make('educationalBackground.elementary_highest_level')
                                        ->label('Highest Level/Units Earned (if not graduated)')
                                        ->placeholder('Enter highest level/units earned')
                                        ->nullable(),
                                    DatePicker::make('educationalBackground.elementary_period_from')
                                        ->label('Period of Attendance From:')
                                        ->nullable(),
                                    DatePicker::make('educationalBackground.elementary_period_to')
                                        ->label('Period of Attendance To:')
                                        ->nullable(),
                                    TextInput::make('educationalBackground.elementary_awards_received')
                                        ->label('Awards Received')
                                        ->placeholder('Awards Received (if any)')
                                        ->nullable(),
                                    TextInput::make('educationalBackground.elementary_educational_attainment')
                                        ->label('Educational Attainment')
                                        ->columnSpan(2)
                                        ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                        ->nullable(),
                                ])->columns(3),

                            Section::make('Secondary')
                                ->schema([
                                    TextInput::make('educationalBackground.secondary_school_name')
                                        ->label('School Name')
                                        ->columnSpanFull()
                                        ->placeholder('Enter Secondary School Name'),
                                    TextInput::make('educationalBackground.secondary_highest_level')
                                        ->label('Highest Level/Units Earned (if not graduated)')
                                        ->placeholder('Enter highest level/units earned')
                                        ->nullable(),
                                    DatePicker::make('educationalBackground.secondary_period_from')
                                        ->label('Period of Attendance From:')
                                        ->nullable(),
                                    DatePicker::make('educationalBackground.secondary_period_to')
                                        ->label('Period of Attendance To:')
                                        ->nullable(),
                                    TextInput::make('educationalBackground.secondary_awards_received')
                                        ->label('Awards Received')
                                        ->placeholder('Awards Received (if any)')
                                        ->nullable(),
                                    TextInput::make('educationalBackground.secondary_educational_attainment')
                                        ->label('Educational Attainment')
                                        ->columnSpan(2)
                                        ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                        ->nullable(),
                                ])->columns(3),

                                Section::make('Vocational/Trade Course')
                                ->schema([
                                    Checkbox::make('educationalBackground.vocational_not_applicable')
                                        ->columnSpanFull()
                                        ->live()
                                        ->default(false)
                                        
                                        ->label('Not Applicable'),
                            
                                    Group::make([
                                        TextInput::make('educationalBackground.vocational_school_name')
                                            ->label('School Name')
                                            ->columnSpanFull()
                                            ->placeholder('Enter Vocational/Trade School Name'),
                            
                                        TextInput::make('educationalBackground.vocational_highest_level')
                                            ->label('Highest Level/Units Earned (if not graduated)')
                                            ->placeholder('Enter highest level/units earned')
                                            ->nullable(),
                            
                                        DatePicker::make('educationalBackground.vocational_period_from')
                                            ->label('Period of Attendance From:')
                                            ->nullable(),
                            
                                        DatePicker::make('educationalBackground.vocational_period_to')
                                            ->label('Period of Attendance To:')
                                            ->nullable(),
                            
                                        TextInput::make('educationalBackground.vocational_awards_received')
                                            ->label('Awards Received')
                                            ->placeholder('Awards Received (if any)')
                                            ->nullable(),
                            
                                        TextInput::make('educationalBackground.vocational_educational_attainment')
                                            ->label('Educational Attainment')
                                            ->columnSpan(2)
                                            ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                            ->nullable(),
                                    ])->columns(3)
                                        ->hidden(fn (Get $get) => $get('educationalBackground.vocational_not_applicable')),
                                ]),

                            Section::make('College')
                                ->schema([
                                    TextInput::make('educationalBackground.college_school_name')
                                        ->label('School Name')
                                        ->columnSpanFull()
                                        ->placeholder('Enter College/University Name'),
                                    TextInput::make('educationalBackground.college_highest_level')
                                        ->label('Highest Level/Units Earned (if not graduated)')
                                        ->placeholder('Enter highest level/units earned')
                                        ->nullable(),
                                    DatePicker::make('educationalBackground.college_period_from')
                                        ->label('Period of Attendance From:')
                                        ->nullable(),
                                    DatePicker::make('educationalBackground.college_period_to')
                                        ->label('Period of Attendance To:')
                                        ->nullable(),
                                    TextInput::make('educationalBackground.college_awards_received')
                                        ->label('Awards Received')
                                        ->placeholder('Awards Received (if any)')
                                        ->nullable(),
                                    TextInput::make('educationalBackground.college_educational_attainment')
                                        ->label('Educational Attainment')
                                        ->columnSpan(2)
                                        ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                        ->nullable(),
                                ])->columns(3),

                                Section::make('Graduate Studies')
                                ->schema([
                                    Checkbox::make('educationalBackground.graduate_not_applicable')
                                        ->columnSpanFull()
                                        ->live()
                                        ->default(false)
                                        
                                        ->label('Not Applicable'),
                            
                                    Group::make([
                                        TextInput::make('educationalBackground.graduate_school_name')
                                            ->label('School Name')
                                            ->columnSpanFull()
                                            ->placeholder('Enter Graduate School Name')
                                            ->required(),
                            
                                        TextInput::make('educationalBackground.graduate_highest_level')
                                            ->label('Highest Level/Units Earned (if not graduated)')
                                            ->placeholder('Enter highest level/units earned')
                                            ->nullable(),
                            
                                        DatePicker::make('educationalBackground.graduate_period_from')
                                            ->label('Period of Attendance From:')
                                            ->nullable(),
                            
                                        DatePicker::make('educationalBackground.graduate_period_to')
                                            ->label('Period of Attendance To:')
                                            ->nullable(),
                            
                                        TextInput::make('educationalBackground.graduate_awards_received')
                                            ->label('Awards Received')
                                            ->placeholder('Awards Received (if any)')
                                            ->nullable(),
                            
                                        TextInput::make('educationalBackground.graduate_educational_attainment')
                                            ->label('Educational Attainment')
                                            ->columnSpan(2)
                                            ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                            ->nullable(),
                                    ])->columns(3)
                                        ->hidden(fn (Get $get) => $get('educationalBackground.graduate_not_applicable')),
                                ]),

                        ])->Icon('heroicon-o-academic-cap'),
                    ]),
                    Tabs\Tab::make('Civil Service Eligibility')
                    ->schema([
                        Section::make('CIVIL SERVICE ELIGIBILITIES')
                        ->schema([
                            Checkbox::make('civilServiceEligibilities.civil_service_eligibility_not_applicable')
                                ->columnSpanFull()
                                ->live()
                                ->default(false)
                                ->label('Check if not applicable'),
            
                            Group::make([
                                Repeater::make('civilServiceEligibilities.civil_service_data')
                                    ->schema([
                                        Section::make('Civil Service Eligibility Details')
                                            ->schema([
                                                TextInput::make('eligibility')
                                                    ->label("CAREER SERVICE/RA 1080 (BOARD/BAR) UNDER SPECIAL LAWS/CES CSEE BARANGAY ELIGIBILITY/DRIVER'S LICENSE")
                                                    ->placeholder('Enter Civil Service Eligibility')
                                                    ->hidden(fn (Get $get) => $get('civilServiceEligibilities.civil_service_eligibility_not_applicable')),
            
                                                TextInput::make('rating')
                                                    ->label('Rating (if applicable)')
                                                    ->placeholder('Enter Rating')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('civilServiceEligibilities.civil_service_eligibility_not_applicable')),
            
                                                DatePicker::make('date_of_examination')
                                                    ->label('Date of Examination/Conferment')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('civilServiceEligibilities.civil_service_eligibility_not_applicable')),
            
                                                TextInput::make('place_of_examination')
                                                    ->label('Place of Examination/Conferment')
                                                    ->placeholder('Enter Place')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('civilServiceEligibilities.civil_service_eligibility_not_applicable')),

                                                TextInput::make('license_number')
                                                    ->label('License Number')
                                                    ->placeholder('Enter License Number')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('civilServiceEligibilities.civil_service_eligibility_not_applicable')),
            
                                                DatePicker::make('date_of_validity')
                                                    ->label('Date of Validity')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('civilServiceEligibilities.civil_service_eligibility_not_applicable')),
                                                
                                            ])
                                    ])
                                    ->hiddenLabel()
                                    ->columns(1)
                                    ->hidden(fn (Get $get) => $get('civilServiceEligibilities.civil_service_eligibility_not_applicable')),
                            ]),
                        ])
                        ->icon('heroicon-o-users'),
                    ]),
                    Tabs\Tab::make('Work Experience')
                    ->schema([
                        Section::make('WORK EXPERIENCE')
                        ->schema([
                            Checkbox::make('workExperiences.work_experience_not_applicable')
                                ->columnSpanFull()
                                ->live()
                                ->default(false)
                                
                                ->label('Check if not applicable'),
            
                            Group::make([
                                Repeater::make('workExperiences.work_experiences_data')
                                    ->schema([
                                        Section::make('Work Experience Details')
                                            ->schema([
                                                DatePicker::make('inclusive_dates_from')
                                                    ->label('Inclusive Dates (From)')
                                                    ->placeholder('mm/dd/yy')
                                                    ->hidden(fn (Get $get) => $get('workExperiences.work_experience_not_applicable')),
            
                                                DatePicker::make('inclusive_dates_to')
                                                    ->label('Inclusive Dates (To)')
                                                    ->placeholder('mm/dd/yy')
                                                    ->hidden(fn (Get $get) => $get('workExperiences.work_experience_not_applicable')),
            
                                                TextInput::make('position_title')
                                                    ->label('Position Title')
                                                    ->placeholder('Enter Position Title')
                                                    ->hidden(fn (Get $get) => $get('workExperiences.work_experience_not_applicable')),
            
                                                TextInput::make('department_agency_office_company')
                                                    ->label('Department/Agency/Office/Company')
                                                    ->placeholder('Enter Department/Agency/Office/Company')
                                                    ->hidden(fn (Get $get) => $get('workExperiences.work_experience_not_applicable')),
            
                                                TextInput::make('monthly_salary')
                                                    ->label('Monthly Salary')
                                                    ->placeholder('Enter Monthly Salary')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('workExperiences.work_experience_not_applicable')),
            
                                                TextInput::make('salary_grade_and_step')
                                                    ->label('Salary/Job Grade & Step (if applicable)')
                                                    ->placeholder('Enter Salary/Job Grade & Step')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('workExperiences.work_experience_not_applicable')),
            
                                                TextInput::make('status_of_appointment')
                                                    ->label('Status of Appointment')
                                                    ->placeholder('Enter Status of Appointment')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('workExperiences.work_experience_not_applicable')),
            
                                                    Radio::make('government_service')
                                                    ->label('Government Service?')
                                                    ->nullable()
                                                    ->columnSpanFull()
                                                    ->boolean()
                                                    ->inline()
                                                    ->inlineLabel(false)
                                                    ->hidden(fn (Get $get) => $get('workExperiences.work_experience_not_applicable')),
                                            ])->columns(2),
                                ])->hiddenLabel()
                                    ->columns(1)
                                    ->hidden(fn (Get $get) => $get('workExperiences.work_experience_not_applicable')),
                            ]),
                        ])->Icon('heroicon-o-user-group'),
                    ]),
                    Tabs\Tab::make('Voluntary Work')
                    ->schema([
                        Section::make('VOLUNTARY WORK')
                        ->schema([
                            Checkbox::make('voluntaryWorkExperiences.voluntary_work_not_applicable')
                                ->columnSpanFull()
                                ->live()
                                ->default(false)
                                
                                ->label('Check if not applicable'),

                            Group::make([
                                Repeater::make('voluntaryWorkExperiences.voluntary_work_experiences_data')
                                    ->schema([
                                        Section::make('Voluntary Work Details')
                                            ->schema([
                                                TextInput::make('organization_name')
                                                    ->label('Name & Address of Organization')
                                                    ->placeholder('Enter Organization Name & Address')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
                                                Group::make([
                                                    DatePicker::make('from_date')
                                                        ->label('Inclusive Dates (From)')

                                                        ->nullable()
                                                        ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
                                                    
                                                    DatePicker::make('to_date')
                                                        ->label('Inclusive Dates (To)')
                                                        ->nullable()
                                                        ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
                                                ])->label('Inclusive Dates')
                                                ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),

                                                TextInput::make('hours')
                                                    ->label('Number of Hours')
                                                    ->placeholder('Enter Number of Hours')
                                                    ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),

                                                TextInput::make('position')
                                                    ->label('Position/Nature of Work')
                                                    ->placeholder('Enter Position/Nature of Work')
                                                    ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
                                            ])
                                            
                                        ])->hiddenLabel()
                                        ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
                            ]),
                        ])->Icon('heroicon-o-users'),
                    ]),
                    Tabs\Tab::make('Learning & Development')
                    ->schema([
                        Section::make('LEARNING & DEVELOPMENT')
                        ->schema([
                            Checkbox::make('learningDevelopment.learning_development_not_applicable')
                                ->columnSpanFull()
                                ->live()
                                ->default(false)
                                
                                ->label('Check if not applicable'),
            
                            Group::make([
                                Repeater::make('learningDevelopment.learning_development_experiences_data')
                                    ->schema([
                                        Section::make('Learning & Development Details')
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Title of Learning and Development Interventions/Training Programs')
                                                    ->placeholder('Enter Title')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('learningDevelopment.learning_development_not_applicable')),
            
                                                Group::make([
                                                    DatePicker::make('learningdev_from_date')
                                                        ->label('Inclusive Dates (From)')

                                                        ->nullable()
                                                        ->hidden(fn (Get $get) => $get('learningDevelopment.learning_development_not_applicable')),
                                                    
                                                    DatePicker::make('learningdev_to_date')
                                                        ->label('Inclusive Dates (To)')

                                                        ->nullable()
                                                        ->hidden(fn (Get $get) => $get('learningDevelopment.learning_development_not_applicable')),
                                                ])->label('Inclusive Dates')
                                                  ->hidden(fn (Get $get) => $get('learningDevelopment.learning_development_not_applicable')),
            
                                                TextInput::make('learningdev_hours')
                                                    ->label('Number of Hours')
                                                    ->placeholder('Enter Number of Hours')
                                                    ->nullable()
                                                    ->hidden(fn (Get $get) => $get('learningDevelopment.learning_development_not_applicable')),
            
                                                TextInput::make('learningdev_type')
                                                    ->label('Type of LD (Managerial / Supervisory / Technical / etc.)')
                                                    ->nullable()
                                                    ->placeholder('Enter Type')
                                                    ->hidden(fn (Get $get) => $get('learningDevelopment.learning_development_not_applicable')),
            
                                                TextInput::make('learningdev_conducted_by')
                                                    ->label('Conducted/Sponsored By')
                                                    ->nullable()
                                                    ->placeholder('Enter Conducted/Sponsored By')
                                                    ->hidden(fn (Get $get) => $get('learningDevelopment.learning_development_not_applicable')),
                                            ])
                                            
                                    ])->hiddenLabel()
                                    ->hidden(fn (Get $get) => $get('learningDevelopment.learning_development_not_applicable')),
                            ]),
                        ])->Icon('heroicon-o-presentation-chart-line'),
                    ]),
                    Tabs\Tab::make('Other Information')
                    ->schema([
                        Section::make('OTHER INFORMATION')
                            ->schema([
                                Group::make([
                                    Repeater::make('otherInformation.special_skills_and_hobbies')
                                        ->schema([
                                            Section::make('Special Skills and Hobbies')
                                                ->schema([
                                                    TextInput::make('skill_or_hobby')
                                                        ->label('Special Skill or Hobby')
                                                        ->placeholder('Enter Special Skill or Hobby')
                                                        ->columnSpanFull(),
                                                ])->columns(2),
                                        ])->hiddenLabel(),
                                        
                                    Repeater::make('otherInformation.non_academic_distinctions')
                                        ->schema([
                                            Section::make('Non-Academic Distinctions/Recognition')
                                                ->schema([
                                                    TextInput::make('distinction')
                                                        ->label('Non-Academic Distinction/Recognition')
                                                        ->placeholder('Enter Non-Academic Distinction/Recognition')
                                                        ->columnSpanFull(),
                                                ])->columns(2),
                                        ])->hiddenLabel(),
                                        
                                    Repeater::make('otherInformation.members_in_organization')
                                        ->schema([
                                            Section::make('Members in Association/Organization')
                                                ->schema([
                                                    TextInput::make('organization_name')
                                                        ->label('Name of Association/Organization')
                                                        ->placeholder('Enter Name of Association/Organization')
                                                        ->columnSpanFull(),
                                                ])->columns(2),
                                        ])->hiddenLabel(),
                                ])->columns(3),
                                
                                Section::make("YES OR NO QUESTIONS")
                                ->schema([
                                    Section::make('1. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed?')
                                        ->schema([
                                            Radio::make('otherInformation.related_to_appointing_authority')
                                                ->label('a. within the third degree?')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.related_details_third_degree')
                                                ->label('If YES, please give details:')
                                                ->placeholder('Enter details')
                                                ->hidden(fn ($get) => !$get('otherInformation.related_to_appointing_authority')),
                                            
                                            Radio::make('otherInformation.related_to_appointing_authority_fourth_degree')
                                                ->label('b. within the fourth degree (for Local Government Unit - Career Employees)?')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.related_details_fourth_degree')
                                                ->label('If YES, please give details:')
                                                ->placeholder('Enter details')
                                                ->hidden(fn ($get) => !$get('otherInformation.related_to_appointing_authority_fourth_degree')),
                                        ]),
                                    
                                    Section::make('2. Have you ever been found guilty of any administrative offense?')
                                        ->schema([
                                            Radio::make('otherInformation.guilty_of_offense')
                                                ->label(' ')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.offense_details')
                                                ->label('If YES, please give details:')
                                                ->placeholder('Enter details')
                                                ->hidden(fn ($get) => !$get('otherInformation.guilty_of_offense')),
                                        ]),
                                    
                                    Section::make('3. Have you ever been criminally charged before any court?')
                                        ->schema([
                                            Radio::make('otherInformation.criminally_charged')
                                                ->label(' ')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.charged_details')
                                                ->label('If YES, please give details:')
                                                ->placeholder('Enter details')
                                                ->hidden(fn ($get) => !$get('otherInformation.criminally_charged')),
                                            
                                            DatePicker::make('otherInformation.charged_date')
                                                ->label('Date Filed:')
                                                ->placeholder('Enter Date Filed')
                                                ->hidden(fn ($get) => !$get('otherInformation.criminally_charged')),
                                            
                                            TextInput::make('otherInformation.charged_status')
                                                ->label('Status of Case/s:')
                                                ->placeholder('Enter Status of Case/s')
                                                ->hidden(fn ($get) => !$get('otherInformation.criminally_charged')),
                                        ]),
                                    
                                    Section::make('4. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?')
                                        ->schema([
                                            Radio::make('otherInformation.convicted_of_crime')
                                                ->label(' ')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.conviction_details')
                                                ->label('If YES, please give details:')
                                                ->placeholder('Enter details')
                                                ->hidden(fn ($get) => !$get('otherInformation.convicted_of_crime')),
                                        ]),
                                    
                                    Section::make('5. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?')
                                        ->schema([
                                            Radio::make('otherInformation.separated_from_service')
                                                ->label(' ')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.separation_details')
                                                ->label('If YES, please give details:')
                                                ->placeholder('Enter details')
                                                ->hidden(fn ($get) => !$get('otherInformation.separated_from_service')),
                                        ]),
                                    
                                    Section::make('6. Have you ever been a candidate in a national or local election held within the last year (except Barangay Election)?')
                                        ->schema([
                                            Radio::make('otherInformation.candidate_in_election')
                                                ->label(' ')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Section::make('7. Have you resigned from the government service during the three(3)-month period before the last election to promote/actively campaign for a national or local candidate?')
                                        ->schema([
                                            Radio::make('otherInformation.resigned_for_campaign')
                                                ->label(' ')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.resignation_details')
                                                ->label('If YES, please give details:')
                                                ->placeholder('Enter details')
                                                ->hidden(fn ($get) => !$get('otherInformation.resigned_for_campaign')),
                                        ]),
                                    
                                    Section::make('8. Have you acquired the status of an immigrant or permanent resident of another country?')
                                        ->schema([
                                            Radio::make('otherInformation.immigrant_or_resident')
                                                ->label(' ')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.immigrant_details')
                                                ->label('If YES, please give details (country):')
                                                ->placeholder('Enter details')
                                                ->hidden(fn ($get) => !$get('otherInformation.immigrant_or_resident')),
                                        ]),
                                    
                                    Section::make('9. Pursuant to: (a) Indigenous People\'s Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:')
                                        ->schema([
                                            Radio::make('otherInformation.member_of_indigenous_group')
                                                ->label('a. Are you a member of any indigenous group?')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.indigenous_group_details')
                                                ->label('If YES, please specify:')
                                                ->placeholder('Enter details')
                                                ->hidden(fn ($get) => !$get('otherInformation.member_of_indigenous_group')),
                                            
                                            Radio::make('otherInformation.person_with_disability')
                                                ->label('b. Are you a person with disability?')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.disability_id')
                                                ->label('If YES, please specify ID No:')
                                                ->placeholder('Enter ID No')
                                                ->hidden(fn ($get) => !$get('otherInformation.person_with_disability')),
                                            
                                            Radio::make('otherInformation.solo_parent')
                                                ->label('c. Are you a solo parent?')
                                                ->options([
                                                    true => 'Yes',
                                                    false => 'No',
                                                ])
                                                ->reactive()
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('otherInformation.solo_parent_id')
                                                ->label('If YES, please specify ID:')
                                                ->placeholder('Enter ID')
                                                ->hidden(fn ($get) => !$get('otherInformation.solo_parent')),
                                        ]),
                                ])->columns(1),
                            ])->Icon('heroicon-o-archive-box-arrow-down'),

                    ]),
                    Tabs\Tab::make('References')
                    ->schema([
                        Section::make('REFERENCES')
                            ->schema([
                                Repeater::make('references.reference_detail_data')
                                    ->schema([
                                        Section::make('Reference Details')
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Name')
                                                    ->placeholder('Enter Name')
                                                    ->required(),
                                
                                                TextInput::make('address')
                                                    ->label('Address')
                                                    ->placeholder('Enter Address')
                                                    ->required(),
                                
                                                TextInput::make('contact')
                                                    ->label('Contact No.')
                                                    ->placeholder('Enter Contact No.'),
                                            ])->columns(3),
                                    ])->hiddenLabel(),
                            ])->Icon('heroicon-o-identification')->hiddenLabel(),

                            Section::make('Government Issued ID')
                            ->schema([
                                Select::make('references.government_id_type')
                                    ->label('Government Issued ID')
                                    ->options([
                                        'passport' => 'Passport',
                                        'gsis' => 'GSIS',
                                        'sss' => 'SSS',
                                        'prc' => 'PRC',
                                        'drivers_license' => "Driver's License",
                                        'other' => 'Other',
                                    ])
                                    ->reactive()
                                    ->required(),
                                        
                                    TextInput::make('references.government_id_type_specification')
                                    ->label('Please specify:')
                                    ->placeholder('Enter details')
                                    ->hidden(fn ($get) => $get('references.government_id_type') !== 'other'),
                        
                                TextInput::make('references.government_id_number')
                                    ->label('ID/License/Passport No.')
                                    ->placeholder('Enter ID Number')
                                    ->required(),
                        
                                DatePicker::make('references.government_id_date_place')
                                    ->label('Date/Place of Issuance')
                                    ->placeholder('Enter Date/Place of Issuance')
                                    ->required(),
                            ])->columns(1),
                        ])->hiddenLabel()
                ]) ->contained(false) ->columnSpan('full')
            
            ]);
    }
    
    
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        DB::transaction(function () use ($record, $data) {
            $employee = $record;

            // Update employee basic information
            $employee->update([
                'division_id' => $data['division_id'],
                'agency_employee_id' => $data['agency_employee_id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'middle_name' => $data['middle_name'],
                'extension_name' => $data['extension_name'],
                'position' => $data['position'],
                'employment_status' => $data['employment_status'],
                'date_hired' => $data['date_hired'],
                'date_resigned' => $data['date_resigned'],
                'date_retired' => $data['date_retired'],
            ]);

            // Update user information
        if (!empty($data['user'])) {
            $user = $employee->user;

            // Update user details except password
            $user->update([
                'email' => $data['user']['email'],
                'profile_picture' => $data['user']['profile_picture'],
                'role' => $data['user']['role'],
                // Password will be handled separately
            ]);

            // Update password only if provided
            if (!empty($data['user']['password'])) {
                if ($data['user']['password'] === $data['user']['password_confirmation']) {
                    $user->password = $data['user']['password']; // Hashing handled in the User model
                } else {
                    throw new \Exception('Passwords do not match.');
                }
            }

            $user->save();
        }

            // Update personal information
            if (!empty($data['personalInformation'])) {
                $employee->personalInformation->update($data['personalInformation']);
            }

            // Update family background
            if (!empty($data['familyBackground'])) {
                $employee->familyBackground->update($data['familyBackground']);
            }

            // Update educational background
            if (!empty($data['educationalBackground'])) {
                $employee->educationalBackground->update($data['educationalBackground']);
            }

            // Update civil service eligibilities
            if (!empty($data['civilServiceEligibilities'])) {
                $civilServiceEligibility = $employee->civilServiceEligibilities->first();
                if ($civilServiceEligibility) {
                    $civilServiceEligibility->update([
                        'civil_service_eligibility_not_applicable' => $data['civilServiceEligibilities']['civil_service_eligibility_not_applicable'],
                        'civil_service_data' => json_encode($data['civilServiceEligibilities']['civil_service_data'] ?? []),
                    ]);
                } else {
                    CivilServiceEligibility::create([
                        'employee_id' => $employee->id,
                        'civil_service_eligibility_not_applicable' => $data['civilServiceEligibilities']['civil_service_eligibility_not_applicable'],
                        'civil_service_data' => json_encode($data['civilServiceEligibilities']['civil_service_data'] ?? []),
                    ]);
                }
            }

            // Update work experiences
            if (!empty($data['workExperiences'])) {
                $workExperience = $employee->workExperiences->first();
                if ($workExperience) {
                    $workExperience->update([
                        'work_experiences_data' => json_encode($data['workExperiences']['work_experiences_data'] ?? []),
                    ]);
                } else {
                    WorkExperience::create([
                        'employee_id' => $employee->id,
                        'work_experiences_data' => json_encode($data['workExperiences']['work_experiences_data'] ?? []),
                    ]);
                }
            }

            // Update voluntary work experiences
            if (!empty($data['voluntaryWorkExperiences'])) {
                $voluntaryWorkExperience = $employee->voluntaryWorkExperiences->first();
                if ($voluntaryWorkExperience) {
                    $voluntaryWorkExperience->update([
                        'voluntary_work_not_applicable' => $data['voluntaryWorkExperiences']['voluntary_work_not_applicable'],
                        'voluntary_work_experiences_data' => json_encode($data['voluntaryWorkExperiences']['voluntary_work_experiences_data'] ?? []),
                    ]);
                } else {
                    VoluntaryWorkExperience::create([
                        'employee_id' => $employee->id,
                        'voluntary_work_not_applicable' => $data['voluntaryWorkExperiences']['voluntary_work_not_applicable'],
                        'voluntary_work_experiences_data' => json_encode($data['voluntaryWorkExperiences']['voluntary_work_experiences_data'] ?? []),
                    ]);
                }
            }

            // Update learning and development experiences
            if (!empty($data['learningDevelopment'])) {
                $learningDevelopment = $employee->learningDevelopment->first();
                if ($learningDevelopment) {
                    $learningDevelopment->update([
                        'learning_development_experiences_data' => json_encode($data['learningDevelopment']['learning_development_experiences_data'] ?? []),
                    ]);
                } else {
                    LearningDevelopment::create([
                        'employee_id' => $employee->id,
                        'learning_development_experiences_data' => json_encode($data['learningDevelopment']['learning_development_experiences_data'] ?? []),
                    ]);
                }
            }

            // Update other information
            if (!empty($data['otherInformation'])) {
                $employee->otherInformation->update($data['otherInformation']);
            }

            // Update references
            if (!empty($data['references'])) {
                $reference = $employee->references->first();
                if ($reference) {
                    $reference->update([
                        'reference_detail_data' => json_encode($data['references']['reference_detail_data'] ?? []),
                    ]);
                } else {
                    Reference::create([
                        'employee_id' => $employee->id,
                        'reference_detail_data' => json_encode($data['references']['reference_detail_data'] ?? []),
                    ]);
                }
            }
        });

        return $record;
    }






    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
        ->success()
        ->title('Employee updated')
        ->body('The employee has been saved successfully!');
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
