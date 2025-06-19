<?php

namespace App\Filament\Resources\CamarinesSurResource\Pages;

use App\Filament\Resources\CamarinesSurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCamarinesSurs extends ListRecords
{
    protected static string $resource = CamarinesSurResource::class;
    public function getTitle(): string
    {
        return 'CAMARINES SUR PROVINCIAL OFFICE';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('office_name', 'Camarines Sur Provincial Office');
    }
}
