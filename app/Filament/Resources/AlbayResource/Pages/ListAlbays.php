<?php

namespace App\Filament\Resources\AlbayResource\Pages;

use App\Filament\Resources\AlbayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAlbays extends ListRecords
{
    protected static string $resource = AlbayResource::class;
    public function getTitle(): string
    {
        return 'ALBAY PROVINCIAL OFFICE';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('office_name', 'Albay Provincial Office');
    }
}
