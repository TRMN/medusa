<?php

use App\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class AddPeerageShowConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $showConfig = MedusaConfig::get('chapter.show');

        $showConfig['keep'] = [
            'Knight' => [
                'billet' => 'Knight',
                'display_order' => 1,
            ],
            'Dame' => [
                'billet' => 'Dame',
                'display_order' => 1,
            ],
            'Majordomo' => [
                'billet' => 'Majordomo',
                'display_order' => 2,
            ],

        ];

        $showConfig['barony'] = [
            'Baron|Baroness' => [
                'display_order' => 1,
                'allow_courtesy' => false,
            ],
            'Baroness|Baron' => [
                'display_order' => 2,
            ],
            'Majordomo' => [
                'billet' => 'Majordomo',
                'display_order' => 3,
            ],

        ];

        $showConfig['county'] = [
            'Earl|Countess' => [
                'allow_courtesy' => false,
                'display_order' => 1,
            ],
            'Countess|Earl' => [
                'display_order' => 2,
            ],
            'Majordomo' => [
                'billet' => 'Majordomo',
                'display_order' => 3,
            ],

        ];

        $showConfig['duchy'] = [
            'Duke|Duchess' => [
                'allow_courtesy' => false,
                'display_order' => 1,
            ],
            'Duchess|Duke' => [
                'display_order' => 2,
            ],
            'Majordomo' => [
                'billet' => 'Majordomo',
                'display_order' => 3,
            ],

        ];

        $showConfig['steading'] = [
            'Steadholder' => [
                'billet' => 'Steadholder',
                'display_order' => 1,
            ],
            'Lord|Lady' => [
                'display_order' => 2,
            ],
            'Majordomo' => [
                'billet' => 'Majordomo',
                'display_order' => 3,
            ],

        ];

        $showConfig['grand_duchy'] = [
            'Grand Duke|Grand Duchess' => [
                'allow_courtesy' => false,
                'display_order' => 1,
            ],
            'Grand Duchess|Grand Duke' => [
                'display_order' => 2,
            ],
            'Majordomo' => [
                'billet' => 'Majordomo',
                'display_order' => 3,
            ],

        ];

        MedusaConfig::set('chapter.show', $showConfig);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $showConfig = MedusaConfig::get('chapter.show');

        unset($showConfig['keep'], $showConfig['barony'], $showConfig['county'], $showConfig['duchy'], $showConfig['steading'], $showConfig['grand_duchy']);

        MedusaConfig::set('chapter.show', $showConfig);
    }
}
