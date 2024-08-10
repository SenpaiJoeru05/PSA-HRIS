<?php

namespace App\Filament\Resources\CrasdResource\Pages;

use App\Filament\Resources\CrasdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCrasds extends ListRecords
{
    protected static string $resource = CrasdResource::class;
    public function getTitle(): string
    {
        return 'CIVIL REGISTRATION AND ADMINISTRATIVE SUPPORT DIVISION';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('division_id', 1);
    }
}
