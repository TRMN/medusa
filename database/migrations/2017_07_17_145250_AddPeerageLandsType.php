<?php

use App\Models\Type;
use App\Traits\MedusaAudit;
use Illuminate\Database\Migrations\Migration;

class AddPeerageLandsType extends Migration
{
    use MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lands = [
            'Keep'        => 'keep',
            'Barony'      => 'barony',
            'County'      => 'county',
            'Duchy'       => 'duchy',
            'Grand Duchy' => 'grand_duchy',
            'Steading'    => 'steading',
        ];

        foreach ($lands as $desc => $type) {
            try {
                App\Models\Type::create(['chapter_type' => $type, 'chapter_description' => $desc]);

                $this->writeAuditTrail(
                    'migration',
                    'create',
                    'type',
                    null,
                    json_encode(['chapter_type' => $type, 'chapter_description' => $desc]),
                    'AddPeerageLands Migration'
                );
            } catch (Exception $e) {
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
        $lands = [
            'Keep'        => 'keep',
            'Barony'      => 'barony',
            'County'      => 'county',
            'Duchy'       => 'duchy',
            'Grand Duchy' => 'grand_duchy',
            'Steading'    => 'steading',
        ];

        foreach ($lands as $type) {
            try {
                $typeId = App\Models\Type::where('chapter_type', $type)->first()->id;

                App\Models\Type::destroy($typeId);

                $this->writeAuditTrail(
                    'migration',
                    'destroy',
                    'type',
                    $typeId,
                    null,
                    'AddPeerageLands Migration'
                );
            } catch (Exception $e) {
            }
        }
    }
}
