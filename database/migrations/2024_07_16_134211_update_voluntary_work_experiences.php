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
        Schema::table('voluntary_work_experiences', function (Blueprint $table) {
            // Drop the old columns
            $table->dropColumn([
                'organization_name',
                'from_date',
                'to_date',
                'hours',
                'position'
            ]);

            // Add the new JSON column
            $table->boolean('voluntary_work_experience_not_applicable')->default(false);
            $table->json('voluntary_work_experiences_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voluntary_work_experiences', function (Blueprint $table) {
            // Add the old columns back
            $table->string('organization_name')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->integer('hours')->nullable();
            $table->string('position')->nullable();

            // Drop the new JSON column
            $table->dropColumn('voluntary_work_experiences_data');
        });
    }
};
