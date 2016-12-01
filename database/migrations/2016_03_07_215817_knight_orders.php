<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KnightOrders extends Migration
{

    use \Medusa\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $orders = [
            [
                'order'    => 'Most Noble Order of the Star Kingdom',
                'filename' => 'Order-of-the-Star-Kingdom.svg',
                'classes'  => [
                    [
                        'class'       => 'Knight',
                        'precedence'  => 3,
                        'postnominal' => 'KSK'
                    ]
                ]
            ],
            [
                'order'    => 'Most Honorable Order of King Roger',
                'filename' => 'Order-of-King-Roger.svg',
                'classes'  => [
                    [
                        'class'       => 'Knight Grand Cross',
                        'precedence'  => 4,
                        'postnominal' => 'GCR'
                    ],
                    [
                        'class'       => 'Knight Commander',
                        'precedence'  => 7,
                        'postnominal' => 'KDR'
                    ],
                    [
                        'class'       => 'Knight Companion',
                        'precedence'  => 9,
                        'postnominal' => 'KCR'
                    ],
                    [
                        'class'       => 'Knight',
                        'precedence'  => 13,
                        'postnominal' => 'KR'
                    ],
                    [
                        'class' => 'Companion',
                        'precedence' => 15,
                        'postnominal' => 'CR',
                    ],
                    [
                        'class' => 'Officer',
                        'precedence' => 19,
                        'postnominal' => 'OR',
                    ],
                    [
                        'class' => 'Member',
                        'precedence' => 24,
                        'postnominal' => 'MR',
                    ],
                    [
                        'class' => 'Medal',
                        'precedence' => 35,
                        'postnominal' => 'RM',
                    ],
                ]
            ],
            [
                'order'    => 'The Most Eminent Order of the Golden Lion',
                'filename' => 'Order-of-the-Golden-Lion.svg',
                'classes'  => [
                    [
                        'class'       => 'Knight Grand Cross',
                        'precedence'  => 4.5,
                        'postnominal' => 'GCGL'
                    ],
                    [
                        'class'       => 'Knight Commander',
                        'precedence'  => 7.6,
                        'postnominal' => 'KDGL'
                    ],
                    [
                        'class'       => 'Knight Companion',
                        'precedence'  => 9.5,
                        'postnominal' => 'KCGL'
                    ],
                    [
                        'class'       => 'Knight',
                        'precedence'  => 13.5,
                        'postnominal' => 'KGL'
                    ],
                    [
                        'class' => 'Companion',
                        'precedence' => 15.5,
                        'postnominal' => 'CGL',
                    ],
                    [
                        'class' => 'Officer',
                        'precedence' => 19.5,
                        'postnominal' => 'OGL',
                    ],
                    [
                        'class' => 'Member',
                        'precedence' => 24.5,
                        'postnominal' => 'MGL',
                    ],
                    [
                        'class' => 'Medal',
                        'precedence' => 35.5,
                        'postnominal' => 'GLM',
                    ],
                ]
            ],
            [
                'order'    => 'Most Regal Order of Queen Elizabeth',
                'filename' => 'Order-of-Queen-Elizabeth.svg',
                'classes'  => [
                    [
                        'class'       => 'Knight Grand Cross',
                        'precedence'  => 5,
                        'postnominal' => 'GCE'
                    ],
                    [
                        'class'       => 'Knight Commander',
                        'precedence'  => 8,
                        'postnominal' => 'KDE'
                    ],
                    [
                        'class'       => 'Knight Companion',
                        'precedence'  => 10,
                        'postnominal' => 'KCE'
                    ],
                    [
                        'class'       => 'Knight',
                        'precedence'  => 14,
                        'postnominal' => 'KE'
                    ],
                    [
                        'class' => 'Companion',
                        'precedence' => 16,
                        'postnominal' => 'CE',
                    ],
                    [
                        'class' => 'Officer',
                        'precedence' => 20,
                        'postnominal' => 'OE',
                    ],
                    [
                        'class' => 'Member',
                        'precedence' => 25,
                        'postnominal' => 'ME',
                    ],
                    [
                        'class' => 'Medal',
                        'precedence' => 36,
                        'postnominal' => 'EM',
                    ],
                ]
            ],
            [
                'order'    => 'The Most Distinguished Order of Merit',
                'filename' => 'Order-of-Merit.svg',
                'classes'  => [
                    [
                        'class'       => 'Knight',
                        'precedence'  => 6,
                        'postnominal' => 'OM'
                    ]
                ]
            ]

        ];

        DB::table('korders')->truncate();

        foreach ($orders as $item) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'permissions',
                null,
                json_encode(["order" => $item['order'], "filename" => $item['filename'], "classes" => $item['classes']]),
                'add_knight_orders'
            );

            Korders::create(["order" => $item['order'], "filename" => $item['filename'], "classes" => $item['classes']]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
