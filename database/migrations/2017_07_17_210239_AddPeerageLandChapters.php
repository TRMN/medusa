<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Chapter;
use App\Audit\MedusaAudit;

class AddPeerageLandChapters extends Migration
{
    use MedusaAudit;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            "keep" => [
                "Day Keep",
                "Lochen Keep"
            ],
            'barony' => [
                'Nový Prerov',
                'Neu Sachsen',
                'Cumberland Moor',
                'Tesseyman',
                'Leutzen Vale',
                'New Mimas',
                'Glencairn',
                'New Arlington',
                'Allegheny-Mellon',
                'White Rose',
                'New Victoria',
                'Cape Fear',
                'Runnymead Fields',
                'Piedmont',
                'New Kasserine',
                'Mars-Evans',
                'Havelock',
                'White Lion',
                'Miyake-jima',
                'Blacksburg',
                'Bahia Cadiz',
                'New Dover',
                'Serpent Head Point',
                'Silver Heath',
                'Redstone',
                'Camera Stellata',
                'New Adelaide',
            ],
            'county' => [
                'New Cumbria',
                'Neu Odenwaldkreis',
                'New Mecklenburg',
                'Westmarch',
                'Fontana Flats',
                'Nya Östergötland',
                'Boundary Waters'
            ],
            'steading' => [
                'Blackbird Steading',
                'Pittman Steading',
                'Henessey Steading',
                'Maelstromm Steading'
            ],
            'duchy' => [
                'New Scania',
                'New Ulyanovsk',
                'Karstadt Sea',
                'Mountain View'
            ],
            'grand_duchy' => [
                'Montana',
                'New Arkhangelsk'
            ]
        ];

        foreach($data as $type => $lands) {
            foreach ($lands as $land) {
                try {
                    Chapter::create(['chapter_type' => $type, 'chapter_name' => $land]);

                    $this->writeAuditTrail(
                        'migration',
                        'create',
                        'chapter',
                        null,
                        json_encode(['chapter_type' => $type, 'chapter_name' => $land]),
                        'AddPeerageLandChapters Migration'
                    );
                } catch (Exception $e) {

                }

            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach(['keep', 'barony', 'county', 'steading', 'duchy', 'grand_duchy'] as $type) {
            foreach(Chapter::where('chapter_type', $type)->get() as $land) {
                Chapter::destroy($land->id);
            }
        }
    }
}
