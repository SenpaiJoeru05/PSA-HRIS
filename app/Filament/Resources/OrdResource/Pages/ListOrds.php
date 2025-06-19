<?php

namespace App\Filament\Resources\OrdResource\Pages;

use App\Filament\Resources\OrdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrds extends ListRecords
{
    protected static string $resource = OrdResource::class;
    public function getTitle(): string
    {
        return 'OFFICE OF REGIONAL DIVISION';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('division_id', 3);
    }
    
}
