<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('civil_service_eligibilities', function (Blueprint $table) {
            $table->renameColumn('civil_service_eligibilities', 'civil_service_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('civil_service_eligibilities', function (Blueprint $table) {
            $table->renameColumn('civil_service_data', 'civil_service_eligibilities');
        });
    }
};
