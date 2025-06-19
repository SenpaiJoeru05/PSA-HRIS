<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('province_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });

        // Seed data for cities in Region V (Bicol Region)
        $this->seedCities();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }

    /**
     * Seed cities data for Region V (Bicol Region).
     *
     * @return void
     */
    private function seedCities()
    {
        // Albay
        $provinceAlbayId = DB::table('provinces')->where('name', 'Albay')->value('id');
        DB::table('cities')->insert([
            ['province_id' => $provinceAlbayId, 'name' => 'Legazpi City'],
            ['province_id' => $provinceAlbayId, 'name' => 'Ligao City'],
            ['province_id' => $provinceAlbayId, 'name' => 'Tabaco City'],
            ['province_id' => $provinceAlbayId, 'name' => 'Polangui'],
            ['province_id' => $provinceAlbayId, 'name' => 'Guinobatan'],
            ['province_id' => $provinceAlbayId, 'name' => 'Oas'],
            ['province_id' => $provinceAlbayId, 'name' => 'Tiwi'],
            ['province_id' => $provinceAlbayId, 'name' => 'Malilipot'],
            ['province_id' => $provinceAlbayId, 'name' => 'Manito'],
            ['province_id' => $provinceAlbayId, 'name' => 'Rapu-Rapu'],
            ['province_id' => $provinceAlbayId, 'name' => 'Bacacay'],
            ['province_id' => $provinceAlbayId, 'name' => 'Malinao'],
            ['province_id' => $provinceAlbayId, 'name' => 'Daraga'],
            ['province_id' => $provinceAlbayId, 'name' => 'Jovellar'],
            ['province_id' => $provinceAlbayId, 'name' => 'Santo Domingo'],
            ['province_id' => $provinceAlbayId, 'name' => 'Pioduran'],
            ['province_id' => $provinceAlbayId, 'name' => 'Libon'],
            ['province_id' => $provinceAlbayId, 'name' => 'Camalig'],
            
        ]);

        // Camarines Norte
        $provinceCamarinesNorteId = DB::table('provinces')->where('name', 'Camarines Norte')->value('id');
        DB::table('cities')->insert([
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Daet'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Labo'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Mercedes'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Jose Panganiban'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Paracale'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Vinzons'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Capalonga'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'San Lorenzo Ruiz'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Talisay'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Santa Elena'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'Basud'],
            ['province_id' => $provinceCamarinesNorteId, 'name' => 'San Vicente'],

        ]);

        // Camarines Sur
        $provinceCamarinesSurId = DB::table('provinces')->where('name', 'Camarines Sur')->value('id');
        DB::table('cities')->insert([
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Naga City'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Iriga City'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Libmanan'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Calabanga'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Pili'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Bula'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Nabua'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Baao'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Buhi'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Sipocot'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Ragay'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Bombon'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Tigaon'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Canaman'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Magarao'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Ocampo'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Milaor'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Gainza'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Pasacao'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'San Fernando'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Presentacion'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Garchitorena'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Lagonoy'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Siruma'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Tinambac'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Baao'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Balatan'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Bato'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Caramoan'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Del Gallego'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Lupi'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Minalabac'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Pamplona'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'San Jose'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Sagñay'],
            ['province_id' => $provinceCamarinesSurId, 'name' => 'Santa Magdalena']
        ]);

       // Catanduanes
        $provinceCatanduanesId = DB::table('provinces')->where('name', 'Catanduanes')->value('id');
        DB::table('cities')->insert([
            ['province_id' => $provinceCatanduanesId, 'name' => 'Virac'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'San Andres'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'Caramoran'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'Pandan'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'Bato'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'Baras'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'Gigmoto'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'Viga'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'Bagamanoc'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'Panganiban'],
            ['province_id' => $provinceCatanduanesId, 'name' => 'San Miguel'],
        ]);

        // Masbate
        $provinceMasbateId = DB::table('provinces')->where('name', 'Masbate')->value('id');
        DB::table('cities')->insert([
            ['province_id' => $provinceMasbateId, 'name' => 'Masbate City'],
            ['province_id' => $provinceMasbateId, 'name' => 'Aroroy'],
            ['province_id' => $provinceMasbateId, 'name' => 'Baleno'],
            ['province_id' => $provinceMasbateId, 'name' => 'Balud'],
            ['province_id' => $provinceMasbateId, 'name' => 'Batuan'],
            ['province_id' => $provinceMasbateId, 'name' => 'Cataingan'],
            ['province_id' => $provinceMasbateId, 'name' => 'Cawayan'],
            ['province_id' => $provinceMasbateId, 'name' => 'Claveria'],
            ['province_id' => $provinceMasbateId, 'name' => 'Dimasalang'],
            ['province_id' => $provinceMasbateId, 'name' => 'Esperanza'],
            ['province_id' => $provinceMasbateId, 'name' => 'Mandaon'],
            ['province_id' => $provinceMasbateId, 'name' => 'Milagros'],
            ['province_id' => $provinceMasbateId, 'name' => 'Mobo'],
            ['province_id' => $provinceMasbateId, 'name' => 'Monreal'],
            ['province_id' => $provinceMasbateId, 'name' => 'Palanas'],
            ['province_id' => $provinceMasbateId, 'name' => 'Pio V. Corpuz'],
            ['province_id' => $provinceMasbateId, 'name' => 'Placer'],
            ['province_id' => $provinceMasbateId, 'name' => 'San Fernando'],
            ['province_id' => $provinceMasbateId, 'name' => 'San Jacinto'],
            ['province_id' => $provinceMasbateId, 'name' => 'San Pascual'],
            ['province_id' => $provinceMasbateId, 'name' => 'Uson'],
        ]);


        // Sorsogon
        $provinceSorsogonId = DB::table('provinces')->where('name', 'Sorsogon')->value('id');
        DB::table('cities')->insert([
            ['province_id' => $provinceSorsogonId, 'name' => 'Sorsogon City'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Bulan'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Gubat'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Barcelona'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Bulusan'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Matnog'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Pilar'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Prieto Diaz'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Santa Magdalena'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Casiguran'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Castilla'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Donsol'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Irosin'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Juban'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Magallanes'],
            ['province_id' => $provinceSorsogonId, 'name' => 'Casiguran (Baybay)'],
        ]);
    }
}
