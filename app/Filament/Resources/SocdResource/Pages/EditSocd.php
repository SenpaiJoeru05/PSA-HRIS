<?php

namespace App\Filament\Resources\SocdResource\Pages;

use App\Filament\Resources\SocdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocd extends EditRecord
{
    protected static string $resource = SocdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
