<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProvincialOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provincial_offices', function (Blueprint $table) {
            // Drop the existing foreign key and column
            $table->dropForeign(['province_id']);
            $table->dropColumn('province_id');

            // Add the new employee_id column
            $table->foreignId('employee_id')
                ->nullable()
                ->constrained('employees')
                ->onDelete('set null');

            // Add unique constraint to prevent duplication
            $table->unique('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provincial_offices', function (Blueprint $table) {
            // Add the province_id column back and allow null temporarily
            $table->foreignId('province_id')->nullable()->constrained('provinces')->onDelete('cascade');
        });

        // After rollback, set the column to non-nullable and provide default values
        Schema::table('provincial_offices', function (Blueprint $table) {
            $table->foreignId('province_id')->nullable(false)->change();
        });
    }
}

