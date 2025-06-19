<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Seed initial divisions data
        $this->seedDivisions();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }

    /**
     * Seed initial divisions data.
     *
     * @return void
     */
    private function seedDivisions()
    {
        $divisions = [
            'Civil Registration and Administrative Support Division (CRASD)',
            'Statistical Operations and Coordination Division (SOCD)',
            'Office of the Regional Director (ORD)',
            // Add more divisions as needed
        ];

        foreach ($divisions as $divisionName) {
            DB::table('divisions')->insert([
                'name' => $divisionName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
