<?php

use Illuminate\Database\Migrations\Migration;

class SWPQuals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // SWP Qualifications
        $swpQual = [
            'RMN' => [
                'Enlisted' => [
                    'NumDepts' => 3,
                    'Required' => [
                        'SIA-SRN-01A',
                        'SIA-SRN-04A',
                    ],
                    'Departments' => [
                        'FlightOps' => [
                            'SIA-SRN-05C',
                        ],
                        'Astrogation' => [
                            'SIA-SRN-06C',
                            'SIA-SRN-07C',
                        ],
                        'Communications' => [
                            'SIA-SRN-11C',
                            'SIA-SRN-12C',
                            'SIA-SRN-13C',
                        ],
                        'Engineering' => [
                            'SIA-SRN-14C',
                            'SIA-SRN-15C',
                            'SIA-SRN-16C',
                            'SIA-SRN-17C',
                            'SIA-SRN-18C',
                            'SIA-SRN-19C',
                        ],
                        'Tactical' => [
                            'SIA-SRN-08C',
                            'SIA-SRN-09C',
                            'SIA-SRN-10C',
                            'SIA-SRN-27C',
                            'SIA-SRN-28C',
                            'SIA-SRN-29C',
                            'SIA-SRN-32C',
                        ],
                    ],
                ],
                'Officer' => [
                    'NumDepts' => 4,
                    'Required' => [
                        'SIA-SRN-01C',
                        'SIA-SRN-31C',
                    ],
                    'Departments' => [
                        'FlightOps' => [
                            'SIA-SRN-05D',
                        ],
                        'Astrogation' => [
                            'SIA-SRN-06D',
                            'SIA-SRN-07D',
                        ],
                        'Communications' => [
                            'SIA-SRN-11D',
                            'SIA-SRN-12D',
                            'SIA-SRN-13D',
                        ],
                        'Engineering' => [
                            'SIA-SRN-14D',
                            'SIA-SRN-15D',
                            'SIA-SRN-16D',
                            'SIA-SRN-17D',
                            'SIA-SRN-18D',
                            'SIA-SRN-19D',
                        ],
                        'Tactical' => [
                            'SIA-SRN-08D',
                            'SIA-SRN-09D',
                            'SIA-SRN-10D',
                            'SIA-SRN-27D',
                            'SIA-SRN-28D',
                            'SIA-SRN-29D',
                            'SIA-SRN-32D',
                        ],
                    ],
                ],
            ],
            'RMMC' => [
                'Enlisted' => [
                    'NumDepts' => 3,
                    'Required' => [
                        'SIA-SRMC-07A',
                        'SIA-SRMC-19A',
                    ],
                    'Departments' => [
                        'Armorer' => [
                            'SIA-SRMC-01C',
                        ],
                        'AssaultMarine' => [
                            'SIA-SRMC-05C',
                        ],
                        'HeavyWeapons' => [
                            'SIA-SRMC-08C',
                        ],
                        'LaserGraser' => [
                            'SIA-SRMC-04C',
                        ],
                        'MP' => [
                            'SIA-SRMC-02C',
                        ],
                        'Missile' => [
                            'SIA-SRMC-03C',
                        ],
                        'Recon' => [
                            'SIA-SRMC-06C',
                        ],
                    ],
                ],
                'Officer' => [
                    'NumDepts' => 3,
                    'Required' => [
                        'SIA-SRMC-07D',
                        'SIA-SRMC-19C',
                        'SIA-SRMC-09C',
                        'SIA-SRMC-02C',
                    ],
                    'Departments' => [
                        'Armorer' => [
                            'SIA-SRMC-01D',
                        ],
                        'AssaultMarine' => [
                            'SIA-SRMC-05D',
                        ],
                        'HeavyWeapons' => [
                            'SIA-SRMC-08D',
                        ],
                        'LaserGraser' => [
                            'SIA-SRMC-04D',
                        ],
                        'MP' => [
                            'SIA-SRMC-02D',
                        ],
                        'Missile' => [
                            'SIA-SRMC-03D',
                        ],
                        'Recon' => [
                            'SIA-SRMC-06D',
                        ],
                    ],
                ],
            ],
        ];

        // Add the quals
        \App\MedusaConfig::set('awards.swp', $swpQual);

        // Add the branches that can get SWP's
        \App\MedusaConfig::set('awards.swp.branches', ['RMN', 'RMMC']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\MedusaConfig::remove('awards.swp');
        \App\MedusaConfig::remove('awards.swp.branches');
    }
}
