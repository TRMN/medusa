<?php

/**
 * Created by PhpStorm.
 * User: dweiner
 * Date: 10/13/14
 * Time: 7:19 AM.
 */
class TigSeeder extends Seeder
{
    use \Medusa\Audit\MedusaAudit;

    public function run()
    {
        DB::collection('tig')->delete();

        $tigs = [
            'E-2' => ['tig_as' => 'E-1', 'tig' => '3'],
            'E-3' => ['tig_as' => 'E-2', 'tig' => '5'],
            'E-4' => ['tig_as' => 'E-3', 'tig' => '7'],
            'E-5' => ['tig_as' => 'E-4', 'tig' => '9'],
            'E-6' => ['tig_as' => 'E-5', 'tig' => '11'],
            'E-7' => ['tig_as' => 'E-6', 'tig' => '13'],
            'E-8' => ['tig_as' => 'E-7', 'tig' => '15'],
            'E-9' => ['tig_as' => 'E-8', 'tig' => '19'],
            'E-10' => ['tig_as' => 'E-9', 'tig' => '24'],
            'WO-1' => ['tig_as' => 'E-6', 'tig' => '6'],
            'WO-2' => ['tig_as' => 'WO-1', 'tig' => '9'],
            'WO-3' => ['tig_as' => 'WO-2', 'tig' => '11'],
            'WO-4' => ['tig_as' => 'WO-3', 'tig' => '13'],
            'WO-5' => ['tig_as' => 'WO-4', 'tig' => '15'],
            'O-1' => ['tig_as' => 'E-1', 'tig' => '6'],
            'O-2' => ['tig_as' => 'O-1', 'tig' => '6'],
            'O-3' => ['tig_as' => 'O-2', 'tig' => '9'],
            'O-4' => ['tig_as' => 'O-3', 'tig' => '12'],
            'O-5' => ['tig_as' => 'O-4', 'tig' => '15'],
            'O-6-A' => ['tig_as' => 'O-5', 'tig' => '18'],
            'O-6-B' => ['tig_as' => 'O-6-A', 'tig' => '18'],
            'F-1' => ['tig_as' => 'O-6-B', 'tig' => '18'],
            'F-2' => ['tig_as' => 'F-1', 'tig' => '24'],
            'F-3' => ['tig_as' => 'F-2', 'tig' => '36'],
            'F-4' => ['tig_as' => 'F-3', 'tig' => '48'],
            'C-2' => ['tig_as' => 'C-1', 'tig' => '3'],
            'C-3' => ['tig_as' => 'C-2', 'tig' => '5'],
            'C-4' => ['tig_as' => 'C-3', 'tig' => '15'],
            'C-5' => ['tig_as' => 'C-4', 'tig' => '24'],
            'C-6' => ['tig_as' => 'C-5', 'tig' => '24'],
            'C-7' => ['tig_as' => 'C-6', 'tig' => '24'],
            'C-8' => ['tig_as' => 'C-5', 'tig' => '6'],
            'C-9' => ['tig_as' => 'C-5', 'tig' => '9'],
            'C-10' => ['tig_as' => 'C-9', 'tig' => '12'],
            'C-11' => ['tig_as' => 'C-10', 'tig' => '12'],
            'C-12' => ['tig_as' => 'C-11', 'tig' => '18'],
            'C-13' => ['tig_as' => 'C-12', 'tig' => '18'],
            'C-14' => ['tig_as' => 'C-13', 'tig' => '20'],
            'C-15' => ['tig_as' => 'C-14', 'tig' => '20'],
            'C-16' => ['tig_as' => 'C-15', 'tig' => '20'],
            'C-17' => ['tig_as' => 'C-16', 'tig' => '24'],
        ];

        foreach ($tigs as $grade => $tig) {
            $this->writeAuditTrail(
                'db:seed',
                'create',
                'tig',
                null,
                json_encode(['grade' => $grade, 'tig' => $tig]),
                'tig'
            );

            Tig::create(['grade' => $grade, 'tig' => $tig]);
        }
    }
}
