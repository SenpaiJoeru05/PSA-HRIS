<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingBirthdaysWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = '2xl';
    protected static bool $isLazy = true;

    public function table(Table $table): Table
    {
        return $table
            ->query(Employee::query()
                ->join('personal_information', 'employees.id', '=', 'personal_information.employee_id')
                ->whereRaw('EXTRACT(MONTH FROM date_of_birth) = ?', [now()->month])
                ->whereRaw('EXTRACT(DAY FROM date_of_birth) >= ?', [now()->day])
                ->orderByRaw('EXTRACT(DAY FROM date_of_birth)')
                ->limit(5)
            )
            ->columns([
                ImageColumn::make('user.profile_picture')
                    ->circular()
                    ->grow(false)
                    ->label(false)
                    ->size(60)
                    ->url(fn ($record) => asset('storage/' . $record->user->profile_picture)),
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn ($record) => $record->first_name . ' ' . $record->middle_name . ' ' . $record->last_name),
                TextColumn::make('date_of_birth')
                    ->label('Birthday')
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('F j')),
            ])->paginated(false); 
    }
}
