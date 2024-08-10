<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Carbon\Carbon;


class RecentlyAddedEmployees extends BaseWidget
{
    protected static ?string $heading = 'Recently Added Employees';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = '2xl';
    protected static bool $isLazy = true;
    
    
    public function table(Table $table): Table
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return $table
            ->query(Employee::query()
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->orderBy('created_at', 'desc')
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
                TextColumn::make('created_at')
                    ->label('Last Created')
                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->diffForHumans() : 'N/A'),
            ])->paginated(false); 
    }
}