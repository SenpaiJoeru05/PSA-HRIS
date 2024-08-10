<!-- resources/views/filament/widgets/employee-age-distribution-widget.blade.php -->

<x-filament::widget>
    <x-filament::chart :data="$this->getData()" :type="$this->getType()" />
</x-filament::widget>
