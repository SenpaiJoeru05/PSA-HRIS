<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddEmployeeIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if the foreign key constraint exists before dropping it
            $foreignKeyExists = DB::select("SELECT constraint_name
                                            FROM information_schema.table_constraints
                                            WHERE table_name = 'users' 
                                            AND constraint_type = 'FOREIGN KEY' 
                                            AND constraint_name = 'users_employee_id_foreign'");
            
            if (!empty($foreignKeyExists)) {
                $table->dropForeign(['employee_id']);
            }

            if (Schema::hasColumn('users', 'employee_id')) {
                $table->dropColumn('employee_id');
            }
        });
    }
}
