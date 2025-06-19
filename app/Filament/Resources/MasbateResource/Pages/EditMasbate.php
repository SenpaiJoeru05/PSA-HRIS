<?php

namespace App\Filament\Resources\MasbateResource\Pages;

use App\Filament\Resources\MasbateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasbate extends EditRecord
{
    protected static string $resource = MasbateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
