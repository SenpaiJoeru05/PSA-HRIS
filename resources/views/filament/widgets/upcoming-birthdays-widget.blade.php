<!-- resources/views/filament/widgets/upcoming-birthdays-widget.blade.php -->
<div class="p-4 bg-white rounded-lg shadow">
    <h3 class="text-lg font-semibold mb-4">Upcoming Birthdays</h3>
    <x-filament-tables::table
        :columns="$table->getColumns()"
        :rows="$table->getRows()"
    />
</div>
