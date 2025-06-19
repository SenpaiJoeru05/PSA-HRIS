<?php

namespace App\Filament\Resources\CamarinesNorteResource\Pages;

use App\Filament\Resources\CamarinesNorteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCamarinesNortes extends ListRecords
{
    protected static string $resource = CamarinesNorteResource::class;
    public function getTitle(): string
    {
        return 'CAMARINES NORTE PROVINCIAL OFFICE';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('office_name', 'Camarines Norte Provincial Office');
    }
}
