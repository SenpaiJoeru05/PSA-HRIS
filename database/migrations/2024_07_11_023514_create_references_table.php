<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('contact');
            $table->enum('government_id_type', ['passport', 'gsis', 'sss', 'prc', 'drivers_license', 'other'])->nullable();
            $table->string('government_id_type_specification')->nullable()->after('government_id_type');
            $table->string('government_id_number')->nullable();
            $table->date('government_id_date_place')->nullable();
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
        Schema::dropIfExists('references');
    }
}
