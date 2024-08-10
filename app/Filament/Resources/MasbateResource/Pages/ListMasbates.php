<?php

namespace App\Filament\Resources\MasbateResource\Pages;

use App\Filament\Resources\MasbateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMasbates extends ListRecords
{
    protected static string $resource = MasbateResource::class;
    public function getTitle(): string
    {
        return 'MASBATE PROVINCIAL OFFICE';
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('office_name', 'Masbate Provincial Office');
    }
}
