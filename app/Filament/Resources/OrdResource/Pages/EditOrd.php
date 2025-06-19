<?php

namespace App\Filament\Resources\OrdResource\Pages;

use App\Filament\Resources\OrdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrd extends EditRecord
{
    protected static string $resource = OrdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
