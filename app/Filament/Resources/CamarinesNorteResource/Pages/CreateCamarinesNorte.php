<?php

namespace App\Filament\Resources\CamarinesNorteResource\Pages;

use App\Filament\Resources\CamarinesNorteResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCamarinesNorte extends CreateRecord
{
    protected static string $resource = CamarinesNorteResource::class;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee Assigned Successfully')
            ->body('The employee has been successfully assigned to the Camarines Norte Provincial Office.');
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['office_name'] = 'Camarines Norte Provincial Office';
        return $data;
    }

}
