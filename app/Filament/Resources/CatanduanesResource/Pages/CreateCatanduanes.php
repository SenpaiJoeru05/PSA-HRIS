<?php

namespace App\Filament\Resources\CatanduanesResource\Pages;

use App\Filament\Resources\CatanduanesResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCatanduanes extends CreateRecord
{
    protected static string $resource = CatanduanesResource::class;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee Assigned Successfully')
            ->body('The employee has been successfully assigned to the Catanduanes Provincial Office.');
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['office_name'] = 'Catanduanes Provincial Office';
        return $data;
    }
}
