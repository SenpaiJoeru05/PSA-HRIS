<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\PersonalInformation;

class EmployeeGenderWidget extends ChartWidget
{
    protected static ?string $heading = 'Employee Gender Distribution';
    protected static bool $isDiscovered = false;

    protected function getData(): array
    {
        $maleCount = PersonalInformation::where('sex', 'male')->count();
        $femaleCount = PersonalInformation::where('sex', 'female')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Employees',
                    'data' => [$maleCount, $femaleCount],
                    'backgroundColor' => ['rgba(54, 162, 235, 0.4)', 'rgba(255, 99, 132, 0.4)'],
                    'borderColor' => ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Male', 'Female'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

