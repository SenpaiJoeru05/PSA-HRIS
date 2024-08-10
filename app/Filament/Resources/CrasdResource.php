<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CrasdResource\Pages;
use App\Models\Employee;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\Layout\Split;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CrasdResource extends Resource
{
    public static function canCreate(): bool {
        return false;
    }
    protected static ?string $model = Employee::class;
    protected static ?string $pluralModelLabel = 'CRASD';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'RSSO V';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('division_id', '1')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
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
                        ->url(fn ($record) => $record->user ? asset('storage/' . $record->user->profile_picture) : asset('default-profile.png')),
                    Stack::make([
                        TextColumn::make('full_name')
                            ->label('Full Name')
                            ->weight(FontWeight::Bold)
                            ->searchable(['first_name', 'last_name'])
                            ->visibleFrom('md')
                            ->formatStateUsing(fn ($record) => $record->full_name ?? 'N/A')
                            ->sortable(),
                        TextColumn::make('position')
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
            ->filters([])
            ->actions([])
            ->bulkActions([]);
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
            'index' => Pages\ListCrasds::route('/'),
        ];
    }
}
