<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educational_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
            // Elementary
            $table->string('elementary_school_name')->nullable();
            $table->string('elementary_highest_level')->nullable();
            $table->date('elementary_period_from')->nullable();
            $table->date('elementary_period_to')->nullable();
            $table->string('elementary_awards_received')->nullable();
            $table->string('elementary_educational_attainment')->nullable();
            // Secondary
            $table->string('secondary_school_name')->nullable();
            $table->string('secondary_highest_level')->nullable();
            $table->date('secondary_period_from')->nullable();
            $table->date('secondary_period_to')->nullable();
            $table->string('secondary_awards_received')->nullable();
            $table->string('secondary_educational_attainment')->nullable();
            // Vocational/Trade Course
            $table->string('vocational_school_name')->nullable();
            $table->string('vocational_highest_level')->nullable();
            $table->date('vocational_period_from')->nullable();
            $table->date('vocational_period_to')->nullable();
            $table->string('vocational_awards_received')->nullable();
            $table->string('vocational_educational_attainment')->nullable();
            // College
            $table->string('college_school_name')->nullable();
            $table->string('college_highest_level')->nullable();
            $table->date('college_period_from')->nullable();
            $table->date('college_period_to')->nullable();
            $table->string('college_awards_received')->nullable();
            $table->string('college_educational_attainment')->nullable();
            // Graduate Studies
            $table->string('graduate_school_name')->nullable();
            $table->string('graduate_highest_level')->nullable();
            $table->date('graduate_period_from')->nullable();
            $table->date('graduate_period_to')->nullable();
            $table->string('graduate_awards_received')->nullable();
            $table->string('graduate_educational_attainment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('educational_backgrounds');
    }

};
