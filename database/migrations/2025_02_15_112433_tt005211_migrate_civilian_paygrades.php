<?php

use App\Grade;
use App\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class TT005211MigrateCivilianPaygrades extends Migration
{
    protected $paygrades = [
        'C-1',
        'C-2',
        'C-3',
        'C-4',
        'C-5',
        'C-6',
        'C-7',
        'C-8',
        'C-9',
        'C-10',
        'C-11',
        'C-12',
        'C-13',
        'C-14',
        'C-15',
        'C-16',
        'C-17',
        'C-18',
        'C-19',
        'C-20',
        'C-21',
        'C-22',
        'C-22-B'
        'C-23',
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
                json_encode(['name' => 'paygrade-' . $paygrade ]),
                'migrate_paygrade'
            );

            MedusaConfig::set('paygrade-' . $paygrade, $json);
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
                json_encode(['name' => 'paygrade-' . $paygrade ]),
                'remove_migrated_paygrade'
            );

            MedusaConfig::remove('paygrade-' . $paygrade);
        }
    }
}
