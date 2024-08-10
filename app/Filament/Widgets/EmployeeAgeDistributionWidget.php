<?php


namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EmployeeAgeDistributionWidget extends ChartWidget
{
    protected static ?string $heading = 'Employee Age Distribution';
    protected static bool $isDiscovered = false;

    protected function getData(): array
    {
        // Query to calculate age distribution
        $ageGroups = DB::table('personal_information')
            ->selectRaw('
                CASE
                    WHEN EXTRACT(YEAR FROM age(current_date, date_of_birth)) BETWEEN 20 AND 29 THEN \'20-29\'
                    WHEN EXTRACT(YEAR FROM age(current_date, date_of_birth)) BETWEEN 30 AND 39 THEN \'30-39\'
                    WHEN EXTRACT(YEAR FROM age(current_date, date_of_birth)) BETWEEN 40 AND 49 THEN \'40-49\'
                    WHEN EXTRACT(YEAR FROM age(current_date, date_of_birth)) BETWEEN 50 AND 59 THEN \'50-59\'
                    ELSE \'60+\'
                END as age_group,
                COUNT(*) as count
            ')
            ->groupBy('age_group')
            ->get()
            ->pluck('count', 'age_group')
            ->toArray();

        // Define the colors for each age group
        $colors = [
            '20-29' => 'rgba(54, 162, 235, 0.4)',
            '30-39' => 'rgba(75, 192, 192, 0.4)',
            '40-49' => 'rgba(255, 206, 86, 0.4)',
            '50-59' => 'rgba(153, 102, 255, 0.4)',
            '60+'   => 'rgba(255, 99, 132, 0.4)',
        ];

        // Define the border colors for each age group
        $borderColors = [
            '20-29' => 'rgba(54, 162, 235, 1)',
            '30-39' => 'rgba(75, 192, 192, 1)',
            '40-49' => 'rgba(255, 206, 86, 1)',
            '50-59' => 'rgba(153, 102, 255, 1)',
            '60+'   => 'rgba(255, 99, 132, 1)',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Age Distribution',
                    'data' => array_values($ageGroups),
                    'backgroundColor' => array_map(fn($ageGroup) => $colors[$ageGroup], array_keys($ageGroups)),
                    'borderColor' => array_map(fn($ageGroup) => $borderColors[$ageGroup], array_keys($ageGroups)),
                ],
            ],
            'labels' => array_keys($ageGroups),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // or 'pie', 'line', etc.
    }
}

