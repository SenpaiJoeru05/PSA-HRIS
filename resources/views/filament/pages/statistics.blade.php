<x-filament::page>
    <div class="container mx-auto p-4">
        <!-- Employee Demographics Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Employee Demographics</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- Employee Gender Widget -->
                <div class="col-span-1 md:col-span-1 lg:col-span-1">
                    @livewire(App\Filament\Widgets\EmployeeGenderWidget::class)
                </div>

                <!-- Employee Age Distribution Widget -->
                <div class="col-span-1 md:col-span-1 lg:col-span-1">
                    @livewire(App\Filament\Widgets\EmployeeAgeDistributionWidget::class)
                </div>

                <!-- Employee Department Distribution Widget -->
                <div class="col-span-1 md:col-span-1 lg:col-span-1">
                    @livewire(App\Filament\Widgets\EmployeeTenureWidget::class)
                </div>

                <div class="col-span-1 md:col-span-1 lg:col-span-1">
                    @livewire(App\Filament\Widgets\DivisionDistributionChart::class)
                </div>

                <div class="col-span-1 md:col-span-1 lg:col-span-1">
                    @livewire(App\Filament\Widgets\EmployeeAdminChart::class)
                </div>
                <div class="col-span-1 md:col-span-1 lg:col-span-1">
                    @livewire(App\Filament\Widgets\EmployeeStatusStatistics::class)
                </div>
            </div>
        </div>

        <div></div>

        <!-- Training Overview Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Training Overview</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- Full-Width Training Participation Widget -->
                <div class="col-span-1 md:col-span-2 lg:col-span-3">
                    @livewire(App\Filament\Widgets\TrainingParticipationOverview::class)
                </div>
            </div>
        </div>



        
    </div>
</x-filament::page>
