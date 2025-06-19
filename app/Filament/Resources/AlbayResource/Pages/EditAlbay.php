<?php

namespace App\Filament\Resources\AlbayResource\Pages;

use App\Filament\Resources\AlbayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlbay extends EditRecord
{
    protected static string $resource = AlbayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
