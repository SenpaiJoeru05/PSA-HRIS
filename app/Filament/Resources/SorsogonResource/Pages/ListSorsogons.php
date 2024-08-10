<?php

namespace App\Filament\Resources\SorsogonResource\Pages;

use App\Filament\Resources\SorsogonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSorsogons extends ListRecords
{
    protected static string $resource = SorsogonResource::class;
    public function getTitle(): string
    {
        return 'SORSOGON PROVINCIAL OFFICE';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('office_name', 'Sorsogon Provincial Office');
    }
}
