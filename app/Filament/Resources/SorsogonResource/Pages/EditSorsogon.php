<?php

namespace App\Filament\Resources\SorsogonResource\Pages;

use App\Filament\Resources\SorsogonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSorsogon extends EditRecord
{
    protected static string $resource = SorsogonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
