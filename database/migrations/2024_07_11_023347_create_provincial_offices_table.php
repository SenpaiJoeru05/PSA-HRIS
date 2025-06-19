<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProvincialOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provincial_offices', function (Blueprint $table) {
            $table->id();
            $table->string('office_name');
            $table->foreignId('province_id')->constrained('provinces'); // Assuming 'provinces' table exists with 'name' column
            $table->timestamps();
        });

        // Insert predefined provincial offices
        $this->insertProvincialOffices();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provincial_offices');
    }

    /**
     * Insert predefined provincial offices.
     *
     * @return void
     */
    private function insertProvincialOffices()
    {
        // Predefined provincial offices
        $provincialOffices = [
            'Albay' => "PSA Albay Provincial Office",
            'Camarines Norte' => "PSA Camarines Norte Provincial Office",
            'Camarines Sur' => "PSA Camarines Sur Provincial Office",
            'Catanduanes' => "PSA Catanduanes Provincial Office",
            'Masbate' => "PSA Masbate Provincial Office",
            'Sorsogon' => "PSA Sorsogon Provincial Office",
        ];

        foreach ($provincialOffices as $provinceName => $officeName) {
            $province = DB::table('provinces')->where('name', $provinceName)->first();

            if ($province) {
                DB::table('provincial_offices')->insert([
                    'office_name' => $officeName,
                    'province_id' => $province->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
