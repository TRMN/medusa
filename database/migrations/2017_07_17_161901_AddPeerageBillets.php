<?php

use App\Audit\MedusaAudit;
use Illuminate\Database\Migrations\Migration;

class AddPeerageBillets extends Migration
{
    use MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $billets = [
            'Knight',
            'Dame',
            'Baron',
            'Baroness',
            'Earl',
            'Countess',
            'Duke',
            'Duchess',
            'Grand Duke',
            'Grand Duchess',
            'Steadholder',
            'Majordomo',
        ];

        foreach ($billets as $billet) {
            try {
                App\Billet::create(['billet_name' => $billet]);

                $this->writeAuditTrail(
                    'migration',
                    'create',
                    'billet',
                    null,
                    json_encode(['billet_name' => $billet]),
                    'AddPeerageBillets Migration'
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
        $billets = [
            'Knight',
            'Dame',
            'Baron',
            'Baroness',
            'Earl',
            'Countess',
            'Duke',
            'Duchess',
            'Grand Duke',
            'Grand Duchess',
            'Steadholder',
            'Majordomo',
        ];

        foreach ($billets as $billet) {
            try {
                $billetId = App\Billet::where('billet_name', $billet)->first()->id;

                App\Billet::destroy($billetId);

                $this->writeAuditTrail(
                    'migration',
                    'destroy',
                    'billet',
                    $billetId,
                    null,
                    'AddPeerageBillets Migration'
                );
            } catch (Exception $e) {
            }
        }
    }
}
