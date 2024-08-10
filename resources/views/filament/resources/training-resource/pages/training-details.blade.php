<x-filament::page>
    <div class="space-y-6">
        <!-- Page Title -->
        <div class="overflow-hidden bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 bg-gray-100 dark:bg-gray-800 border-b border-gray-300 dark:border-gray-700">
                <h3 class="text-xl font-semibold leading-6 text-black dark:text-white text-center">
                    {{ $record->title }}
                </h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full divide-y divide-gray-200 dark:divide-gray-600 border border-gray-300 dark:border-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-800 dark:text-gray-100 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700">
                                    Employee
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-800 dark:text-gray-100 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700">
                                    Type of LD
                                </th>
                                <th colspan="2" class="px-6 py-3 text-center text-xs font-semibold text-gray-800 dark:text-gray-100 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700">
                                    Inclusive Date of Attendance
                                    <div class="flex mt-1">
                                        <div class="flex-1 border-t border-gray-300 dark:border-gray-600 text-center py-1 border-r border-gray-300 dark:border-gray-600">
                                            From
                                        </div>
                                        <div class="flex-1 border-t border-gray-300 dark:border-gray-600 text-center py-1">
                                            To
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-800 dark:text-gray-100 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700">
                                    Number of Hours
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-800 dark:text-gray-100 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700">
                                    Conducted/Sponsored By
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-800 dark:text-gray-100 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse ($record->employees as $employeeId)
                                @php
                                    $employee = \App\Models\Employee::find($employeeId);
                                @endphp
                                @if($employee)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 text-center border-b border-gray-300 dark:border-gray-600 border-r border-gray-300 dark:border-gray-600">
                                            {{ $employee->full_name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 text-center border-b border-gray-300 dark:border-gray-600 border-r border-gray-300 dark:border-gray-600">
                                            {{ $record->type_of_ld }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-300 dark:border-gray-600 border-r border-gray-300 dark:border-gray-600">
                                            <div class="text-center">
                                                {{ $record->start_date ? $record->start_date->format('m-d-Y') : 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-300 dark:border-gray-600">
                                            <div class="text-center">
                                                {{ $record->end_date ? $record->end_date->format('m-d-Y') : 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 text-center border-b border-gray-300 dark:border-gray-600 border-r border-gray-300 dark:border-gray-600">
                                            {{ $record->number_of_hours }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 text-center border-b border-gray-300 dark:border-gray-600 border-r border-gray-300 dark:border-gray-600">
                                            {{ $record->conducted_by }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm font-medium border-b border-gray-300 dark:border-gray-600">
                                            <x-filament::button wire:click="removeEmployee({{ $employee->id }})" color="danger" size="sm" aria-label="Remove {{ $employee->full_name }}">
                                                Remove
                                            </x-filament::button>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400 border-b border-gray-300 dark:border-gray-600">
                                        No employees found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Employee Modal -->
        @if($isAddEmployeeModalOpen)
            <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-lg shadow-lg w-full sm:w-3/4 md:w-1/2 lg:w-1/3 max-w-3xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6 text-center">Add Employee to Training</h3>
                    <div class="space-y-6">
                        <div>
                            <label for="employee_id" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Employee</label>
                            <select wire:model="employee_id" id="employee_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" aria-describedby="employee_id_error">
                                <option value="">Select Employee</option>
                                @foreach(\App\Models\Employee::all() as $employee)
                                    @if(!in_array($employee->id, $record->employees))
                                        <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('employee_id')
                                <p id="employee_id_error" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <x-filament::button wire:click="addEmployee" color="primary" aria-label="Add Employee">
                                Add Employee
                            </x-filament::button>
                            <x-filament::button wire:click="toggleAddEmployeeModal" color="primary" aria-label="Close Modal" style="margin-left: 1rem;">
                                Cancel
                            </x-filament::button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament::page>
