<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('other_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
            
            // Special skills and hobbies
            $table->text('special_skills_and_hobbies')->nullable();

            // Non-academic distinctions/recognition
            $table->text('non_academic_distinctions')->nullable();

            // Members in association/organization
            $table->text('members_in_organization')->nullable();

            // Yes or no questions
            $table->boolean('related_to_appointing_authority')->nullable();
            $table->text('related_details_third_degree')->nullable();
            $table->boolean('related_to_appointing_authority_fourth_degree')->nullable();
            $table->text('related_details_fourth_degree')->nullable();
            $table->boolean('guilty_of_offense')->nullable();
            $table->text('offense_details')->nullable();
            $table->boolean('criminally_charged')->nullable();
            $table->text('charged_details')->nullable();
            $table->date('charged_date')->nullable();
            $table->text('charged_status')->nullable();
            $table->boolean('convicted_of_crime')->nullable();
            $table->text('conviction_details')->nullable();
            $table->boolean('separated_from_service')->nullable();
            $table->text('separation_details')->nullable();
            $table->boolean('candidate_in_election')->nullable();
            $table->boolean('resigned_for_campaign')->nullable();
            $table->text('resignation_details')->nullable();
            $table->boolean('immigrant_or_resident')->nullable();
            $table->text('immigrant_details')->nullable();
            $table->boolean('member_of_indigenous_group')->nullable();
            $table->text('indigenous_group_details')->nullable();
            $table->boolean('person_with_disability')->nullable();
            $table->text('disability_id')->nullable();
            $table->boolean('solo_parent')->nullable();
            $table->text('solo_parent_id')->nullable();

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
        Schema::dropIfExists('other_information');
    }
};
