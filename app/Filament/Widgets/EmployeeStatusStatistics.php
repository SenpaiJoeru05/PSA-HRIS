<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeStatusStatistics extends ChartWidget
{
    protected static ?string $heading = 'Employment Status';
    protected static bool $isDiscovered = false;

    protected function getData(): array
    {
        $statuses = Employee::select('employment_status', DB::raw('count(*) as count'))
            ->groupBy('employment_status')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Number of Employees',
                    'data' => $statuses->pluck('count')->toArray(),
                    'backgroundColor' => [
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(255, 99, 132, 0.4)',
                        'rgba(255, 206, 86, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                    ],
                    'borderColor' => [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $statuses->pluck('employment_status')->toArray(),
        ];
    }
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'width' => 0,  // Set the desired width
            'height' => 0, // Set the desired height
        ];
    }

    protected function getType(): string
    {
        return 'pie'; 
    }
}
