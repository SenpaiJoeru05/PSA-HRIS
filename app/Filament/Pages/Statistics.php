<?php


// In D:\PSA\PSA-HRIS-MAIN\app\Filament\Pages\Statistics.php
namespace App\Filament\Pages;

use App\Filament\Widgets\DivisionDistributionChart;
use Filament\Pages\Page;
use App\Filament\Widgets\EmployeeGenderWidget;
use App\Filament\Widgets\EmployeeAgeDistributionWidget;
use App\Filament\Widgets\EmployeeTenureWidget;

class Statistics extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Statistics';

    protected static string $view = 'filament.pages.statistics';
    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         EmployeeGenderWidget::class,
    //         EmployeeAgeDistributionWidget::class,
    //         EmployeeTenureWidget::class,
    //         DivisionDistributionChart::class,
    //     ];
    // }

}
