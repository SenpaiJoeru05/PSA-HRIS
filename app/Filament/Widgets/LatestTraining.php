<?php

namespace App\Filament\Widgets;

use App\Models\Training;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTraining extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    protected static bool $isLazy = true;

    public function table(Table $table): Table
    {
        return $table
            ->query(Training::query()
                ->latest('created_at') // Orders by latest created_at date
                ->limit(5) // Limits the results to 5
            )
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->wrap()
                    ->limit(60),
                TextColumn::make('type_of_ld')
                    ->label('Type of LD')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->sortable()
                    ->placeholder('Never')
                    ->formatStateUsing(fn($state) => $state ? $state->diffForHumans() : 'N/A'),
            ])
            ->paginated(false); // Disable pagination by limiting the result to 5
    }
}
