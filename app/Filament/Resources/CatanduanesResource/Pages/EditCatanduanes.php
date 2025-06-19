<?php

namespace App\Filament\Resources\CatanduanesResource\Pages;

use App\Filament\Resources\CatanduanesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatanduanes extends EditRecord
{
    protected static string $resource = CatanduanesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
