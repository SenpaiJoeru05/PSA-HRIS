<?php

namespace App\Filament\Resources\CatanduanesResource\Pages;

use App\Filament\Resources\CatanduanesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCatanduanes extends ListRecords
{
    protected static string $resource = CatanduanesResource::class;
    public function getTitle(): string
    {
        return 'CATANDUANES PROVINCIAL OFFICE';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('office_name', 'Catanduanes Provincial Office');
    }
}
