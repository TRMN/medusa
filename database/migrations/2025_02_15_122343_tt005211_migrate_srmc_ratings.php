<?php

use App\Rating;
use App\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class TT005211MigrateSrmcRatings extends Migration
{
    use \App\Audit\MedusaAudit;

    protected $ratings = [
        'SRMC-01',
        'SRMC-02',
        'SRMC-03',
        'SRMC-04',
        'SRMC-05',
        'SRMC-06',
        'SRMC-07',
        'SRMC-08',
        'SRMC-09',
        'SRMC-10',
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