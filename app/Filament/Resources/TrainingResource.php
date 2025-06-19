<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingResource\Pages;
use App\Models\Employee;
use App\Models\Training;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingResource extends Resource {
    protected static ?string $model = Training::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Training And Seminars';
    public static function getNavigationBadge(): ?string
    {
        return Training::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('type_of_ld')
                    ->label('Type of LD')
                    ->required(),
                Select::make('employees')
                    ->label('Select Employees')
                    ->multiple()
                    ->options(Employee::all()->pluck('full_name', 'id'))
                    ->searchable()
                    ->required(),
                DatePicker::make('start_date')
                    ->label('From')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('To')
                    ->required(),
                TextInput::make('number_of_hours')
                    ->required()
                    ->numeric(),
                TextInput::make('conducted_by')
                    ->label('Conducted/Sponsored By')
                    ->required()
                    ->maxLength(255),
            ]);
    }


    public static function table(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->wrap()
                    ->searchable(),
                TextColumn::make('type_of_ld')
                    ->label('Type of LD')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->sortable()
                    ->placeholder('Never')
                    ->searchable()
                    ->formatStateUsing(fn($state) => $state ? $state->diffForHumans() : 'N/A'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array {
        return [];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListTrainings::route('/'),
            'create' => Pages\CreateTraining::route('/create'),
            'edit' => Pages\EditTraining::route('/{record}/edit'),
            'view' => Pages\TrainingDetails::route('/{record}'),
        ];
    }
}
