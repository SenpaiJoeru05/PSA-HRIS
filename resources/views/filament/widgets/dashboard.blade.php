<x-filament::page>
    <div class="container mx-auto p-4">
        <!-- Widgets Section -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @livewire(App\Filament\Widgets\UpcomingBirthdaysWidget::class)
            <!-- Add other widgets here -->
        </div>
    </div>
</x-filament::page>
