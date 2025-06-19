<?php

namespace App\Filament\Resources\CamarinesNorteResource\Pages;

use App\Filament\Resources\CamarinesNorteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCamarinesNorte extends EditRecord
{
    protected static string $resource = CamarinesNorteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
