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
        Schema::table('family_background', function (Blueprint $table) {
            // Adding the new checkbox columns
            $table->boolean('spouse_not_applicable')->default(false);
            $table->boolean('father_not_applicable')->default(false);
            $table->boolean('mother_not_applicable')->default(false);
            $table->boolean('children_not_applicable')->default(false);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_background', function (Blueprint $table) {
            $table->dropColumn([
                'spouse_not_applicable',
                'father_not_applicable',
                'mother_not_applicable',
                'children_not_applicable',
            ]);
        });
    }
};
