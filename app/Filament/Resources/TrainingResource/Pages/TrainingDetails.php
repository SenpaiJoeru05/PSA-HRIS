<?php

namespace App\Filament\Resources\TrainingResource\Pages;

use App\Filament\Resources\TrainingResource;
use Filament\Resources\Pages\Page;
use Filament\Pages\Actions;
use App\Models\Training;
use App\Models\Employee;

class TrainingDetails extends Page
{
    protected static string $resource = TrainingResource::class;
    public Training $record;
    public bool $isAddEmployeeModalOpen = false;
    public $employee_id = '';
   

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New Employee to the List')
                ->color('success')
                ->action('toggleAddEmployeeModal'),

        ];
    }

    public function mount(): void
    {
        $this->record = Training::findOrFail($this->record->id);
    }

    public function toggleAddEmployeeModal(): void
    {
        $this->isAddEmployeeModalOpen = !$this->isAddEmployeeModalOpen;
    }

    public function addEmployee(): void
    {
        // Validate input
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        // Initialize employees as an array
        $employees = $this->record->employees ?: [];

        // Check if the employee is already added
        if (!in_array($this->employee_id, $employees)) {
            // Add employee to the list
            $employees[] = $this->employee_id;
            $this->record->employees = $employees;
            $this->record->save();
        }

        // Close the modal
        $this->toggleAddEmployeeModal();
    }
    

    public function removeEmployee($employeeId): void
    {
        $employees = $this->record->employees ?: [];

        if (($key = array_search($employeeId, $employees)) !== false) {
            unset($employees[$key]);
            $this->record->employees = array_values($employees);
            $this->record->save();
        }
    }

    protected static string $view = 'filament.resources.training-resource.pages.training-details';
}
