<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\Widgets\EmployeeStats;
use App\Models\City;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Province;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Columns\Layout\View;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Model;




class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->collapsibleNavigationGroups(false);
    }
    

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Employee Management';
    // protected static ?string $recordTitleAttribute = 'name';
    // public static function getGloballySearchableAttributes(): array
    // {
    // return ['first_name', 'last_name'];
    // }
    protected static bool $isLazy = true;
    public static function getNavigationBadge(): ?string
    {
        return Employee::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
    


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Panel::make([
                    Split::make([
                            ImageColumn::make('user.profile_picture')
                                ->circular()
                                ->grow(false)
                                ->label('Profile Picture')
                                ->size(60)
                                ->url(fn ($record) => asset('storage/' . $record->user->profile_picture)),
                            Stack::make([
                            TextColumn::make('full_name')
                                ->label('Full Name')
                                ->weight(FontWeight::Bold)
                                ->searchable(['first_name', 'last_name'])
                                ->formatStateUsing(fn ($record) => $record->first_name . ' ' . $record->middle_name . ' ' . $record->last_name)
                                ->sortable(['first_name', 'last_name']),
                            TextColumn::make('division.name')
                                ->label('Division')
                                ->searchable(),
                            TextColumn::make('position')
                                ->label('Position')
                                ->searchable(),
                            TextColumn::make('employment_status')
                                ->label('Status')
                                ->icon('heroicon-o-user')
                                ->searchable()
                                ->alignment(Alignment::End)
                                ->color(fn ($state) => $state === 'Regular' ? 'success' : 'danger')
                                ->sortable(),
                        ]),
                        
                        // View::make('users.table.collapsible-row-content.blade.php')
                        // ->components([
                        //     TextColumn::make('email')
                        //      ->icon('heroicon-m-envelope'),
                        // ])
                         

                    ])->from('md')
                ])->collapsed(false)
            ])
            ->contentGrid([
                'md' => 4,
                'xl' => 2,
            ])
            ->paginationPageOptions([10, 20, 29])
            ->defaultSort('id', 'desc')
            
            
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
    public static function getWidgets(): array
    {
        return [
            EmployeeStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
