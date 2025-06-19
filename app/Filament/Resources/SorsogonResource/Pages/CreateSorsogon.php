<?php

namespace App\Filament\Resources\SorsogonResource\Pages;

use App\Filament\Resources\SorsogonResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSorsogon extends CreateRecord
{
    protected static string $resource = SorsogonResource::class;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee Assigned Successfully')
            ->body('The employee has been successfully assigned to the Sorsogon Provincial Office.');
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['office_name'] = 'Sorsogon Provincial Office';
        return $data;
    }
}
