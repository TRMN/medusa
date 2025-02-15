<?php

use App\Rating;
use App\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class TT005211MigrateSrnRatings extends Migration
{
    use \App\Audit\MedusaAudit;

    protected $ratings = [
        'SRN-01',
        'SRN-02',
        'SRN-03',
        'SRN-04',
        'SRN-05',
        'SRN-06',
        'SRN-07',
        'SRN-08',
        'SRN-09',
        'SRN-10',
        'SRN-11',
        'SRN-12',
        'SRN-13',
        'SRN-14',
        'SRN-15',
        'SRN-16',
        'SRN-17',
        'SRN-18',
        'SRN-19',
        'SRN-20',
        'SRN-21',
        'SRN-22',
        'SRN-23',
        'SRN-24',
        'SRN-25',
        'SRN-26',
        'SRN-27',
        'SRN-28',
        'SRN-29',
        'SRN-30',
        'SRN-31',
        'SRN-32',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->ratings as $rating) {
            $rec = Rating::where('rate_code', $rating)->first();
            unset($rec['_id']);
            unset($rec['created_at']);
            unset($rec['updated_at']);
            $json = json_encode($rec, JSON_PRETTY_PRINT);

            $this->writeAuditTrail(
                'system user',
                'create',
                'config',
                null,
                json_encode(['name' => 'rating.' . $rating ]),
                'migrate_rating'
            );

            MedusaConfig::set('rating.' . $rating, $json);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->ratings as $rating) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'config',
                null,
                json_encode(['name' => 'rating.' . $rating ]),
                'remove_migrated_rating'
            );

            MedusaConfig::remove('rating.' . $rating);
        }
    }
}
