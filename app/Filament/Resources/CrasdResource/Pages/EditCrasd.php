<?php

namespace App\Filament\Resources\CrasdResource\Pages;

use App\Filament\Resources\CrasdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCrasd extends EditRecord
{
    protected static string $resource = CrasdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
