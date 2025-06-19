<div class="p-4 bg-white rounded-lg shadow">
    <h3 class="text-lg font-semibold mb-4">
        <x-heroicon-s-user-add class="w-6 h-6 text-gray-500 inline-block mr-2" />
        Recently Added Employees
    </h3>
    <x-filament-tables::table
        :columns="$table->getColumns()"
        :rows="$table->getRows()"
    />
</div>
