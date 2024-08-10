<?php

namespace App\Filament\Resources\CamarinesSurResource\Pages;

use App\Filament\Resources\CamarinesSurResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCamarinesSur extends EditRecord
{
    protected static string $resource = CamarinesSurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
