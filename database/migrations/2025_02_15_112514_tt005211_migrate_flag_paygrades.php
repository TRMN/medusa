<?php

use App\Grade;
use App\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class TT005211MigrateFlagPaygrades extends Migration
{
    use \App\Audit\MedusaAudit;

    protected $paygrades = [
        'F-1',
        'F-2',
        'F-2-A',
        'F-2-B',
        'F-3',
        'F-3-A',
        'F-3-B',
        'F-4',
        'F-4-A',
        'F-4-B',
        'F-5',
        'F-5-A',
        'F-5-B',
        'F-6',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->paygrades as $paygrade) {
            $rec = Grade::where('grade', $paygrade)->first();
            unset($rec['_id']);
            unset($rec['created_at']);
            unset($rec['updated_at']);
            $json = json_encode($rec, JSON_PRETTY_PRINT);

            $this->writeAuditTrail(
                'system user',
                'create',
                'config',
                null,
                json_encode(['name' => 'paygrade.' . $paygrade ]),
                'migrate_paygrade'
            );

            MedusaConfig::set('paygrade.' . $paygrade, $json);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->paygrades as $paygrade) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'config',
                null,
                json_encode(['name' => 'paygrade.' . $paygrade ]),
                'remove_migrated_paygrade'
            );

            MedusaConfig::remove('paygrade.' . $paygrade);
        }
    }
}
