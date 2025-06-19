<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Widgets\ChartWidget;

class DivisionDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Division Distribution';
    protected static bool $isDiscovered = false;
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $divisions = [
            1 => 'CRASD',
            2 => 'SOCD',
            3 => 'ORD',
        ];

        $data = [];
        foreach ($divisions as $id => $name) {
            $data[] = Employee::where('division_id', $id)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Employees',
                    'data' => $data,
                    'borderWidth' => 1,
                    'backgroundColor' => [
                        'rgba(255, 92, 94, 0.4)', // Transparent color for CRASD
                        'rgba(109, 226, 249, 0.4)', // Transparent color for SOCD
                        'rgba(255, 253, 150, 0.4)', // Transparent color for ORD
                    ],
                    'borderColor' => [
                        '#ff5c5e', // Solid border color for CRASD
                        '#6de2f9', // Solid border color for SOCD
                        '#fffd96', // Solid border color for ORD
                    ],
                ],
            ],
            'labels' => array_values($divisions),
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
        return 'doughnut';
    }
}
