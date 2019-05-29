<?php

use Illuminate\Database\Migrations\Migration;

class PromotionPointsConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = [
            'service' => [
                [
                    'title'  => 'Every 3 months in a Chapter Command Triad',
                    'target' => 'triad',
                    'points' => 1,
                    'class'  => 'pp-calc-3',
                ],
                [
                    'title'  => "Every 3 months in a Fleet Staff role/br/(includes Fleet CO's and their staff)",
                    'target' => 'fleet',
                    'points' => 1,
                    'class'  => 'pp-calc-3',
                ],
                [
                    'title'  => 'Every 3 months in an Admiralty House postion/br/(includes Royal Council, Space Lords and their staff)',
                    'target' => 'ah',
                    'points' => 1,
                    'class'  => 'pp-calc-3',
                ],
            ],
            'events' => [
                [
                    'title'  => 'Chapter Meeting',
                    'target' => 'cpm',
                    'points' => 1,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Chapter Event (other than a meeting)',
                    'target' => 'cpe',
                    'points' => 1,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Charity Event (per 24 hour day)',
                    'target' => 'che',
                    'points' => 2,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Hosting a chapter meeting or event (per event)',
                    'target' => 'cph',
                    'points' => 2,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Hosting a charity event (per event)',
                    'target' => 'chh',
                    'points' => 4,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Hosting a virutal charity event (per event)',
                    'target' => 'vch',
                    'points' => 3,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Attend non-Fleet or Admiralty House con (per day)',
                    'target' => 'con',
                    'points' => 1,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Attend Fleet or Admiralty House con (per day)',
                    'target' => 'ahcon',
                    'points' => 2,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Volunteer at a non-Fleet or Admiralty House con/br/(4 hours or more, in addition to attendance points)',
                    'target' => 'vcon',
                    'points' => 1,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Volunteer at a Fleet or Admiralty House con/br/(4 hours or more, in addition to attendance points)',
                    'target' => 'vahcon',
                    'points' => 2,
                    'class'  => 'pp-calc',
                ],
            ],
            'parliament' => [
                [
                    'title'  => 'Serve as a Member of Parliament (per year)',
                    'target' => 'mp',
                    'points' => 2,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Serve as Speaker of the House (per year, in addition to service as Member)',
                    'target' => 'sh',
                    'points' => 1,
                    'class'  => 'pp-calc',
                ],
                [
                    'title'  => 'Serve as Lord Speaker (per year, in addition to service as Member)',
                    'target' => 'ls',
                    'points' => 1,
                    'class'  => 'pp-calc',
                ],
            ],
        ];

        \App\Models\MedusaConfig::set('pp.form-config', $config);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\MedusaConfig::remove('pp.form-config');
    }
}
