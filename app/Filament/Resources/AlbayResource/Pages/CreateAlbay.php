<?php

namespace App\Filament\Resources\AlbayResource\Pages;

use App\Filament\Resources\AlbayResource;
use App\Models\Alba;
use App\Models\ProvincialOffice;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAlbay extends CreateRecord
{
    protected static string $resource = AlbayResource::class;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee Assigned Successfully')
            ->body('The employee has been successfully assigned to the Albay office.');
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['office_name'] = 'Albay Provincial Office';
        return $data;
    }
    protected function getAssignedEmployeeIds(): array
{
    // Assuming you have a relationship or a way to fetch assigned employees
    return ProvincialOffice::pluck('employee_id')->toArray();
}
}

