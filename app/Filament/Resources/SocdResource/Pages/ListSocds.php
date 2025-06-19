<?php

namespace App\Filament\Resources\SocdResource\Pages;

use App\Filament\Resources\SocdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSocds extends ListRecords
{
    public function getTitle(): string
    {
        return 'STATISTIC OPERATION AND COORDINATION DIVISION';
    }
    protected static string $resource = SocdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('division_id', 2);
    }
}
