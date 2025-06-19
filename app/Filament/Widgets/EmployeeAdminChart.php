<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class EmployeeAdminChart extends ChartWidget
{
    protected static bool $isDiscovered = false;
    protected static ?int $sort = 1;
    protected static ?string $heading = 'Employee Chart';
    
    protected static string $color = 'success';
    protected function getType(): string
    {
        return 'line'; // or 'bar', 'pie', 'doughnut', etc. depending on the chart type you want
    }
    public function getDescription(): ?string
    {
    return 'no. of new Employee added to system per day.';
    }
    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $data = Trend::model(Employee::class)
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Employees',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.4)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

}
