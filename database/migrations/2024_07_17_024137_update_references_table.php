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
        Schema::table('references', function (Blueprint $table) {
            // Drop the columns
            $table->dropColumn([
                'name',
                'address',
                'contact',
            ]);

            // Add JSON column to store reference details
            $table->json('reference_detail_data')->nullable()->after('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('references', function (Blueprint $table) {
            // Recreate dropped columns
            $table->string('name');
            $table->string('address');
            $table->string('contact');

            // Drop JSON column
            $table->dropColumn('reference_detail_data');
        });
    }
};
