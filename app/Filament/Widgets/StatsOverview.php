<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use App\Models\Training;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;
   
  
    protected static ?string $pollingInterval = '15s';
    protected static bool $islazy = false;
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Employees', Employee::count())
            ->icon('heroicon-o-user-group'),
            Stat::make('Training', Training::query()->count())
            ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('Active Employees',Employee::where('employment_status','Regular')->count())
            ->icon('heroicon-o-face-smile'),
        ];
    }
}
