<?php

// app/Filament/Widgets/EmployeeTenureWidget.php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EmployeeTenureWidget extends ChartWidget
{
    protected static ?string $heading = 'Employee Tenure Distribution';
 protected static bool $isDiscovered = false;
    protected function getData(): array
    {
        // Query to calculate tenure distribution
        $tenureGroups = DB::table('employees')
            ->selectRaw('
                CASE
                    WHEN EXTRACT(YEAR FROM age(current_date, date_hired)) BETWEEN 0 AND 1 THEN \'0-1 Years\'
                    WHEN EXTRACT(YEAR FROM age(current_date, date_hired)) BETWEEN 2 AND 4 THEN \'2-4 Years\'
                    WHEN EXTRACT(YEAR FROM age(current_date, date_hired)) BETWEEN 5 AND 9 THEN \'5-9 Years\'
                    WHEN EXTRACT(YEAR FROM age(current_date, date_hired)) BETWEEN 10 AND 14 THEN \'10-14 Years\'
                    ELSE \'15+ Years\'
                END as tenure_group,
                COUNT(*) as count
            ')
            ->groupBy('tenure_group')
            ->get()
            ->pluck('count', 'tenure_group')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Tenure Distribution',
                    'data' => array_values($tenureGroups),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.4)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                ],
            ],
            'labels' => array_keys($tenureGroups),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // or 'pie', 'line', etc.
    }
}
