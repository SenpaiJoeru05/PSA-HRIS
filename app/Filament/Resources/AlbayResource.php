<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlbayResource\Pages;
use App\Models\ProvincialOffice;
use App\Models\Employee;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Contexts\SaveData;
use Filament\Support\Enums\MaxWidth;
class AlbayResource extends Resource
{
    protected static ?string $model = ProvincialOffice::class;
    
    protected static ?string $pluralModelLabel = 'ALBAY';

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Province Offices';
    // public static function getGloballySearchableAttributes(): array
    // {
    // return ['first_name', 'last_name','division.name'];
    // }
//     protected function getCreatedNotificationTitle(): ?string
// {
//     return 'The Employee assigned to Albay Provincial Office';
// }
    public function panel(Panel $panel): Panel
    {
    return $panel
        ->maxContentWidth(MaxWidth::Full);
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('office_name', 'Albay Provincial Office')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
    
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('employee_id')
                ->label('Select Employee')
                ->unique()
                ->allowHtml()
                ->searchable() 
                ->getSearchResultsUsing(function (string $search) {
                    return Employee::with('user')
                        ->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) LIKE ?", ["%".strtolower($search)."%"])
                        ->limit(50)
                        ->get()
                        ->mapWithKeys(function ($employee) {
                            $htmlOption = "
                                <div class='flex rounded-md relative'>
                                    <div class='flex'>
                                        <div class='px-2 py-3'>
                                            <div class='h-10 w-10'>
                                                <img src='" . url('/storage/' . $employee->user->profile_picture) . "' alt='" . $employee->first_name . " " . $employee->last_name . "' role='img' class='h-full w-full rounded-full overflow-hidden shadow object-cover' />
                                            </div>
                                        </div>
                                        <div class='flex flex-col justify-center pl-3 py-2'>
                                            <p class='text-sm font-bold pb-1'>" . $employee->first_name . " " . $employee->last_name . "</p>
                                            <div class='flex flex-col items-start'>
                                                <p class='text-xs leading-5'>" . $employee->position . "</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ";
                            return [$employee->id => $htmlOption];
                        })->toArray();
                })
                ->getOptionLabelUsing(function ($value): string {
                    $employee = Employee::with('user')->find($value);
                    $htmlOption = "
                        <div class='flex rounded-md relative'>
                            <div class='flex'>
                                <div class='px-3 py-3'>
                                    <div class='h-10 w-10'>
                                        <img src='" . url('/storage/' . $employee->user->profile_picture) . "' alt='" . $employee->first_name . " " . $employee->last_name . "' role='img' class='h-full w-full rounded-full overflow-hidden shadow object-cover' />
                                    </div>
                                </div>
                                <div class='flex flex-col justify-center pl-3 py-2'>
                                    <p class='text-sm font-bold pb-1'>" . $employee->first_name . " " . $employee->last_name . "</p>
                                    <div class='flex flex-col items-start'>
                                        <p class='text-xs leading-5'>" . $employee->position . "</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                    return $htmlOption;
                })
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Panel::make([
                    Split::make([
                        ImageColumn::make('employee.user.profile_picture')
                            ->circular()
                            ->grow(false)
                            ->label('Profile Picture')
                            ->size(60)
                            ->url(fn ($record) => $record->employee ? asset('storage/' . $record->employee->user->profile_picture) : null),
                        
                        Stack::make([
                            TextColumn::make('employee.full_name')
                                ->label('Full Name')
                                ->weight(FontWeight::Bold)
                                ->searchable(['first_name', 'last_name'])
                                ->formatStateUsing(fn ($record) => $record->employee->full_name ?? 'N/A')
                                ->sortable(),
                            TextColumn::make('employee.division_name')
                                ->label('Division')
                                ->sortable(),
                            TextColumn::make('employee.position')
                                ->label('Position')
                                ->sortable(),
                                TextColumn::make('employment_status')
                                ->label('Status')
                                ->icon('heroicon-o-user')
                                ->alignment(Alignment::End)
                                ->color(fn ($state) => $state === 'Regular' ? 'success' : 'danger')
                                ->sortable(),
                        ])
                    ])->from('md')
                ])
                ->collapsed(false),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 2,
            ])
            
            
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                ->label('remove'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
          
    }
   

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlbays::route('/'),
            'create' => Pages\CreateAlbay::route('/create'),
        ];
    }
}
