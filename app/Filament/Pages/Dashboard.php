<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\UpcomingBirthdaysWidget;

class Dashboard extends BaseDashboard
{
   public function getWidgets(): array
    {
        return [
            UpcomingBirthdaysWidget::class,
            // Add other widgets here
        ];
    }
}
