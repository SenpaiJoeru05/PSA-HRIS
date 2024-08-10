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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->date('inclusive_dates_from')->nullable();
            $table->date('inclusive_dates_to')->nullable();
            $table->string('position_title')->nullable();
            $table->string('department_agency_office_company')->nullable();
            $table->decimal('monthly_salary', 10, 2)->nullable();
            $table->string('salary_grade_and_step')->nullable()->comment('Salary/Job Grade & Step (if applicable)');
            $table->string('status_of_appointment')->nullable();
            $table->boolean('government_service')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
