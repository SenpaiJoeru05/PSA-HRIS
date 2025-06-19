<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddEmployeeModal extends Component
{
    public $isAddEmployeeModalOpen = false;
    public $employee_name;

    protected $listeners = ['toggleAddEmployeeModal' => 'toggleAddEmployeeModal'];

    public function render()
    {
        return view('livewire.add-employee-modal');
    }

    public function toggleAddEmployeeModal()
    {
        $this->isAddEmployeeModalOpen = !$this->isAddEmployeeModalOpen;
    }

    public function addEmployee()
    {
        $this->emit('addEmployee', $this->employee_name);
        $this->employee_name = '';
        $this->isAddEmployeeModalOpen = false;
    }
}
