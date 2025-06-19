<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInformationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('sex');
            $table->string('civil_status');
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('gsis_id_no')->nullable();
            $table->string('pagibig_id_no')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('sss_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('agency_employee_no')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('citizenship_by')->nullable();
            $table->string('dual_citizenship_country')->nullable();
            $table->string('residential_province_id')->nullable();
            $table->string('residential_city_id')->nullable();
            $table->string('residential_barangay')->nullable();
            $table->string('residential_subdivision_village')->nullable();
            $table->string('residential_street')->nullable();
            $table->string('residential_house_block_lot_no')->nullable();
            $table->boolean('permanent_address_same_as_residential')->default(true);
            $table->string('permanent_province')->nullable();
            $table->string('permanent_city')->nullable();
            $table->string('permanent_barangay')->nullable();
            $table->string('permanent_subdivision')->nullable();
            $table->string('permanent_street')->nullable();
            $table->string('permanent_house_number')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
}

