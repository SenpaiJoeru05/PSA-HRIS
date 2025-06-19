<?php
namespace App\Filament\Pages;
 
use App\Models\City;
use App\Models\CivilServiceEligibility;
use App\Models\Division;
use App\Models\EducationalBackground;
use App\Models\FamilyBackground;
use App\Models\LearningDevelopment;
use App\Models\OtherInformation;
use App\Models\PersonalInformation;
use App\Models\Province;
use App\Models\Reference;
use App\Models\User;
use App\Models\Employee;
use App\Models\VoluntaryWorkExperience;
use App\Models\WorkExperience;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Auth\Register;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms\Components\TextInput;
 
class CustomRegistration extends Register
{
    protected ?string $maxWidth = '7xl';
 
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    //STEP 1 USER ACCOUNT
                    Wizard\Step::make('Employee Account')
                    ->schema([
                        Section::make('Employee Account')
                            ->schema([
                                TextInput::make('username')
                                    ->label('Username')
                                    ->columnSpan(3)
                                    ->autocomplete('off')
                                    ->required(),
                                TextInput::make('email')
                                ->columnSpan(3)
                                    ->label('Email')
                                    ->autocomplete('off')
                                    ->required()
                                    ->email(),
                                Password::make('password')
                                    ->label('Password')
                                    ->columnSpan(3)
                                    ->type('password')
                                    ->autocomplete('new-password')
                                    ->required(),
                                FileUpload::make('profile_picture')
                                    ->label('Profile Picture')
                                    ->disk('public')
                                    ->columnSpan(2)
                                    ->acceptedFileTypes(['image/*'])
                                    ->rules('image'),
                                
                                Select::make('division_id')
                                ->label('Division')
                                ->columnSpan(2)
                                // ->native(false)
                                ->options(Division::all()->pluck('name', 'id')->toArray()),
                                
                                Select::make('employment_status')
                                ->label('Status')
                                ->options([
                                    'Regular' => 'Regular',
                                    'Contractual' => 'Contractual',
                                    'Probationary' => 'Probationary',
                                    'Resigned' => 'Resigned',
                                    'Retired' => 'Retired',
                                ])
                                ->default('Regular'),
    
                                TextInput::make('agency_employee_id')
                                    ->label('Employee ID')
                                    ->columnSpan(4),
    
                                TextInput::make('position')
                                    ->label('Position')
                                    ->columnSpan(2)
                                    ->required(),
                                
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
                        ])->hiddenLabel(),
    
                //STEP 2 PERSONAL INFORMATION FORM
                Wizard\Step::make('Personal Information')
                    ->schema([
                        Section::make()
                            ->schema([
                                Section::make('PERSONAL INFORMATION')
                                    ->schema([
                                DatePicker::make('date_of_birth')
                                    ->label('Date of Birth')
                                    ->required(),
                                TextInput::make('place_of_birth')
                                    ->label('Place of Birth')
                                    ->required(),
                                Select::make('sex')
                                    ->label('Sex')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                    ])
                                    ->required(),
                                Select::make('civil_status')
                                    ->label('Civil Status')
                                    ->options([
                                        'single' => 'Single',
                                        'married' => 'Married',
                                        'common law' =>'Common Law',
                                        'widowed' => 'Widowed',
                                        'separated' => 'Separated',
                                    ])
                                    ->required(),
                                TextInput::make('height')
                                    ->label('Height (m)')
                                    ->nullable(),
                                TextInput::make('weight')
                                    ->label('Weight (kg)')
                                    ->nullable(),
                                Select::make('blood_type')
                                    ->label('Blood Type')
                                    ->options([
                                        'A' => 'A',
                                        'B' => 'B',
                                        'AB' => 'AB',
                                        'O' => 'O',
                                        'other' => 'Other',
                                    ])
                                    ->required(),
                                TextInput::make('gsis_id_no')
                                    ->label('GSIS ID No.')
                                    ->nullable(),
                                TextInput::make('pagibig_id_no')
                                    ->label('PAG-IBIG ID No.')
                                    ->nullable(),
                                TextInput::make('philhealth_no')
                                    ->label('PHILHEALTH No.'),
                                TextInput::make('sss_no')
                                    ->label('SSS No.')
                                    ->nullable(),
                                TextInput::make('tin_no')
                                    ->label('TIN No.')
                                    ->nullable(),
                                TextInput::make('agency_employee_no')
                                    ->label('Agency Employee No.')
                                    ->nullable(),
                                Select::make('citizenship')
                                    ->label('Citizenship')
                                    ->options([
                                        'filipino' => 'Filipino',
                                        'dual_citizen' => 'Dual Citizenship',
                                    ])
                                    ->live(onBlur: true)    
                                    ->required(),
                                TextInput::make('citizenship_by')
                                    ->label('Citizenship By')
                                    ->disabled(fn ($get) => $get('citizenship') === 'filipino')
                                    ->nullable(),
                                TextInput::make('dual_citizenship_country')
                                    ->label('Dual Citizenship Country')
                                    ->disabled(fn ($get) => $get('citizenship') === 'filipino')
                                    ->nullable(),
                                ])->Icon('heroicon-o-user')
                                ->columns(4),
                              
                                // RESIDENTIAL ADDRESS
                                Section::make('RESIDENTIAL ADDRESS')
                                ->schema([
                                    Select::make('residential_province_id')
                                        ->live(onBlur: true)
                                        ->label('Residential Address - Province')
                                        ->placeholder('Province')
                                        ->options(Province::all()->pluck('name', 'id')->toArray())
                                        ->hiddenLabel()
                                        ->required(),
                                
                                    Select::make('residential_city_id')
                                        ->label('Residential Address - City/Municipality')
                                        ->placeholder('City/Municipality')
                                        ->options(fn($get) => $get('residential_province_id') 
                                            ? City::where('province_id', $get('residential_province_id'))->pluck('name', 'id')->toArray() 
                                            : [])
                                        ->hiddenLabel()
                                        ->required(),
                                    
                                    TextInput::make('residential_barangay')
                                        ->label('Residential Address - Barangay')
                                        ->placeholder('Barangay')
                                        ->hiddenLabel()
                                        ->required(),
                                    
                                    TextInput::make('residential_subdivision_village')
                                        ->label('Residential Address - Subdivision')
                                        ->placeholder('Subdivision')
                                        ->hiddenLabel()
                                        ->nullable(),
                                    
                                    TextInput::make('residential_street')
                                        ->label('Residential Address - Street')
                                        ->placeholder('Street')
                                        ->hiddenLabel()
                                        ->nullable(),
                                    
                                    TextInput::make('residential_house_block_lot_no')
                                        ->label('Residential Address - House/Block/Lot No.')
                                        ->placeholder('House/Block/Lot No.')
                                        ->hiddenLabel()
                                        ->nullable(),
                                ])->columns(3),
    
                            Section::make('PERMANENT ADDRESS')
                                ->schema([
                                    Checkbox::make('permanent_address_same_as_residential')
                                        ->columnSpanFull()
                                        ->default(false)
                                        ->live(onBlur: true)
                                        ->label('Same with the Residential')
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                            if ($state) {
                                                // Retrieve names using IDs
                                                $provinceName = Province::find($get('residential_province_id'))->name ?? null;
                                                $cityName = City::find($get('residential_city_id'))->name ?? null;
    
                                                // Copy residential address to permanent address and disable the fields
                                                $set('permanent_province', $provinceName);
                                                $set('permanent_city', $cityName);
                                                $set('permanent_barangay', $get('residential_barangay'));
                                                $set('permanent_subdivision', $get('residential_subdivision_village'));
                                                $set('permanent_street', $get('residential_street'));
                                                $set('permanent_house_number', $get('residential_house_block_lot_no'));
                                            } else {
                                                // Reset permanent address fields if not same as residential
                                                $set('permanent_province', null);
                                                $set('permanent_city', null);
                                                $set('permanent_barangay', null);
                                                $set('permanent_subdivision', null);
                                                $set('permanent_street', null);
                                                $set('permanent_house_number', null);
                                            }
                                        }),
    
                                    Group::make([
                                        TextInput::make('permanent_province')
                                            ->label('Permanent Address - Province')
                                            ->placeholder('Province')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('permanent_address_same_as_residential')),
                                        TextInput::make('permanent_city')
                                            ->label('Permanent Address - City/Municipality')
                                            ->placeholder('City/Municipality')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('permanent_address_same_as_residential')),
                                        TextInput::make('permanent_barangay')
                                            ->label('Permanent Address - Barangay')
                                            ->placeholder('Barangay')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('permanent_address_same_as_residential')),
                                        TextInput::make('permanent_subdivision')
                                            ->label('Permanent Address - Subdivision')
                                            ->placeholder('Subdivision')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('permanent_address_same_as_residential')),
                                        TextInput::make('permanent_street')
                                            ->label('Permanent Address - Street')
                                            ->placeholder('Street')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('permanent_address_same_as_residential')),
                                        TextInput::make('permanent_house_number')
                                            ->label('Permanent Address - House/Block/Lot No.')
                                            ->placeholder('House/Block/Lot No.')
                                            ->hiddenLabel()
                                            ->nullable()
                                            ->disabled(fn (Get $get) => $get('permanent_address_same_as_residential')),
                                    ])->columns(3),
                                ]),
                                Section::make('CONTACTS')
                                    ->schema([
                                        TextInput::make('telephone_number')
                                            ->label('Telephone Number')
                                            ->nullable(),
                                        TextInput::make('mobile_number')
                                            ->label('Mobile Number')
                                            ->required(),
                                        TextInput::make('email_address')
                                            ->label('Email Address')
                                            ->nullable(),
                                    ])->columns(2),
                            ]),
                    ])->hiddenLabel(),
    
                //STEP 3 FAMILY BACKGROUND FORM
               Wizard\Step::make('Family Background')
                    ->hiddenLabel()
                    ->schema([
                        Section::make('FAMILY BACKGROUND')
                        ->schema([
                           Section::make('Spouce Information')
                           ->schema([
                                //Spouce Info
                                Checkbox::make('spouse_not_applicable')
                                ->columnSpanFull()
                                ->live()
                                ->default(false)
                                ->disabledOn('edit')
                                ->label('Please Check if not applicable'),
                                Group::make([
                                    TextInput::make('spouse_last_name')
                                    ->hiddenLabel()
                                        ->placeholder('Spouse\'s Surname'),
                                    TextInput::make('spouse_first_name')
                                    ->hiddenLabel()
                                        ->placeholder('Spouse\'s First Name'),
                                    TextInput::make('spouse_middle_name')
                                    ->hiddenLabel()
                                        ->placeholder('Spouse\'s Middle Name'),
                                    TextInput::make('spouse_name_extension')
                                    ->hiddenLabel()
                                        ->placeholder('Spouse\'s Name Extension')        
                                ])->columns(4)
                                ->hidden(fn (Get $get) => $get('spouse_not_applicable')),
                                ]),
                            Section::make('Father Information')
                            ->schema([
                                    //Father Info
                                    Checkbox::make('father_not_applicable')
                                    ->columnSpanFull()
                                    ->live()
                                    ->default(false)
                                    ->disabledOn('edit')
                                    ->label('Please Check if not applicable'),
                                    Group::make([
                                    TextInput::make('father_last_name')
                                    ->hiddenLabel()
                                    ->placeholder('Father\'s Surname'),
                                    TextInput::make('father_first_name')
                                    ->hiddenLabel()   
                                    ->placeholder('Father\'s First Name'),
                                    TextInput::make('father_middle_name')
                                    ->hiddenLabel()
                                    ->placeholder('Father\'s Middle Name'),
                                    TextInput::make('father_name_extension')
                                    ->hiddenLabel()
                                    ->placeholder('Father\'s Name Extension'),
                                    ])->columns(4)
                                    ->hidden(fn (Get $get) => $get('father_not_applicable')),
                                    ]),
                           
                            Section::make('Mother Information')
                            ->schema([
                            //Mothers Info
                            Checkbox::make('mother_not_applicable')
                            ->columnSpanFull()
                            ->live()
                            ->default(false)
                            ->disabledOn('edit')
                            ->label('Please Check if not applicable'),
                                Group::make([
                                    TextInput::make('mother_maiden_surname')
                                    ->hiddenLabel()
                                        ->placeholder('Mother\'s Maiden Surname'),
                                    TextInput::make('mother_first_name')
                                    ->hiddenLabel()
                                        ->placeholder('Mother\'s First Name'),
                                    TextInput::make('mother_middle_name')
                                    ->hiddenLabel()
                                        ->placeholder('Mother\'s Middle Name'),
                                    TextInput::make('mother_name_extension')
                                    ->hiddenLabel()
                                        ->placeholder('Mother\'s Name Extension')
                                ])->columns(4)
                                ->hidden(fn (Get $get) => $get('mother_not_applicable')),
                            ]),
            
                            Section::make('Children Information')
                            ->schema([
                            Checkbox::make('children_not_applicable')
                                ->columnSpanFull()
                                ->live()
                                ->default(false)
                                ->disabledOn('edit')
                                 ->label('Please Check if not applicable'),
                                Group::make([
                                    Repeater::make('children')
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
                                          ->hiddenLabel(),    
                                        ])->columns(4)
                                        ->hidden(fn (Get $get) => $get('children_not_applicable')),
                                    ])
                                    
                                ]),
                            ])->Icon('heroicon-o-user-group')
                            ]),
                
                        //STEP 4 EDUCATIONAL BACKGROUND FORM
                       Wizard\Step::make('Educational Background')
                                ->schema([
                                    Section::make('EDUCATIONAL BACKGROUND')
                                        ->schema([
                                            
                                            Section::make('Elementary')
                                                ->schema([
                                                    TextInput::make('elementary_school_name')
                                                        ->label('School Name')
                                                        ->columnSpanFull()
                                                        ->placeholder('Enter Elementary School Name')
                                                        ->required(),
                                                    TextInput::make('elementary_highest_level')
                                                        ->label('Highest Level/Units Earned (if not graduated)')
                                                        ->placeholder('Enter highest level/units earned')
                                                        ->nullable(),
                                                    DatePicker::make('elementary_period_from')
                                                        ->label('Period of Attendance From:')
                                                        ->nullable(),
                                                    DatePicker::make('elementary_period_to')
                                                        ->label('Period of Attendance To:')
                                                        ->nullable(),
                                                    TextInput::make('elementary_awards_received')
                                                        ->label('Awards Received')
                                                        ->placeholder('Awards Received (if any)')
                                                        ->nullable(),
                                                    TextInput::make('elementary_educational_attainment')
                                                        ->label('Educational Attainment')
                                                        ->columnSpan(2)
                                                        ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                                        ->nullable(),
                                                ])->columns(3),
    
                                            Section::make('Secondary')
                                                ->schema([
                                                    TextInput::make('secondary_school_name')
                                                        ->label('School Name')
                                                        ->columnSpanFull()
                                                        ->placeholder('Enter Secondary School Name')
                                                        ->required(),
                                                    TextInput::make('secondary_highest_level')
                                                        ->label('Highest Level/Units Earned (if not graduated)')
                                                        ->placeholder('Enter highest level/units earned')
                                                        ->nullable(),
                                                    DatePicker::make('secondary_period_from')
                                                        ->label('Period of Attendance From:')
                                                        ->nullable(),
                                                    DatePicker::make('secondary_period_to')
                                                        ->label('Period of Attendance To:')
                                                        ->nullable(),
                                                    TextInput::make('secondary_awards_received')
                                                        ->label('Awards Received')
                                                        ->placeholder('Awards Received (if any)')
                                                        ->nullable(),
                                                    TextInput::make('secondary_educational_attainment')
                                                        ->label('Educational Attainment')
                                                        ->columnSpan(2)
                                                        ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                                        ->nullable(),
                                                ])->columns(3),
    
                                                Section::make('Vocational/Trade Course')
                                                ->schema([
                                                    Checkbox::make('vocational_not_applicable')
                                                        ->columnSpanFull()
                                                        ->live()
                                                        ->default(false)
                                                        ->disabledOn('edit')
                                                        ->label('Not Applicable'),
                                            
                                                    Group::make([
                                                        TextInput::make('vocational_school_name')
                                                            ->label('School Name')
                                                            ->columnSpanFull()
                                                            ->placeholder('Enter Vocational/Trade School Name')
                                                            ->required(),
                                            
                                                        TextInput::make('vocational_highest_level')
                                                            ->label('Highest Level/Units Earned (if not graduated)')
                                                            ->placeholder('Enter highest level/units earned')
                                                            ->nullable(),
                                            
                                                        DatePicker::make('vocational_period_from')
                                                            ->label('Period of Attendance From:')
                                                            ->nullable(),
                                            
                                                        DatePicker::make('vocational_period_to')
                                                            ->label('Period of Attendance To:')
                                                            ->nullable(),
                                            
                                                        TextInput::make('vocational_awards_received')
                                                            ->label('Awards Received')
                                                            ->placeholder('Awards Received (if any)')
                                                            ->nullable(),
                                            
                                                        TextInput::make('vocational_educational_attainment')
                                                            ->label('Educational Attainment')
                                                            ->columnSpan(2)
                                                            ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                                            ->nullable(),
                                                    ])->columns(3)
                                                        ->hidden(fn (Get $get) => $get('vocational_not_applicable')),
                                                ]),
    
                                            Section::make('College')
                                                ->schema([
                                                    TextInput::make('college_school_name')
                                                        ->label('School Name')
                                                        ->columnSpanFull()
                                                        ->placeholder('Enter College/University Name')
                                                        ->required(),
                                                    TextInput::make('college_highest_level')
                                                        ->label('Highest Level/Units Earned (if not graduated)')
                                                        ->placeholder('Enter highest level/units earned')
                                                        ->nullable(),
                                                    DatePicker::make('college_period_from')
                                                        ->label('Period of Attendance From:')
                                                        ->nullable(),
                                                    DatePicker::make('college_period_to')
                                                        ->label('Period of Attendance To:')
                                                        ->nullable(),
                                                    TextInput::make('college_awards_received')
                                                        ->label('Awards Received')
                                                        ->placeholder('Awards Received (if any)')
                                                        ->nullable(),
                                                    TextInput::make('college_educational_attainment')
                                                        ->label('Educational Attainment')
                                                        ->columnSpan(2)
                                                        ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                                        ->nullable(),
                                                ])->columns(3),
    
                                                Section::make('Graduate Studies')
                                                ->schema([
                                                    Checkbox::make('graduate_not_applicable')
                                                        ->columnSpanFull()
                                                        ->live()
                                                        ->default(false)
                                                        ->disabledOn('edit')
                                                        ->label('Not Applicable'),
                                            
                                                    Group::make([
                                                        TextInput::make('graduate_school_name')
                                                            ->label('School Name')
                                                            ->columnSpanFull()
                                                            ->placeholder('Enter Graduate School Name')
                                                            ->required(),
                                            
                                                        TextInput::make('graduate_highest_level')
                                                            ->label('Highest Level/Units Earned (if not graduated)')
                                                            ->placeholder('Enter highest level/units earned')
                                                            ->nullable(),
                                            
                                                        DatePicker::make('graduate_period_from')
                                                            ->label('Period of Attendance From:')
                                                            ->nullable(),
                                            
                                                        DatePicker::make('graduate_period_to')
                                                            ->label('Period of Attendance To:')
                                                            ->nullable(),
                                            
                                                        TextInput::make('graduate_awards_received')
                                                            ->label('Awards Received')
                                                            ->placeholder('Awards Received (if any)')
                                                            ->nullable(),
                                            
                                                        TextInput::make('graduate_educational_attainment')
                                                            ->label('Educational Attainment')
                                                            ->columnSpan(2)
                                                            ->placeholder('Educational Attainment (e.g., honors, distinctions)')
                                                            ->nullable(),
                                                    ])->columns(3)
                                                        ->hidden(fn (Get $get) => $get('graduate_not_applicable')),
                                                ]),
    
                                        ])->Icon('heroicon-o-academic-cap'),
                                ])->hiddenLabel(),
    
                    
                                //STEP 5 CIVIL SERVICE ELIGIBILITY
                                Wizard\Step::make('Civil Service Eligibility')
                                ->schema([
                                    Section::make('CIVIL SERVICE ELIGIBILITIES')
                                        ->schema([
                                            Checkbox::make('civil_service_eligibility_not_applicable')
                                                ->columnSpanFull()
                                                ->live()
                                                ->default(false)
                                                ->disabledOn('edit')
                                                ->label('Check if not applicable'),
                            
                                            Group::make([
                                                Repeater::make('civil_service_data')
                                                ->schema([
                                                    Section::make('Civil Service Eligibility Details')
                                                    ->schema([
                                                        TextInput::make('eligibility')
                                                            ->label("CAREER SERVICE/RA 1080 (BOARD/BAR) UNDER SPECIAL LAWS/CES CSEE BARANGAY ELIGIBILITY/DRIVER'S LICENSE")
                                                            ->placeholder('Enter Civil Service Eligibility')
                                                            ->required()
                                                            ->hidden(fn (Get $get) => $get('civil_service_eligibility_not_applicable')),
    
                                                        TextInput::make('rating')
                                                            ->label('Rating (if applicable)')
                                                            ->placeholder('Enter Rating')
                                                            ->nullable()
                                                            ->hidden(fn (Get $get) => $get('civil_service_eligibility_not_applicable')),
    
                                                        DatePicker::make('date_of_examination')
                                                            ->label('Date of Examination/Conferment')
                                                            ->nullable()
                                                            ->hidden(fn (Get $get) => $get('civil_service_eligibility_not_applicable')),
    
                                                        TextInput::make('place_of_examination')
                                                            ->label('Place of Examination/Conferment')
                                                            ->placeholder('Enter Place')
                                                            ->nullable()
                                                            ->hidden(fn (Get $get) => $get('civil_service_eligibility_not_applicable')),
    
                                                            TextInput::make('license_number')
                                                                ->label('License Number')
                                                                ->placeholder('Enter License Number')
                                                                ->nullable()
                                                                ->hidden(fn (Get $get) => $get('civil_service_eligibility_not_applicable')),
    
    
                                                            DatePicker::make('date_of_validity')
                                                                ->label('Date of Validity')
                                                                ->nullable()
                                                                ->hidden(fn (Get $get) => $get('civil_service_eligibility_not_applicable')),
                                                    ])
                                                ])->hiddenLabel()
                                                ->columns(1)
                                                ->hidden(fn (Get $get) => $get('civil_service_eligibility_not_applicable')),
    
                                            ]),
                                        ])->Icon('heroicon-o-users'),
                                ])
                                ->hiddenLabel(),
                            
                                //STEP 6 WORK EXPERIENCE
                               Wizard\Step::make('Work Experience')
                                ->schema([
                                    Section::make('WORK EXPERIENCE')
                                        ->schema([
                                            Checkbox::make('work_experience_not_applicable')
                                                ->columnSpanFull()
                                                ->live()
                                                ->default(false)
                                                ->disabledOn('edit')
                                                ->label('Check if not applicable'),
                            
                                            Group::make([
                                                Repeater::make('work_experiences_data')
                                                    ->schema([
                                                        Section::make('Work Experience Details')
                                                            ->schema([
                                                                DatePicker::make('inclusive_dates_from')
                                                                    ->label('Inclusive Dates (From)')
                                                                    ->required()
                                                                    ->placeholder('mm/dd/yy')
                                                                    ->hidden(fn (Get $get) => $get('work_experience_not_applicable')),
                            
                                                                DatePicker::make('inclusive_dates_to')
                                                                    ->label('Inclusive Dates (To)')
                                                                    ->required()
                                                                    ->placeholder('mm/dd/yy')
                                                                    ->hidden(fn (Get $get) => $get('work_experience_not_applicable')),
                            
                                                                TextInput::make('position_title')
                                                                    ->label('Position Title')
                                                                    ->placeholder('Enter Position Title')
                                                                    ->required()
                                                                    ->hidden(fn (Get $get) => $get('work_experience_not_applicable')),
                            
                                                                TextInput::make('department_agency_office_company')
                                                                    ->label('Department/Agency/Office/Company')
                                                                    ->placeholder('Enter Department/Agency/Office/Company')
                                                                    ->required()
                                                                    ->hidden(fn (Get $get) => $get('work_experience_not_applicable')),
                            
                                                                TextInput::make('monthly_salary')
                                                                    ->label('Monthly Salary')
                                                                    ->placeholder('Enter Monthly Salary')
                                                                    ->nullable()
                                                                    ->hidden(fn (Get $get) => $get('work_experience_not_applicable')),
                            
                                                                TextInput::make('salary_grade_and_step')
                                                                    ->label('Salary/Job Grade & Step (if applicable)')
                                                                    ->placeholder('Enter Salary/Job Grade & Step')
                                                                    ->nullable()
                                                                    ->hidden(fn (Get $get) => $get('work_experience_not_applicable')),
                            
                                                                TextInput::make('status_of_appointment')
                                                                    ->label('Status of Appointment')
                                                                    ->placeholder('Enter Status of Appointment')
                                                                    ->nullable()
                                                                    ->hidden(fn (Get $get) => $get('work_experience_not_applicable')),
                                                                Radio::make('government_service')
                                                                    ->label('Government Service?')
                                                                    ->nullable()
                                                                    ->columnSpanFull()
                                                                    ->boolean()
                                                                    ->inline()
                                                                    ->inlineLabel(false)
                                                                    ->hidden(fn (Get $get) => $get('work_experience_not_applicable')),
                                                            ])->columns(2),
                                                ])->hiddenLabel()
                                                    ->columns(1)
                                                    ->hidden(fn (Get $get) => $get('work_experience_not_applicable')),
                                            ]),
                                        ])->Icon('heroicon-o-user-group'),
                                ])->hiddenLabel(),
                                
                                //STEP 7 VOLUNTARY WORK FORM
                                Wizard\Step::make('Voluntary Work')
                                ->schema([
                                    Section::make('VOLUNTARY WORK')
                                        ->schema([
                                            Checkbox::make('voluntary_work_not_applicable')
                                                ->columnSpanFull()
                                                ->live()
                                                ->default(false)
                                                ->disabledOn('edit')
                                                ->label('Check if not applicable'),
    
                                            Group::make([
                                                Repeater::make('voluntary_work_experiences_data')
                                                    ->schema([
                                                        Section::make('Voluntary Work Details')
                                                            ->schema([
                                                                TextInput::make('organization_name')
                                                                    ->label('Name & Address of Organization')
                                                                    ->placeholder('Enter Organization Name & Address')
                                                                    ->nullable()
                                                                    ->required()
                                                                    ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
    
                                                                Group::make([
                                                                    DatePicker::make('from_date')
                                                                        ->label('Inclusive Dates (From)')
                                                                        ->required()
                                                                        ->nullable()
                                                                        ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
                                                                    
                                                                    DatePicker::make('to_date')
                                                                        ->label('Inclusive Dates (To)')
                                                                        ->required()
                                                                        ->nullable()
                                                                        ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
                                                                ])->label('Inclusive Dates')
                                                                ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
    
                                                                TextInput::make('hours')
                                                                    ->label('Number of Hours')
                                                                    ->placeholder('Enter Number of Hours')
                                                                    ->required()
                                                                    ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
    
                                                                TextInput::make('position')
                                                                    ->label('Position/Nature of Work')
                                                                    ->placeholder('Enter Position/Nature of Work')
                                                                    ->required()
                                                                    ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
                                                            ])
                                                            
                                                        ])->hiddenLabel()
                                                        ->hidden(fn (Get $get) => $get('voluntary_work_not_applicable')),
                                            ]),
                                        ])->Icon('heroicon-o-users'),
                                ])->hiddenLabel(),
                            
    
    
                            //STEP 8 LEARNING AND DEVELOPMENT
                              Wizard\Step::make('Learning & Development')
                                ->schema([
                                    Section::make('LEARNING & DEVELOPMENT')
                                        ->schema([
                                            Checkbox::make('learning_development_not_applicable')
                                                ->columnSpanFull()
                                                ->live()
                                                ->default(false)
                                                ->disabledOn('edit')
                                                ->label('Check if not applicable'),
                            
                                            Group::make([
                                                Repeater::make('learning_development_experiences_data')
                                                    ->schema([
                                                        Section::make('Learning & Development Details')
                                                            ->schema([
                                                                TextInput::make('title')
                                                                    ->label('Title of Learning and Development Interventions/Training Programs')
                                                                    ->placeholder('Enter Title')
                                                                    ->nullable()
                                                                    ->required()
                                                                    ->hidden(fn (Get $get) => $get('learning_development_not_applicable')),
                            
                                                                Group::make([
                                                                    DatePicker::make('learningdev_from_date')
                                                                        ->label('Inclusive Dates (From)')
                                                                        ->required()
                                                                        ->nullable()
                                                                        ->hidden(fn (Get $get) => $get('learning_development_not_applicable')),
                                                                    
                                                                    DatePicker::make('learningdev_to_date')
                                                                        ->label('Inclusive Dates (To)')
                                                                        ->required()
                                                                        ->nullable()
                                                                        ->hidden(fn (Get $get) => $get('learning_development_not_applicable')),
                                                                ])->label('Inclusive Dates')
                                                                  ->hidden(fn (Get $get) => $get('learning_development_not_applicable')),
                            
                                                                TextInput::make('learningdev_hours')
                                                                    ->label('Number of Hours')
                                                                    ->placeholder('Enter Number of Hours')
                                                                    ->required()
                                                                    ->nullable()
                                                                    ->hidden(fn (Get $get) => $get('learning_development_not_applicable')),
                            
                                                                TextInput::make('learningdev_type')
                                                                    ->label('Type of LD (Managerial / Supervisory / Technical / etc.)')
                                                                    ->nullable()
                                                                    ->placeholder('Enter Type')
                                                                    ->required()
                                                                    ->hidden(fn (Get $get) => $get('learning_development_not_applicable')),
                            
                                                                TextInput::make('learningdev_conducted_by')
                                                                    ->label('Conducted/Sponsored By')
                                                                    ->nullable()
                                                                    ->placeholder('Enter Conducted/Sponsored By')
                                                                    ->required()
                                                                    ->hidden(fn (Get $get) => $get('learning_development_not_applicable')),
                                                            ])
                                                            
                                                    ])->hiddenLabel()
                                                    ->hidden(fn (Get $get) => $get('learning_development_not_applicable')),
                                            ]),
                                        ])->Icon('heroicon-o-presentation-chart-line'),
                                ])->hiddenLabel(),
                            
    
                                //STEP 9 OTHER INFORMATION FORM
                                Wizard\Step::make('Other Information')
                                ->schema([
                                    Section::make('OTHER INFORMATION')
                                            ->schema([
                                                Group::make([
                                                    Repeater::make('special_skills_and_hobbies')
                                                        ->schema([
                                                            Section::make('Special Skills and Hobbies')
                                                                ->schema([
                                                                    TextInput::make('skill_or_hobby')
                                                                        ->label('Special Skill or Hobby')
                                                                        ->placeholder('Enter Special Skill or Hobby')
                                                                        ->columnSpanFull()
                                                                        ->required(),
                                                                ])->columns(2),
                                                        ])->hiddenLabel(),
                                                        
                                                    Repeater::make('non_academic_distinctions')
                                                        ->schema([
                                                            Section::make('Non-Academic Distinctions/Recognition')
                                                                ->schema([
                                                                    TextInput::make('distinction')
                                                                        ->label('Non-Academic Distinction/Recognition')
                                                                        ->placeholder('Enter Non-Academic Distinction/Recognition')
                                                                        ->columnSpanFull()
                                                                        ->required(),
                                                                ])->columns(2),
                                                        ])->hiddenLabel(),
                                                        
                                                    Repeater::make('members_in_organization')
                                                        ->schema([
                                                            Section::make('Members in Association/Organization')
                                                                ->schema([
                                                                    TextInput::make('organization_name')
                                                                        ->label('Name of Association/Organization')
                                                                        ->placeholder('Enter Name of Association/Organization')
                                                                        ->columnSpanFull()
                                                                        ->required(),
                                                                ])->columns(2),
                                                        ])->hiddenLabel(),
                                                ])->columns(3),
                                                
                                                Section::make("YES OR NO QUESTIONS")
                                                    ->schema([
                                                        Section::make('1. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed?')
                                                            ->schema([
                                                                Radio::make('related_to_appointing_authority')
                                                                    ->label('a. within the third degree?')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('related_details_third_degree')
                                                                    ->label('If YES, please give details:')
                                                                    ->placeholder('Enter details')
                                                                    ->hidden(fn ($get) => $get('related_to_appointing_authority') !== 'yes'),
                                                                
                                                                Radio::make('related_to_appointing_authority_fourth_degree')
                                                                    ->label('b. within the fourth degree (for Local Government Unit - Career Employees)?')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('related_details_fourth_degree')
                                                                    ->label('If YES, please give details:')
                                                                    ->placeholder('Enter details')
                                                                    ->hidden(fn ($get) => $get('related_to_appointing_authority_fourth_degree') !== 'yes'),
                                                            ]),
                                                            
                                                        Section::make('2. Have you ever been found guilty of any administrative offense?')
                                                            ->schema([
                                                                Radio::make('guilty_of_offense')
                                                                    ->label(' ')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('offense_details')
                                                                    ->label('If YES, please give details:')
                                                                    ->placeholder('Enter details')
                                                                    ->hidden(fn ($get) => $get('guilty_of_offense') !== 'yes'),
                                                            ]),
                                                            
                                                        Section::make('3. Have you ever been criminally charged before any court?')
                                                            ->schema([
                                                                Radio::make('criminally_charged')
                                                                    ->label(' ')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('charged_details')
                                                                    ->label('If YES, please give details:')
                                                                    ->placeholder('Enter details')
                                                                    ->hidden(fn ($get) => $get('criminally_charged') !== 'yes'),
                                                                
                                                                DatePicker::make('charged_date')
                                                                    ->label('Date Filed:')
                                                                    ->placeholder('Enter Date Filed')
                                                                    ->hidden(fn ($get) => $get('criminally_charged') !== 'yes'),
                                                                
                                                                TextInput::make('charged_status')
                                                                    ->label('Status of Case/s:')
                                                                    ->placeholder('Enter Status of Case/s')
                                                                    ->hidden(fn ($get) => $get('criminally_charged') !== 'yes'),
                                                            ]),
                                                            
                                                        Section::make('4. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?')
                                                            ->schema([
                                                                Radio::make('convicted_of_crime')
                                                                    ->label(' ')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('conviction_details')
                                                                    ->label('If YES, please give details:')
                                                                    ->placeholder('Enter details')
                                                                    ->hidden(fn ($get) => $get('convicted_of_crime') !== 'yes'),
                                                            ]),
                                                            
                                                        Section::make('5. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?')
                                                            ->schema([
                                                                Radio::make('separated_from_service')
                                                                    ->label(' ')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('separation_details')
                                                                    ->label('If YES, please give details:')
                                                                    ->placeholder('Enter details')
                                                                    ->hidden(fn ($get) => $get('separated_from_service') !== 'yes'),
                                                            ]),
                                                            
                                                        Section::make('6. Have you ever been a candidate in a national or local election held within the last year (except Barangay Election)?')
                                                            ->schema([
                                                                Radio::make('candidate_in_election')
                                                                    ->label(' ')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                            ]),
                                                            
                                                        Section::make('7. Have you resigned from the government service during the three(3)-month period before the last election to promote/actively campaign for a national or local candidate?')
                                                            ->schema([
                                                                Radio::make('resigned_for_campaign')
                                                                    ->label(' ')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('resignation_details')
                                                                    ->label('If YES, please give details:')
                                                                    ->placeholder('Enter details')
                                                                    ->hidden(fn ($get) => $get('resigned_for_campaign') !== 'yes'),
                                                            ]),
                                                            
                                                        Section::make('8. Have you acquired the status of an immigrant or permanent resident of another country?')
                                                            ->schema([
                                                                Radio::make('immigrant_or_resident')
                                                                    ->label(' ')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('immigrant_details')
                                                                    ->label('If YES, please give details (country):')
                                                                    ->placeholder('Enter details')
                                                                    ->hidden(fn ($get) => $get('immigrant_or_resident') !== 'yes'),
                                                            ]),
                                                            
                                                        Section::make('9. Pursuant to: (a) Indigenous People\'s Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:')
                                                            ->schema([
                                                                Radio::make('member_of_indigenous_group')
                                                                    ->label('a. Are you a member of any indigenous group?')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('indigenous_group_details')
                                                                    ->label('If YES, please specify:')
                                                                    ->placeholder('Enter details')
                                                                    ->hidden(fn ($get) => $get('member_of_indigenous_group') !== 'yes'),
                                                                
                                                                Radio::make('person_with_disability')
                                                                    ->label('b. Are you a person with disability?')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('disability_id')
                                                                    ->label('If YES, please specify ID No:')
                                                                    ->placeholder('Enter ID No')
                                                                    ->hidden(fn ($get) => $get('person_with_disability') !== 'yes'),
                                                                
                                                                Radio::make('solo_parent')
                                                                    ->label('c. Are you a solo parent?')
                                                                    ->options([
                                                                        'yes' => 'Yes',
                                                                        'no' => 'No',
                                                                    ])
                                                                    ->reactive()
                                                                    ->columnSpanFull(),
                                                                
                                                                TextInput::make('solo_parent_id')
                                                                    ->label('If YES, please specify ID:')
                                                                    ->placeholder('Enter ID')
                                                                    ->hidden(fn ($get) => $get('solo_parent') !== 'yes'),
                                                            ]),
                                                    ])->columns(1),
                                                ])->Icon('heroicon-o-archive-box-arrow-down'),
    
                                    ])->hiddenLabel(),
    
                            //STEP 10 REFERENCE FORM
                                    Wizard\Step::make('References')
                                    ->schema([
                                        Section::make('REFERENCES')
                                            ->schema([
                                                Repeater::make('reference_detail_data')
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
                                                                    ->placeholder('Enter Contact No.')
                                                                    ->required(),
                                                            ])->columns(3),
                                                    ])->hiddenLabel(),
                                            ])->Icon('heroicon-o-identification')->hiddenLabel(),
    
                                            Section::make('Government Issued ID')
                                            ->schema([
                                                Select::make('government_id_type')
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
                                                        
                                                    TextInput::make('government_id_type_specification')
                                                    ->label('Please specify:')
                                                    ->placeholder('Enter details')
                                                    ->hidden(fn ($get) => $get('government_id_type') !== 'other'),
                                        
                                                TextInput::make('government_id_number')
                                                    ->label('ID/License/Passport No.')
                                                    ->placeholder('Enter ID Number')
                                                    ->required(),
                                        
                                                DatePicker::make('government_id_date_place')
                                                    ->label('Date/Place of Issuance')
                                                    ->placeholder('Enter Date/Place of Issuance')
                                                    ->required(),
                                            ])->columns(1),
                                        ])->hiddenLabel()
                ])->columnSpan('full')
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                        wire:submit="register"
                    >
                        Register
                    </x-filament::button>
                    BLADE))),
            ]);
    }
 
    public function getFormActions(): array
    {
        return [];
    }
 
    protected function handleRecordCreation(array $data): Model
    {
        // Check if the user already exists by email
            $user = User::firstOrCreate(
            ['email' => $data['email']],
            [
                'username' => $data['username'] ?? null,
                'profile_picture' => $data['profile_picture'] ?? null,
                'password' => $data['password'],
                'role' => 'employee',
            ]
        );

    

            // Create the employee record
            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->division_id = $data['division_id'] ?? null;
            $employee->agency_employee_id = $data['agency_employee_id'] ?? null;
            $employee->first_name = $data['first_name'] ?? null;
            $employee->last_name = $data['last_name'] ?? null;
            $employee->middle_name = $data['middle_name'] ?? null;
            $employee->extension_name = $data['extension_name'] ?? null;
            $employee->position = $data['position'] ?? null;
            $employee->employment_status = $data['employment_status'] ?? null;
            $employee->date_hired = $data['date_hired'] ?? null;
            $employee->date_resigned = $data['date_resigned'] ?? null;
            $employee->date_retired = $data['date_retired'] ?? null;
            
            if (!$employee->save()) {
                throw new \Exception('Failed to save Employee record.');
            }
    
       
    
         // Create Personal Information
            $personalInformation = new PersonalInformation();
            $personalInformation->employee_id = $employee->id;
            $personalInformation->date_of_birth = $data['date_of_birth'] ?? null;
            $personalInformation->place_of_birth = $data['place_of_birth'] ?? null;
            $personalInformation->sex = $data['sex'] ?? null;
            $personalInformation->civil_status = $data['civil_status'] ?? null;
            $personalInformation->height = $data['height'] ?? null;
            $personalInformation->weight = $data['weight'] ?? null;
            $personalInformation->blood_type = $data['blood_type'] ?? null;
            $personalInformation->gsis_id_no = $data['gsis_id_no'] ?? null;
            $personalInformation->pagibig_id_no = $data['pagibig_id_no'] ?? null;
            $personalInformation->philhealth_no = $data['philhealth_no'] ?? null;
            $personalInformation->sss_no = $data['sss_no'] ?? null;
            $personalInformation->tin_no = $data['tin_no'] ?? null;
            $personalInformation->agency_employee_no = $data['agency_employee_no'] ?? null;
            $personalInformation->citizenship = $data['citizenship'] ?? null;
            $personalInformation->citizenship_by = $data['citizenship_by'] ?? null;
            $personalInformation->dual_citizenship_country = $data['dual_citizenship_country'] ?? null;
            $personalInformation->residential_province_id = $data['residential_province_id'] ?? null;
            $personalInformation->residential_city_id = $data['residential_city_id'] ?? null;
            $personalInformation->residential_barangay = $data['residential_barangay'] ?? null;
            $personalInformation->residential_subdivision_village = $data['residential_subdivision_village'] ?? null;
            $personalInformation->residential_street = $data['residential_street'] ?? null;
            $personalInformation->residential_house_block_lot_no = $data['residential_house_block_lot_no'] ?? null;
            $personalInformation->permanent_address_same_as_residential = $data['permanent_address_same_as_residential'] ?? null;

            // Check if permanent address is the same as residential address
            if (!empty($data['permanent_address_same_as_residential'])) {
                $personalInformation->permanent_province = Province::find($data['residential_province_id'])->name ?? null;
                $personalInformation->permanent_city = City::find($data['residential_city_id'])->name ?? null;
                $personalInformation->permanent_barangay = $data['residential_barangay'];
                $personalInformation->permanent_subdivision = $data['residential_subdivision_village'];
                $personalInformation->permanent_street = $data['residential_street'];
                $personalInformation->permanent_house_number = $data['residential_house_block_lot_no'];
            } else {
                $personalInformation->permanent_province = $data['permanent_province'] ?? null;
                $personalInformation->permanent_city = $data['permanent_city'] ?? null;
                $personalInformation->permanent_barangay = $data['permanent_barangay'] ?? null;
                $personalInformation->permanent_subdivision = $data['permanent_subdivision'] ?? null;
                $personalInformation->permanent_street = $data['permanent_street'] ?? null;
                $personalInformation->permanent_house_number = $data['permanent_house_number'] ?? null;
            }

            $personalInformation->telephone_number = $data['telephone_number'] ?? null;
            $personalInformation->mobile_number = $data['mobile_number'] ?? null;
            $personalInformation->email_address = $data['email_address'] ?? null;
            $personalInformation->save();
    
        // Create Family Background
        $familyBackground = new FamilyBackground();
        $familyBackground->employee_id = $employee->id;
        $familyBackground->spouse_last_name = $data['spouse_last_name'] ?? null;
        $familyBackground->spouse_first_name = $data['spouse_first_name'] ?? null;
        $familyBackground->spouse_middle_name = $data['spouse_middle_name'] ?? null;
        $familyBackground->spouse_name_extension = $data['spouse_name_extension'] ?? null;
        $familyBackground->father_last_name = $data['father_last_name'] ?? null;
        $familyBackground->father_first_name = $data['father_first_name'] ?? null;
        $familyBackground->father_middle_name = $data['father_middle_name'] ?? null;
        $familyBackground->father_name_extension = $data['father_name_extension'] ?? null;
        $familyBackground->mother_maiden_surname = $data['mother_maiden_surname'] ?? null;
        $familyBackground->mother_first_name = $data['mother_first_name'] ?? null;
        $familyBackground->mother_middle_name = $data['mother_middle_name'] ?? null;
        $familyBackground->mother_name_extension = $data['mother_name_extension'] ?? null;
        $familyBackground->children = $data['children'] ?? null;
        $familyBackground->spouse_not_applicable = $data['spouse_not_applicable'] ?? false;
        $familyBackground->father_not_applicable = $data['father_not_applicable'] ?? false;
        $familyBackground->mother_not_applicable = $data['mother_not_applicable'] ?? false;
        $familyBackground->children_not_applicable = $data['children_not_applicable'] ?? false;
        $familyBackground->save();
    
        // Create Educational Background
        $educationalBackground = new EducationalBackground();
        $educationalBackground->employee_id = $employee->id;
        $educationalBackground->elementary_school_name = $data['elementary_school_name'] ?? null;
        $educationalBackground->elementary_highest_level = $data['elementary_highest_level'] ?? null;
        $educationalBackground->elementary_period_from = $data['elementary_period_from'] ?? null;
        $educationalBackground->elementary_period_to = $data['elementary_period_to'] ?? null;
        $educationalBackground->elementary_awards_received = $data['elementary_awards_received'] ?? null;
        $educationalBackground->elementary_educational_attainment = $data['elementary_educational_attainment'] ?? null;
        $educationalBackground->secondary_school_name = $data['secondary_school_name'] ?? null;
        $educationalBackground->secondary_highest_level = $data['secondary_highest_level'] ?? null;
        $educationalBackground->secondary_period_from = $data['secondary_period_from'] ?? null;
        $educationalBackground->secondary_period_to = $data['secondary_period_to'] ?? null;
        $educationalBackground->secondary_awards_received = $data['secondary_awards_received'] ?? null;
        $educationalBackground->secondary_educational_attainment = $data['secondary_educational_attainment'] ?? null;
        $educationalBackground->vocational_not_applicable = $data['vocational_not_applicable'] ?? null;
        $educationalBackground->vocational_school_name = $data['vocational_school_name'] ?? null;
        $educationalBackground->vocational_highest_level = $data['vocational_highest_level'] ?? null;
        $educationalBackground->vocational_period_from = $data['vocational_period_from'] ?? null;
        $educationalBackground->vocational_period_to = $data['vocational_period_to'] ?? null;
        $educationalBackground->vocational_awards_received = $data['vocational_awards_received'] ?? null;
        $educationalBackground->vocational_educational_attainment = $data['vocational_educational_attainment'] ?? null;
        $educationalBackground->college_school_name = $data['college_school_name'] ?? null;
        $educationalBackground->college_highest_level = $data['college_highest_level'] ?? null;
        $educationalBackground->college_period_from = $data['college_period_from'] ?? null;
        $educationalBackground->college_period_to = $data['college_period_to'] ?? null;
        $educationalBackground->college_awards_received = $data['college_awards_received'] ?? null;
        $educationalBackground->college_educational_attainment = $data['college_educational_attainment'] ?? null;
        $educationalBackground->graduate_not_applicable = $data['graduate_not_applicable'] ?? null;
        $educationalBackground->graduate_school_name = $data['graduate_school_name'] ?? null;
        $educationalBackground->graduate_highest_level = $data['graduate_highest_level'] ?? null;
        $educationalBackground->graduate_period_from = $data['graduate_period_from'] ?? null;
        $educationalBackground->graduate_period_to = $data['graduate_period_to'] ?? null;
        $educationalBackground->graduate_awards_received = $data['graduate_awards_received'] ?? null;
        $educationalBackground->graduate_educational_attainment = $data['graduate_educational_attainment'] ?? null;
        $educationalBackground->save();
    
       // Create Civil Service Eligibilities
        $civilServiceEligibilities = new CivilServiceEligibility();
        $civilServiceEligibilities->employee_id = $employee->id;
        $civilServiceEligibilities->civil_service_eligibility_not_applicable = $data['civil_service_eligibility_not_applicable'] ?? false;
        $civilServiceEligibilities->civil_service_data = $data['civil_service_data'] ?? []; // Ensure this is an array

        // Save the Civil Service Eligibility record
        $civilServiceEligibilities->save();

         // Create Work Experience
         $workExperience = new WorkExperience();
         $workExperience->employee_id = $employee->id;
         $workExperience->work_experience_not_applicable = $data['work_experience_not_applicable'] ?? false;
         $workExperience->work_experiences_data = $data['work_experiences_data'] ?? [];
 
         // Save the Work Experience
         $workExperience->save();
    
        
        // Create Voluntary Work Experience
        $voluntaryWorkExperiences = new VoluntaryWorkExperience();
        $voluntaryWorkExperiences->employee_id = $employee->id;
        $voluntaryWorkExperiences->voluntary_work_experience_not_applicable = $data['voluntary_work_experience_not_applicable'] ?? false;
        $voluntaryWorkExperiences->voluntary_work_experiences_data = $data['voluntary_work_experiences_data'] ?? [];

        // Save the Voluntary Work Experience
        $voluntaryWorkExperiences->save();


     // Create Learning and Development
     $learningDevelopment = new LearningDevelopment();
     $learningDevelopment->employee_id = $employee->id;
     $learningDevelopment->learning_development_not_applicable = $data['learning_development_not_applicable'] ?? false;
     $learningDevelopment->learning_development_experiences_data = $data['learning_development_experiences_data'] ?? [];

     // Save the Learning and Development
     $learningDevelopment->save();
    
    
        // Create Other Information
        $otherInformation = new OtherInformation();
        $otherInformation->employee_id = $employee->id;
        $otherInformation->special_skills_and_hobbies = $data['special_skills_and_hobbies'] ?? [];
        $otherInformation->non_academic_distinctions = $data['non_academic_distinctions'] ?? [];
        $otherInformation->members_in_organization = $data['members_in_organization'] ?? [];
        $otherInformation->related_to_appointing_authority = isset($data['related_to_appointing_authority']) && $data['related_to_appointing_authority'] === 'yes';
        $otherInformation->related_details_third_degree = $data['related_details_third_degree'] ?? null;
        $otherInformation->related_to_appointing_authority_fourth_degree = isset($data['related_to_appointing_authority_fourth_degree']) && $data['related_to_appointing_authority_fourth_degree'] === 'yes';
        $otherInformation->related_details_fourth_degree = $data['related_details_fourth_degree'] ?? null;
        $otherInformation->guilty_of_offense = isset($data['guilty_of_offense']) && $data['guilty_of_offense'] === 'yes';
        $otherInformation->offense_details = $data['offense_details'] ?? null;
        $otherInformation->criminally_charged = isset($data['criminally_charged']) && $data['criminally_charged'] === 'yes';
        $otherInformation->charged_details = $data['charged_details'] ?? null;
        $otherInformation->charged_date = $data['charged_date'] ?? null;
        $otherInformation->charged_status = $data['charged_status'] ?? null;
        $otherInformation->convicted_of_crime = isset($data['convicted_of_crime']) && $data['convicted_of_crime'] === 'yes';
        $otherInformation->conviction_details = $data['conviction_details'] ?? null;
        $otherInformation->separated_from_service = isset($data['separated_from_service']) && $data['separated_from_service'] === 'yes';
        $otherInformation->separation_details = $data['separation_details'] ?? null;
        $otherInformation->candidate_in_election = isset($data['candidate_in_election']) && $data['candidate_in_election'] === 'yes';
        $otherInformation->resigned_for_campaign = isset($data['resigned_for_campaign']) && $data['resigned_for_campaign'] === 'yes';
        $otherInformation->resignation_details = $data['resignation_details'] ?? null;
        $otherInformation->immigrant_or_resident = isset($data['immigrant_or_resident']) && $data['immigrant_or_resident'] === 'yes';
        $otherInformation->immigrant_details = $data['immigrant_details'] ?? null;
        $otherInformation->member_of_indigenous_group = isset($data['member_of_indigenous_group']) && $data['member_of_indigenous_group'] === 'yes';
        $otherInformation->indigenous_group_details = $data['indigenous_group_details'] ?? null;
        $otherInformation->person_with_disability = isset($data['person_with_disability']) && $data['person_with_disability'] === 'yes';
        $otherInformation->disability_id = $data['disability_id'] ?? null;
        $otherInformation->solo_parent = isset($data['solo_parent']) && $data['solo_parent'] === 'yes';
        $otherInformation->solo_parent_id = $data['solo_parent_id'] ?? null;
        $otherInformation->save();
    

        //Create  Reference record
        $referenceModel = new Reference();
        $referenceModel->employee_id = $employee->id;
        $referenceModel->reference_detail_data = json_encode($data['reference_detail_data'] ?? []);
        $referenceModel->government_id_type = $data['government_id_type'] ?? null;
        $referenceModel->government_id_type_specification = $data['government_id_type_specification'] ?? null;
        $referenceModel->government_id_number = $data['government_id_number'] ?? null;
        $referenceModel->government_id_date_place = $data['government_id_date_place'] ?? null;
    
        // Save the reference record
        $referenceModel->save();

        return $employee;
    }

}