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
        Schema::table('work_experiences', function (Blueprint $table) {
            // Drop the old columns
            $table->dropColumn([
                'inclusive_dates_from',
                'inclusive_dates_to',
                'position_title',
                'department_agency_office_company',
                'monthly_salary',
                'salary_grade_and_step',
                'status_of_appointment',
                'government_service'
            ]);

            // Add the new JSON column
            $table->json('work_experiences_data')->nullable();
            $table->boolean('work_experience_not_applicable')->default(false)->nullable(); // Add this line
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            // Add the old columns back
            $table->date('inclusive_dates_from')->nullable();
            $table->date('inclusive_dates_to')->nullable();
            $table->string('position_title')->nullable();
            $table->string('department_agency_office_company')->nullable();
            $table->decimal('monthly_salary', 10, 2)->nullable();
            $table->string('salary_grade_and_step')->nullable()->comment('Salary/Job Grade & Step (if applicable)');
            $table->string('status_of_appointment')->nullable();
            $table->boolean('government_service')->default(false)->nullable();

            // Drop the new JSON column
            $table->dropColumn('work_experiences_data');
        });
    }
};
