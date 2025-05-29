<?php

use App\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class Tt005562AlignPpCivilExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $newpp = [
            "C-2" => [
                "tig" => 2,
                "line" => [
                    "points" => 3,
                    "exam" => [
                        "(00)?01"
                    ]
                ],
                "staff" => [
                    "points" => 3,
                    "exam" => []
                ],
                "service" => [
                    "points" => 3,
                    "exam" => []
                ]
            ],
            "C-3" => [
                "tig" => 4,
                "line" => [
                    "points" => 6,
                    "exam" => [
                        "(00)?01"
                    ]
                ],
                "staff" => [
                    "points" => 6,
                    "exam" => []
                ],
                "service" => [
                    "points" => 6,
                    "exam" => []
                ]
            ],
            "C-4" => [
                "tig" => 5,
                "line" => [
                    "points" => 9,
                    "exam" => [
                        "(00)?02"
                    ]
                ],
                "staff" => [
                    "points" => 9,
                    "exam" => [
                        "(00)?01"
                    ]
                ],
                "service" => [
                    "points" => 9,
                    "exam" => [
                        "(00)?01"
                    ]
                ]
            ],
            "C-5" => [
                "tig" => 6,
                "line" => [
                    "points" => 18,
                    "exam" => [
                        "(00)?02"
                    ]
                ],
                "staff" => [
                    "points" => 14,
                    "exam" => [
                        "(00)?02"
                    ]
                ],
                "service" => [
                    "points" => 12,
                    "exam" => [
                        "(00)?01"
                    ]
                ]
            ],
            "C-6" => [
                "tig" => 7,
                "line" => [
                    "points" => 36,
                    "exam" => [
                        "(00)?03"
                    ]
                ],
                "staff" => [
                    "points" => 26,
                    "exam" => [
                        "(00)?03"
                    ]
                ],
                "service" => [
                    "points" => 18,
                    "exam" => [
                        "(00)?02"
                    ]
                ]
            ],
            "C-7" => [
                "tig" => 9,
                "line" => [
                    "points" => 45,
                    "exam" => [
                        "(00)?03"
                    ]
                ],
                "staff" => [
                    "points" => 35,
                    "exam" => [
                        "(00)?03"
                    ]
                ],
                "service" => [
                    "points" => 21,
                    "exam" => [
                        "(00)?02"
                    ]
                ]
            ],
            "C-8" => [
                "tig" => 12,
                "line" => [
                    "points" => 54,
                    "exam" => [
                        "(00)?04"
                    ]
                ],
                "staff" => [
                    "points" => 42,
                    "exam" => [
                        "(00)?04"
                    ]
                ]
            ],
            "C-9" => [
                "tig" => 15,
                "line" => [
                    "points" => 63,
                    "exam" => [
                        "0005"
                    ]
                ],
                "staff" => [
                    "points" => 52,
                    "exam" => [
                        "(00)?04"
                    ]
                ]
            ],
            "C-10" => [
                "tig" => 18,
                "line" => [
                    "points" => 72,
                    "exam" => [
                        "0006"
                    ]
                ]
            ],
            "C-11" => [
                "tig" => 4,
                "as" => [
                    "C-4",
                    "C-5",
                    "C-6",
                    "C-7",
                    "C-8",
                    "C-9",
                    "C-10"
                ],
                "line" => [
                    "points" => 18,
                    "exam" => [
                        "0101"
                    ]
                ],
                "staff" => [
                    "points" => 18,
                    "exam" => [
                        "0101"
                    ]
                ],
                "service" => [
                    "points" => 18,
                    "exam" => [
                        "0101"
                    ]
                ]
            ],
            "C-12" => [
                "tig" => 6,
                "line" => [
                    "points" => 24,
                    "exam" => [
                        "0102"
                    ]
                ],
                "staff" => [
                    "points" => 24,
                    "exam" => [
                        "0102"
                    ]
                ],
                "service" => [
                    "points" => 24,
                    "exam" => [
                        "0101"
                    ]
                ]
            ],
            "C-13" => [
                "tig" => 9,
                "line" => [
                    "points" => 32,
                    "exam" => [
                        "0103"
                    ]
                ],
                "staff" => [
                    "points" => 30,
                    "exam" => [
                        "0102"
                    ]
                ],
                "service" => [
                    "points" => 27,
                    "exam" => [
                        "0101"
                    ]
                ]
            ],
            "C-14" => [
                "tig" => 12,
                "line" => [
                    "points" => 40,
                    "exam" => [
                        "0104",
                        "0113"
                    ]
                ],
                "staff" => [
                    "points" => 36,
                    "exam" => [
                        "0102"
                    ]
                ],
                "service" => [
                    "points" => 32,
                    "exam" => [
                        "0102"
                    ]
                ]
            ],
            "C-15" => [
                "tig" => 15,
                "line" => [
                    "points" => 48,
                    "exam" => [
                        "0105"
                    ]
                ],
                "staff" => [
                    "points" => 44,
                    "exam" => [
                        "0103"
                    ]
                ]
            ],
            "C-16" => [
                "tig" => 18,
                "line" => [
                    "points" => 63,
                    "exam" => [
                        "0106",
                        "0115"
                    ]
                ],
                "staff" => [
                    "points" => 63,
                    "exam" => [
                        "0104",
                        "0113"
                    ]
                ]
            ],
            "C-17" => [
                "line" => [
                    "points" => 73,
                    "exam" => [
                        "1001"
                    ]
                ],
                "staff" => [
                    "points" => 73,
                    "exam" => [
                        "0106"
                    ]
                ]
            ],
            "C-18" => [
                "line" => [
                    "points" => 93,
                    "exam" => [
                        "1002"
                    ]
                ],
                "staff" => [
                    "points" => 93,
                    "exam" => [
                        "1001"
                    ]
                ]
            ],
            "C-19" => [
                "line" => [
                    "points" => 113,
                    "exam" => [
                        "1003"
                    ]
                ]
            ],
            "C-20" => [
                "line" => [
                    "points" => 133,
                    "exam" => [
                        "1004"
                    ]
                ]
            ],
            "C-21" => [
                "line" => [
                    "points" => 153,
                    "exam" => [
                        "1005"
                    ]
                ]
            ],
            "C-22" => [
                "line" => [
                    "exam" => [
                        "1005"
                    ]
                ]
            ]
        ];

        foreach (['COMMONS', 'LORDS', 'RMACS', 'RMMM', 'SFC', 'DIPLOMATIC', 'INTEL'] as $branch) {
            // Backup the current requirements
            $oldpp = MedusaConfig::get('pp.requirements.'.$branch);
            MedusaConfig::set('pp.requirements.'.$branch.'.bak', $oldpp);

            // Set the new requirements
            MedusaConfig::set('pp.requirememts.'.$branch, $newpp);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (['COMMONS', 'LORDS', 'RMACS', 'RMMM', 'SFC', 'DIPLOMATIC', 'INTEL'] as $branch) {
            // Restore the old requirements.
            $pp = MedusaConfig::get('pp.requirements.'.$branch.'.bak');
            MedusaConfig::set('pp.requirements.'.$branch, $pp);

	        // Cleanup the backup.
            MedusaConfig::remove('pp.requirements.'.$branch.'.bak');
        }
    }
}
