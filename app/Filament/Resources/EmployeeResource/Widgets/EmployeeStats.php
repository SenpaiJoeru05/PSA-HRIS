<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Employees', Employee::all()->count()),
            Card::make('Active Employees',Employee::where('employment_status','Regular')->count()),
            Card::make('Inactive Employees', Employee::whereIn('employment_status', ['Resigned', 'Retired'])->count()),
        ];
    }
}
