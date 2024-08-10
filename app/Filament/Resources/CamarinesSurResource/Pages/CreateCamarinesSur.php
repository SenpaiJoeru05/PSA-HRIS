<?php

namespace App\Filament\Resources\CamarinesSurResource\Pages;

use App\Filament\Resources\CamarinesSurResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCamarinesSur extends CreateRecord
{
    protected static string $resource = CamarinesSurResource::class;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee Assigned Successfully')
            ->body('The employee has been successfully assigned to the Camarines Sur Provincial Office.');
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['office_name'] = 'Camarines Sur Provincial Office';
        return $data;
    }

}
