<?php

namespace App\Filament\Resources\MasbateResource\Pages;

use App\Filament\Resources\MasbateResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMasbate extends CreateRecord
{
    protected static string $resource = MasbateResource::class;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee Assigned Successfully')
            ->body('The employee has been successfully assigned to the Masbate Provincial Office.');
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['office_name'] = 'Masbate Provincial Office';
        return $data;
    }
}
