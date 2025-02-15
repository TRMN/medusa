<?php

use App\Rating;
use App\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class TT005211MigrateRmatRatings extends Migration
{
    use \App\Audit\MedusaAudit;

    protected $ratings = [
        'RMAT-01',
        'RMAT-02',
        'RMAT-03',
        'RMAT-04',
        'RMAT-05',
        'RMAT-06',
        'RMAT-07',
        'RMAT-08',
        'RMAT-09',
        'RMAT-10',
        'RMAT-11',
        'RMAT-12',
        'RMAT-13',
        'RMAT-14',
        'RMAT-15',
        'RMAT-16',
        'RMAT-17',
        'RMAT-18',
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
                json_encode(['name' => 'rating-' . $rating ]),
                'migrate_rating'
            );

            MedusaConfig::set('rating-' . $rating, $json);
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
                json_encode(['name' => 'rating-' . $rating ]),
                'remove_migrated_rating'
            );

            MedusaConfig::remove('rating-' . $rating);
        }
    }
}
