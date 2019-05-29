<?php

use App\Models\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class UpdateCivilianPromotionPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pp = [
            'E-2'   => [
                    'tig'     => 2,
                    'line'    => [
                            'points' => 3,
                            'exam'   => [
                                    '0001',
                                ],
                        ],
                    'staff'   => [
                            'points' => 3,
                            'exam'   => [],
                        ],
                    'service' => [
                            'points' => 3,
                            'exam'   => [],
                        ],
                ],
            'E-3'   => [
                    'tig'     => 4,
                    'line'    => [
                            'points' => 6,
                            'exam'   => [
                                    '0001',
                                ],
                        ],
                    'staff'   => [
                            'points' => 6,
                            'exam'   => [],
                        ],
                    'service' => [
                            'points' => 6,
                            'exam'   => [],
                        ],
                ],
            'E-4'   => [
                    'tig'     => 5,
                    'line'    => [
                            'points' => 9,
                            'exam'   => [
                                    '0002',
                                ],
                        ],
                    'staff'   => [
                            'points' => 9,
                            'exam'   => [
                                    '0001',
                                ],
                        ],
                    'service' => [
                            'points' => 9,
                            'exam'   => [
                                    '0001',
                                ],
                        ],
                ],
            'E-5'   => [
                    'tig'     => 6,
                    'line'    => [
                            'points' => 18,
                            'exam'   => [
                                    '0002',
                                ],
                        ],
                    'staff'   => [
                            'points' => 14,
                            'exam'   => [
                                    '0002',
                                ],
                        ],
                    'service' => [
                            'points' => 12,
                            'exam'   => [
                                    '0001',
                                ],
                        ],
                ],
            'E-6'   => [
                    'tig'     => 7,
                    'line'    => [
                            'points' => 36,
                            'exam'   => [
                                    '0003',
                                ],
                        ],
                    'staff'   => [
                            'points' => 26,
                            'exam'   => [
                                    '0003',
                                ],
                        ],
                    'service' => [
                            'points' => 18,
                            'exam'   => [
                                    '0002',
                                ],
                        ],
                ],
            'E-7'   => [
                    'tig'     => 9,
                    'line'    => [
                            'points' => 45,
                            'exam'   => [
                                    '0003',
                                ],
                        ],
                    'staff'   => [
                            'points' => 35,
                            'exam'   => [
                                    '0003',
                                ],
                        ],
                    'service' => [
                            'points' => 21,
                            'exam'   => [
                                    '0002',
                                ],
                        ],
                ],
            'E-8'   => [
                    'tig'   => 12,
                    'line'  => [
                            'points' => 54,
                            'exam'   => [
                                    '0004',
                                ],
                        ],
                    'staff' => [
                            'points' => 42,
                            'exam'   => [
                                    '0004',
                                ],
                        ],
                ],
            'E-9'   => [
                    'tig'   => 15,
                    'line'  => [
                            'points' => 63,
                            'exam'   => [
                                    '0005',
                                ],
                        ],
                    'staff' => [
                            'points' => 52,
                            'exam'   => [
                                    '0004',
                                ],
                        ],
                ],
            'E-10'  => [
                    'tig'  => 18,
                    'line' => [
                            'points' => 72,
                            'exam'   => [
                                    '0006',
                                ],
                        ],
                ],
            'C-2'   => [
                    'RMMM'    => [
                            'tig'     => 2,
                            'line'    => [
                                    'points' => 3,
                                    'exam'   => [
                                            '0001',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 3,
                                    'exam'   => [],
                                ],
                            'service' => [
                                    'points' => 3,
                                    'exam'   => [],
                                ],
                        ],
                    'DIPLOMATIC' => [
                        'tig'     => 2,
                        'line'    => [
                                'points' => 3,
                                'exam'   => [
                                        'Core-02',
                                    ],
                            ],
                        'staff'   => [
                                'points' => 3,
                                'exam'   => [],
                            ],
                        'service' => [
                                'points' => 3,
                                'exam'   => [],
                            ],
                    ],
                    'INTEL' => [
                        'tig'     => 2,
                        'line'    => [
                                'points' => 3,
                                'exam'   => [
                                        'Core-02',
                                    ],
                            ],
                        'staff'   => [
                                'points' => 3,
                                'exam'   => [],
                            ],
                        'service' => [
                                'points' => 3,
                                'exam'   => [],
                            ],
                    ],
                ],
            'C-3'   => [
                    'RMMM'    => [
                            'tig'     => 4,
                            'line'    => [
                                    'points' => 6,
                                    'exam'   => [
                                            '0002',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 6,
                                    'exam'   => [],
                                ],
                            'service' => [
                                    'points' => 6,
                                    'exam'   => [],
                                ],
                        ],
                    'DIPLOMATIC' => [
                        'tig'     => 4,
                        'line'    => [
                                'points' => 6,
                                'exam'   => [
                                        'Core-03',
                                    ],
                            ],
                        'staff'   => [
                                'points' => 6,
                                'exam'   => [],
                            ],
                        'service' => [
                                'points' => 6,
                                'exam'   => [],
                            ],
                    ],
                    'INTEL' => [
                        'tig'     => 4,
                        'line'    => [
                                'points' => 6,
                                'exam'   => [
                                        'Core-03',
                                    ],
                            ],
                        'staff'   => [
                                'points' => 6,
                                'exam'   => [],
                            ],
                        'service' => [
                                'points' => 6,
                                'exam'   => [],
                            ],
                    ],
                ],
            'C-4'   => [
                    'RMACS'   => [
                            'tig'     => 2,
                            'line'    => [
                                    'points' => 3,
                                    'exam'   => [
                                            '0001',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 3,
                                    'exam'   => [],
                                ],
                            'service' => [
                                    'points' => 3,
                                    'exam'   => [],
                                ],
                        ],
                    'DIPLOMATIC' => [
                        'tig'     => 5,
                        'line'    => [
                                'points' => 9,
                                'exam'   => [
                                        'Core-04',
                                    ],
                            ],
                        'staff'   => [
                                'points' => 9,
                                'exam'   => [
                                        'Core-01',
                                    ],
                            ],
                        'service' => [
                                'points' => 9,
                                'exam'   => [
                                        'Core-01',
                                    ],
                            ],
                    ],
                    'INTEL' => [
                        'tig'     => 5,
                        'line'    => [
                                'points' => 9,
                                'exam'   => [
                                        'Core-04',
                                    ],
                            ],
                        'staff'   => [
                                'points' => 9,
                                'exam'   => [
                                        'Core-01',
                                    ],
                            ],
                        'service' => [
                                'points' => 9,
                                'exam'   => [
                                        'Core-01',
                                    ],
                            ],
                    ],
                ],
            'C-5'   => [
                    'INTEL'      => [
                            'tig'     => 5,
                            'line'    => [
                                    'points' => 14,
                                    'exam'   => [
                                            'KC-0005',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 12,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                            'service' => [
                                    'points' => 11,
                                    'exam'   => [
                                            'Core-01',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'     => 5,
                            'line'    => [
                                    'points' => 14,
                                    'exam'   => [
                                            'QC-0005',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 12,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                            'service' => [
                                    'points' => 11,
                                    'exam'   => [
                                            'core-01',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'     => 4,
                            'line'    => [
                                    'points' => 6,
                                    'exam'   => [
                                            '0002',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 6,
                                    'exam'   => [],
                                ],
                            'service' => [
                                    'points' => 6,
                                    'exam'   => [],
                                ],
                        ],
                ],
            'C-6'   => [
                    'INTEL'      => [
                            'tig'     => 5,
                            'line'    => [
                                    'points' => 19,
                                    'exam'   => [
                                            'KC-0005',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 15,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                            'service' => [
                                    'points' => 13,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'     => 5,
                            'line'    => [
                                    'points' => 19,
                                    'exam'   => [
                                            'QC-0005',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 15,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                            'service' => [
                                    'points' => 13,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'     => 5,
                            'line'    => [
                                    'points' => 9,
                                    'exam'   => [
                                            '0003',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 9,
                                    'exam'   => [
                                            '0001',
                                        ],
                                ],
                            'service' => [
                                    'points' => 9,
                                    'exam'   => [],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'     => 5,
                            'line'    => [
                                    'points' => 9,
                                    'exam'   => [
                                            '0002',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 9,
                                    'exam'   => [
                                            '0002',
                                        ],
                                ],
                            'service' => [
                                    'points' => 9,
                                    'exam'   => [],
                                ],
                        ],
                ],
            'C-7'   => [
                    'INTEL'      => [
                            'tig'     => 7,
                            'line'    => [
                                    'points' => 24,
                                    'exam'   => [
                                            'KC-0006',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 18,
                                    'exam'   => [
                                            'Core-03',
                                        ],
                                ],
                            'service' => [
                                    'points' => 15,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'     => 7,
                            'line'    => [
                                    'points' => 24,
                                    'exam'   => [
                                            'QC-0006',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 18,
                                    'exam'   => [
                                            'Core-03',
                                        ],
                                ],
                            'service' => [
                                    'points' => 15,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'line'    => [
                                    'points' => 9,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 6,
                                    'exam'   => [],
                                ],
                            'service' => [
                                    'points' => 6,
                                    'exam'   => [],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'     => 5,
                            'line'    => [
                                    'points' => 14,
                                    'exam'   => [
                                            '0004',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 12,
                                    'exam'   => [
                                            '0002',
                                        ],
                                ],
                            'service' => [
                                    'points' => 11,
                                    'exam'   => [
                                            '0001',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'     => 7,
                            'line'    => [
                                    'points' => 24,
                                    'exam'   => [
                                            '0004',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 18,
                                    'exam'   => [
                                            '0002',
                                        ],
                                ],
                            'service' => [
                                    'points' => 15,
                                    'exam'   => [
                                            '0001',
                                        ],
                                ],
                        ],
                ],
            'C-8'   => [
                    'INTEL'      => [
                            'tig'     => 7,
                            'line'    => [
                                    'points' => 29,
                                    'exam'   => [
                                            'KC-0011',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 21,
                                    'exam'   => [
                                            'Core-04',
                                        ],
                                ],
                            'service' => [
                                    'points' => 18,
                                    'exam'   => [
                                            'Core-03',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'     => 7,
                            'line'    => [
                                    'points' => 29,
                                    'exam'   => [
                                            'QC-0011',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 21,
                                    'exam'   => [
                                            'Core-04',
                                        ],
                                ],
                            'service' => [
                                    'points' => 18,
                                    'exam'   => [
                                            'Core-03',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'     => 7,
                            'line'    => [
                                    'points' => 29,
                                    'exam'   => [
                                            '0005',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 21,
                                    'exam'   => [
                                            '0003',
                                        ],
                                ],
                            'service' => [
                                    'points' => 18,
                                    'exam'   => [
                                            '0002',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'     => 7,
                            'line'    => [
                                    'points' => 29,
                                    'exam'   => [
                                            '0005',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 21,
                                    'exam'   => [
                                            '0003',
                                        ],
                                ],
                            'service' => [
                                    'points' => 18,
                                    'exam'   => [
                                            '0001',
                                        ],
                                ],
                        ],
                ],
            'C-9'   => [
                    'INTEL'      => [
                            'tig'     => 9,
                            'line'    => [
                                    'points' => 34,
                                    'exam'   => [
                                            'KC-0011',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 24,
                                    'exam'   => [
                                            'Core-04',
                                        ],
                                ],
                            'service' => [
                                    'points' => 21,
                                    'exam'   => [
                                            'Core-04',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'     => 9,
                            'line'    => [
                                    'points' => 34,
                                    'exam'   => [
                                            'QC-0011',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 24,
                                    'exam'   => [
                                            'Core-04',
                                        ],
                                ],
                            'service' => [
                                    'points' => 21,
                                    'exam'   => [
                                            'Core-04',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'     => 6,
                            'line'    => [
                                    'points' => 18,
                                    'exam'   => [
                                            'Core-03',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 14,
                                    'exam'   => [
                                            'Core-01',
                                        ],
                                ],
                            'service' => [
                                    'points' => 9,
                                    'exam'   => [],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'     => 9,
                            'line'    => [
                                    'points' => 34,
                                    'exam'   => [
                                            '0006',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 24,
                                    'exam'   => [
                                            '0004',
                                        ],
                                ],
                            'service' => [
                                    'points' => 21,
                                    'exam'   => [
                                            '0002',
                                        ],
                                ],
                        ],
                ],
            'C-10'  => [
                    'INTEL'      => [
                            'tig'     => 9,
                            'line'    => [
                                    'points' => 39,
                                    'exam'   => [
                                            'KC-0012',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 27,
                                    'exam'   => [
                                            'Core-05',
                                        ],
                                ],
                            'service' => [
                                    'points' => 26,
                                    'exam'   => [
                                            'Core-04',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'     => 9,
                            'line'    => [
                                    'points' => 39,
                                    'exam'   => [
                                            'QC-0012',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 27,
                                    'exam'   => [
                                            'Core-05',
                                        ],
                                ],
                            'service' => [
                                    'points' => 26,
                                    'exam'   => [
                                            'Core-04',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'     => 6,
                            'line'    => [
                                    'points' => 36,
                                    'exam'   => [
                                            'Core-04',
                                        ],
                                ],
                            'staff'   => [
                                    'points' => 26,
                                    'exam'   => [
                                            'Core-02',
                                        ],
                                ],
                            'service' => [
                                    'points' => 12,
                                    'exam'   => [
                                            'Core-01',
                                        ],
                                ],
                        ],
                ],
            'WO-1'  => [
                    'tig'     => 4,
                    'as'      => [
                            'E-4',
                            'E-5',
                            'E-6',
                            'E-7',
                            'E-8',
                            'E-9',
                            'E-10',
                        ],
                    'line'    => [
                            'points' => 18,
                            'exam'   => [
                                    '0011',
                                ],
                        ],
                    'staff'   => [
                            'points' => 18,
                            'exam'   => [
                                    '0011',
                                ],
                        ],
                    'service' => [
                            'points' => 18,
                            'exam'   => [],
                        ],
                ],
            'WO-2'  => [
                    'tig'     => 6,
                    'line'    => [
                            'points' => 36,
                            'exam'   => [
                                    '0011',
                                ],
                        ],
                    'staff'   => [
                            'points' => 26,
                            'exam'   => [
                                    '0011',
                                ],
                        ],
                    'service' => [
                            'points' => 24,
                            'exam'   => [
                                    '0011',
                                ],
                        ],
                ],
            'WO-3'  => [
                    'tig'   => 9,
                    'line'  => [
                            'points' => 45,
                            'exam'   => [
                                    '0012',
                                ],
                        ],
                    'staff' => [
                            'points' => 35,
                            'exam'   => [
                                    '0012',
                                ],
                        ],
                ],
            'C-11'  => [
                    'INTEL'      => [
                            'tig'   => 9,
                            'line'  => [
                                    'points' => 45,
                                    'exam'   => [
                                            'KC-0013',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 35,
                                    'exam'   => [
                                            'KC-0006',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'   => 9,
                            'line'  => [
                                    'points' => 45,
                                    'exam'   => [
                                            'QC-0013',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 35,
                                    'exam'   => [
                                            'QC-0006',
                                        ],
                                ],
                        ],
                ],
            'WO-4'  => [
                    'tig'  => 12,
                    'line' => [
                            'points' => 60,
                            'exam'   => [
                                    '0012',
                                ],
                        ],
                ],
            'WO-5'  => [
                    'tig'  => 15,
                    'line' => [
                            'points' => 72,
                            'exam'   => [
                                    '0013',
                                ],
                        ],
                ],
            'O-1'   => [
                    'tig'     => 4,
                    'as'      => [
                            'E-4',
                            'E-5',
                            'E-6',
                            'E-7',
                            'E-8',
                            'E-9',
                            'E-10',
                        ],
                    'line'    => [
                            'points' => 18,
                            'exam'   => [
                                    '0101',
                                ],
                        ],
                    'staff'   => [
                            'points' => 18,
                            'exam'   => [
                                    '0101',
                                ],
                        ],
                    'service' => [
                            'points' => 18,
                            'exam'   => [
                                    '0101',
                                ],
                        ],
                ],
            'C-12'  => [
                    'INTEL'      => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 51,
                                    'exam'   => [
                                            'KC-0101',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 40,
                                    'exam'   => [
                                            'KC-0011',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 51,
                                    'exam'   => [
                                            'QC-0101',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 40,
                                    'exam'   => [
                                            'QC-0011',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'   => 9,
                            'line'  => [
                                    'points' => 51,
                                    'exam'   => [
                                            '0101',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 40,
                                    'exam'   => [
                                            '0004',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 51,
                                    'exam'   => [
                                            '0101',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 40,
                                    'exam'   => [
                                            '0011',
                                        ],
                                ],
                        ],
                ],
            'O-2'   => [
                    'tig'     => 6,
                    'line'    => [
                            'points' => 24,
                            'exam'   => [
                                    '0102',
                                ],
                        ],
                    'staff'   => [
                            'points' => 24,
                            'exam'   => [
                                    '0102',
                                ],
                        ],
                    'service' => [
                            'points' => 24,
                            'exam'   => [
                                    '0101',
                                ],
                        ],
                ],
            'O-3'   => [
                    'tig'     => 9,
                    'line'    => [
                            'points' => 32,
                            'exam'   => [
                                    '0103',
                                ],
                        ],
                    'staff'   => [
                            'points' => 30,
                            'exam'   => [
                                    '0102',
                                ],
                        ],
                    'service' => [
                            'points' => 27,
                            'exam'   => [
                                    '0101',
                                ],
                        ],
                ],
            'O-4'   => [
                    'tig'     => 12,
                    'line'    => [
                            'points' => 40,
                            'exam'   => [
                                    '0104',
                                    '0113',
                                ],
                        ],
                    'staff'   => [
                            'points' => 36,
                            'exam'   => [
                                    '0102',
                                ],
                        ],
                    'service' => [
                            'points' => 32,
                            'exam'   => [
                                    '0101',
                                ],
                        ],
                ],
            'O-5'   => [
                    'tig'   => 15,
                    'line'  => [
                            'points' => 48,
                            'exam'   => [
                                    '0105',
                                ],
                        ],
                    'staff' => [
                            'points' => 44,
                            'exam'   => [
                                    '0103',
                                ],
                        ],
                ],
            'O-6'   => [
                    'tig'   => 18,
                    'line'  => [
                            'points' => 56,
                            'exam'   => [
                                    '0106',
                                    '0113',
                                ],
                        ],
                    'staff' => [
                            'points' => 52,
                            'exam'   => [
                                    '0103',
                                ],
                        ],
                ],
            'C-13'  => [
                    'INTEL'      => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 57,
                                    'exam'   => [
                                            'KC-0102',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 45,
                                    'exam'   => [
                                            'KC-0012',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 57,
                                    'exam'   => [
                                            'QC-0102',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 45,
                                    'exam'   => [
                                            'QC-0012',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'   => 9,
                            'line'  => [
                                    'points' => 45,
                                    'exam'   => [
                                            'QC-0101',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 35,
                                    'exam'   => [
                                            'QC-0011',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 57,
                                    'exam'   => [
                                            '0102',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 45,
                                    'exam'   => [
                                            '0005',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 57,
                                    'exam'   => [
                                            '0102',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 45,
                                    'exam'   => [
                                            '0012',
                                        ],
                                ],
                        ],
                ],
            'C-14'  => [
                    'INTEL'      => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 63,
                                    'exam'   => [
                                            'KC-0103',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 50,
                                    'exam'   => [
                                            'KC-0013',
                                        ],
                                ],
                        ],
                    'DIPLOMATIC' => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 63,
                                    'exam'   => [
                                            'QC-0103',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 50,
                                    'exam'   => [
                                            'QC-0013',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 63,
                                    'exam'   => [
                                            'QC-0102',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 50,
                                    'exam'   => [
                                            'QC-0013',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'   => 12,
                            'line'  => [
                                    'points' => 63,
                                    'exam'   => [
                                            '0103',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 50,
                                    'exam'   => [
                                            '0012',
                                        ],
                                ],
                        ],
                ],
            'C-15'  => [
                    'DIPLOMATIC' => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 69,
                                    'exam'   => [
                                            'QC-0113',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 55,
                                    'exam'   => [
                                            'QC-0101',
                                        ],
                                ],
                        ],
                    'INTEL'      => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 69,
                                    'exam'   => [
                                            'KC-0113',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 55,
                                    'exam'   => [
                                            'KC-0101',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 69,
                                    'exam'   => [
                                            'QC-0103',
                                            'QC-0113',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 55,
                                    'exam'   => [
                                            'QC-0101',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 69,
                                    'exam'   => [
                                            '0103',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 55,
                                    'exam'   => [
                                            '0101',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 69,
                                    'exam'   => [
                                            '0104',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 55,
                                    'exam'   => [
                                            '0012',
                                        ],
                                ],
                        ],
                ],
            'C-16'  => [
                    'DIPLOMATIC' => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 75,
                                    'exam'   => [
                                            'QC-0104',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 60,
                                    'exam'   => [
                                            'QC-0102',
                                        ],
                                ],
                        ],
                    'INTEL'      => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 75,
                                    'exam'   => [
                                            'KC-0104',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 60,
                                    'exam'   => [
                                            'KC-0102',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 75,
                                    'exam'   => [
                                            'QC-0104',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 60,
                                    'exam'   => [
                                            'QC-0102',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 75,
                                    'exam'   => [
                                            '0104',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 60,
                                    'exam'   => [
                                            '0102',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 75,
                                    'exam'   => [
                                            '0105',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 60,
                                    'exam'   => [
                                            '0101',
                                        ],
                                ],
                        ],
                ],
            'C-17'  => [
                    'DIPLOMATIC' => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 81,
                                    'exam'   => [
                                            'QC-0105',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 70,
                                    'exam'   => [
                                            'QC-0103',
                                        ],
                                ],
                        ],
                    'INTEL'      => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 81,
                                    'exam'   => [
                                            'KC-0105',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 70,
                                    'exam'   => [
                                            'KC-0103',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 81,
                                    'exam'   => [
                                            'QC-0105',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 70,
                                    'exam'   => [
                                            'QC-0103',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 81,
                                    'exam'   => [
                                            '0105',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 70,
                                    'exam'   => [
                                            '0103',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'   => 15,
                            'line'  => [
                                    'points' => 81,
                                    'exam'   => [
                                            '0106',
                                        ],
                                ],
                            'staff' => [
                                    'points' => 70,
                                    'exam'   => [
                                            '0101',
                                        ],
                                ],
                        ],
                ],
            'O-6-A' => [
                    'tig'   => 18,
                    'line'  => [
                            'points' => 56,
                            'exam'   => [
                                    '0106',
                                    '0113',
                                ],
                        ],
                    'staff' => [
                            'points' => 52,
                            'exam'   => [
                                    '0103',
                                ],
                        ],
                ],
            'O-6-B' => [
                    'line'  => [
                            'points' => 63,
                            'exam'   => [
                                    '1001',
                                ],
                        ],
                    'staff' => [
                            'points' => 63,
                            'exam'   => [
                                    '0104',
                                    '0113',
                                ],
                        ],
                ],
            'F-1'   => [
                    'line'  => [
                            'points' => 73,
                            'exam'   => [
                                    '1001',
                                ],
                        ],
                    'staff' => [
                            'points' => 73,
                            'exam'   => [
                                    '0105',
                                ],
                        ],
                ],
            'C-18'  => [
                    'DIPLOMATIC' => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 90,
                                    'exam'   => [
                                            'QC-0115',
                                        ],
                                ],
                        ],
                    'INTEL'      => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 90,
                                    'exam'   => [
                                            'KC-0115',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 90,
                                    'exam'   => [
                                            'QC-0115',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 90,
                                    'exam'   => [
                                            '0106',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 90,
                                    'exam'   => [
                                            '1001',
                                        ],
                                ],
                        ],
                ],
            'F-2'   => [
                    'line'  => [
                            'points' => 83,
                            'exam'   => [
                                    '1002',
                                ],
                        ],
                    'staff' => [
                            'points' => 83,
                            'exam'   => [
                                    '0106',
                                    '0115',
                                ],
                        ],
                ],
            'C-19'  => [
                    'DIPLOMATIC' => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 100,
                                    'exam'   => [
                                            'QC-1001',
                                        ],
                                ],
                        ],
                    'INTEL'      => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 100,
                                    'exam'   => [
                                            'KC-1001',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 100,
                                    'exam'   => [
                                            'QC-1001',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 100,
                                    'exam'   => [
                                            '1001',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 100,
                                    'exam'   => [
                                            '1002',
                                        ],
                                ],
                        ],
                ],
            'F-2-A' => [
                    'line'  => [
                            'points' => 83,
                            'exam'   => [
                                    '1002',
                                ],
                        ],
                    'staff' => [
                            'points' => 83,
                            'exam'   => [
                                    '0106',
                                    '0115',
                                ],
                        ],
                ],
            'F-2-B' => [
                    'line'  => [
                            'points' => 93,
                            'exam'   => [
                                    '1002',
                                ],
                        ],
                    'staff' => [
                            'points' => 93,
                            'exam'   => [
                                    '1001',
                                ],
                        ],
                ],
            'F-3'   => [
                    'line' => [
                            'points' => 103,
                            'exam'   => [
                                    '1003',
                                ],
                        ],
                ],
            'C-20'  => [
                    'DIPLOMATIC' => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 110,
                                    'exam'   => [
                                            'QC-1002',
                                        ],
                                ],
                        ],
                    'INTEL'      => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 110,
                                    'exam'   => [
                                            'KC-1002',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 110,
                                    'exam'   => [
                                            'QC-1002',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 110,
                                    'exam'   => [
                                            '1002',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'  => 15,
                            'line' => [
                                    'points' => 110,
                                    'exam'   => [
                                            '1003',
                                        ],
                                ],
                        ],
                ],
            'F-3-A' => [
                    'line' => [
                            'points' => 103,
                            'exam'   => [
                                    '1003',
                                ],
                        ],
                ],
            'F-3-B' => [
                    'line' => [
                            'points' => 113,
                            'exam'   => [
                                    '1003',
                                ],
                        ],
                ],
            'F-4'   => [
                    'line' => [
                            'points' => 113,
                            'exam'   => [
                                    '1004',
                                ],
                        ],
                ],
            'C-21'  => [
                    'DIPLOMATIC' => [
                            'tig'  => 18,
                            'line' => [
                                    'points' => 120,
                                    'exam'   => [
                                            'QC-1003',
                                        ],
                                ],
                        ],
                    'INTEL'      => [
                            'tig'  => 18,
                            'line' => [
                                    'points' => 120,
                                    'exam'   => [
                                            'KC-1003',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'tig'  => 18,
                            'line' => [
                                    'points' => 120,
                                    'exam'   => [
                                            'QC-1003',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'tig'  => 18,
                            'line' => [
                                    'points' => 120,
                                    'exam'   => [
                                            '1003',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'tig'  => 18,
                            'line' => [
                                    'points' => 120,
                                    'exam'   => [
                                            '1004',
                                        ],
                                ],
                        ],
                ],
            'F-4-A' => [
                    'line' => [
                            'points' => 113,
                            'exam'   => [
                                    '1004',
                                ],
                        ],
                ],
            'F-4-B' => [
                    'line' => [
                            'points' => 123,
                            'exam'   => [
                                    '1004',
                                ],
                        ],
                ],
            'F-5'   => [
                    'line' => [
                            'points' => 143,
                            'exam'   => [
                                    '1005',
                                ],
                        ],
                ],
            'C-22'  => [
                    'DIPLOMATIC' => [
                            'line' => [
                                    'points' => 130,
                                    'exam'   => [
                                            'QC-1004',
                                        ],
                                ],
                        ],
                    'INTEL'      => [
                            'line' => [
                                    'points' => 130,
                                    'exam'   => [
                                            'KC-1004',
                                        ],
                                ],
                        ],
                    'SFC'        => [
                            'line' => [
                                    'points' => 130,
                                    'exam'   => [
                                            'QC-1004',
                                        ],
                                ],
                        ],
                    'RMMM'       => [
                            'line' => [
                                    'points' => 130,
                                    'exam'   => [
                                            '1004',
                                        ],
                                ],
                        ],
                    'RMACS'      => [
                            'line' => [
                                    'points' => 130,
                                    'exam'   => [
                                            '1004',
                                        ],
                                ],
                        ],
                ],
            'F-5-A' => [
                    'line' => [
                            'points' => 143,
                            'exam'   => [
                                    '1005',
                                ],
                        ],
                ],
            'F-5-B' => [
                    'line' => [
                            'points' => 153,
                            'exam'   => [
                                    '1005',
                                ],
                        ],
                ],
            'F-6'   => [
                    'line' => [
                            'exam' => [
                                    '1005',
                                ],
                        ],
                ],
            'C-23'  => [
                'DIPLOMATIC' => [
                        'line' => [
                                'points' => 150,
                                'exam'   => [
                                        'QC-1005',
                                    ],
                            ],
                    ],
                'INTEL'      => [
                        'line' => [
                                'points' => 150,
                                'exam'   => [
                                        'KC-1005',
                                    ],
                            ],
                    ],
                'SFC'        => [
                        'line' => [
                                'points' => 150,
                                'exam'   => [
                                        'QC-1005',
                                    ],
                            ],
                    ],
                'RMMM'       => [
                        'line' => [
                                'points' => 150,
                                'exam'   => [
                                        '1004',
                                    ],
                            ],
                    ],
                'RMACS'      => [
                        'line' => [
                                'points' => 150,
                                'exam'   => [
                                        '1004',
                                    ],
                            ],
                    ],
            ],
        ];

        $RMACS = $RMMM = $SFC = $DIPLOMATIC = $INTEL = [];

        foreach ($pp as $payGrade => $req) {
            switch (substr($payGrade, 0, 1)) {
                case 'C':
                    foreach ($req as $branch => $breq) {
                        $$branch[$payGrade] = $breq;
                    }
                    unset($pp[$payGrade]);

                    break;
            }
        }

        // Save the old one in case we need to revert

        MedusaConfig::set('pp.requirements.bak', MedusaConfig::get('pp.requirements'));

        // Update the default to just have the military pay grades
        MedusaConfig::set('pp.requirements', $pp);

        // Setup the civilian promotion point requirement entries

        foreach (['RMACS', 'RMMM', 'SFC', 'DIPLOMATIC', 'INTEL'] as $branch) {
            MedusaConfig::set('pp.requirements.'.$branch, $$branch);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Restore the saved copy
        MedusaConfig::set('pp.requirements', MedusaConfig::get('pp.requirements.bak'));

        // Delete the backup and the new entries
        MedusaConfig::remove('pp.requirements.bak');

        foreach (['RMACS', 'RMMM', 'SFC', 'DIPLOMATIC', 'INTEL'] as $branch) {
            MedusaConfig::remove('pp.requirements.'.$branch);
        }
    }
}
