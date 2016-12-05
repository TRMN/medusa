<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRmmcChapters extends Migration
{

    use \Medusa\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Create the HQ units

        $commandant = $this->createChapter('Office of the Commandant (RMMC)', 'headquarters', '', 'RMMC', null, false);
        $comForceCom = $this->createChapter('Marine Forces Command', 'headquarters', '', 'RMMC', $commandant->id, false);

        // Create the RMMC Corps

        $firstCorps = $this->createChapter('1st Corps', 'corps', '', 'RMMC', $comForceCom->id, false);
        $secondCorps = $this->createChapter('2nd Corps', 'corps', '', 'RMMC', $comForceCom->id, false);
        $thirdCorps = $this->createChapter('3rd Corps', 'corps', '', 'RMMC', $comForceCom->id, false);
        $fourthCorps = $this->createChapter('4th Corps', 'corps', '', 'RMMC', $comForceCom->id, false);

        // Create the RMMC Expeditionary Froces

        $firstEF = $this->createChapter('1st Expeditionary Force', 'exp_force', '1', 'RMMC', $firstCorps->id, false);
        $secondEF = $this->createChapter('2nd Expeditionary Force', 'exp_force', '2', 'RMMC', $firstCorps->id, false);
        $thirdEF = $this->createChapter('3rd Expeditionary Force', 'exp_force', '3', 'RMMC', $firstCorps->id, false);
        $fourthEF = $this->createChapter('4th Expeditionary Force', 'exp_force', '4', 'RMMC', $firstCorps->id, false);
        $fifthEF = $this->createChapter('5th Expeditionary Force', 'exp_force', '5', 'RMMC', $thirdCorps->id, false);
        $sixthEF = $this->createChapter('6th Expeditionary Force', 'exp_force', '6', 'RMMC', $firstCorps->id, false);
        $seventhEF = $this->createChapter('7th Expeditionary Force', 'exp_force', '7', 'RMMC', $secondCorps->id, false);
        $eighthEF = $this->createChapter('8th Expeditionary Force', 'exp_force', '8', 'RMMC', $firstCorps->id, false);
        $tenthEF = $this->createChapter('10th Expeditionary Force', 'exp_force', '10', 'RMMC', $firstCorps->id, false);

        // Create the RMMC Regiments

        $fussiliers =
            $this->createChapter('The Sovereign\'s Regiment of Fusiliers', 'regiment', '', 'RMMC', $firstEF->id, false);
        $this->createChapter('Manticore Guards Regiment', 'regiment', '', 'RMMC', $firstEF->id, false);
        $this->createChapter('The Gryphon Highlanders Regiment', 'regiment', '', 'RMMC', $secondEF->id, false);
        $this->createChapter('The Montanero Regiment', 'regiment', '', 'RMMC', $thirdEF->id, false);
        $this->createChapter('The New Covenant Regiment', 'regiment', '', 'RMMC', $fourthEF->id, false);
        $this->createChapter('Royal Adrienne\'s Regiment', 'regiment', '', 'RMMC', $fifthEF->id, false);
        $this->createChapter('The Tannerman Rifle Regiment', 'regiment', '', 'RMMC', $sixthEF->id, false);
        $this->createChapter('The Gregor Regiment', 'regiment', '', 'RMMC', $seventhEF->id, false);
        $this->createChapter('The Medusa Regiment', 'regiment', '', 'RMMC', $eighthEF->id, false);
        $this->createChapter('The Lynx Regiment', 'regiment', '', 'RMMC', $tenthEF->id, false);

        // Assign London Point to the Fussiliers

        $lp = Chapter::where('hull_number', '=', 'RMOP-01')->first();

        $lp->assigned_to = $fussiliers->id;

        $this->writeAuditTrail(
            'system user',
            'update',
            'chapters',
            $lp->id,
            $lp->toJson(),
            'create rmmc chapters'
        );

        $lp->save();

        // Create RMMC MARDETS and assign them to their ships

        $rmmcEchelonTypes = [
            1 => 'shuttle',
            2 => 'section',
            3 => 'squad',
            4 => 'platoon',
            5 => 'company',
            6 => 'battalion',
        ];

        $mardets = [
            ['Hector', '30-Sep-15', 2],
            ['Rigel', '5-Sep-14', 2],
            ['Imperatrix', '5-Jul-14', 2],
            ['Invincible', '4-Jul-12', 6],
            ['Musashi', '31-Mar-14', 2],
            ['Valkyrie', '7-Oct-14', 5],
            ['Achilles', '17-Apr-15', 3],
            ['Agamemnon', '14-Jun-14', 2],
            ['Imperator', '5-Jun-15', 5],
            ['Interloper', '25-Apr-14', 5],
            ['Kraken', '29-Aug-15', 2],
            ['Saladin', '28-Nov-14', 2],
            ['Specter', '3-Apr-15', 4],
            ['Aegis', '19-May-15', 2],
            ['Barbarossa', '18-Jan-14', 2],
            ['Hydra', '8-Nov-14', 4],
            ['Invictus', '8-Jun-13', 2],
            ['Claymore', '7-Oct-13', 2],
            ['Enterprise', '10-Aug-14', 2],
            ['Andromeda', '17-Apr-15', 2],
            ['Black Rose', '1-Jul-14', 2],
            ['Truculent', '7-Aug-15', 2],
            ['Wolf', '12-Jun-14', 2],
        ];

        foreach ($mardets as $mardet) {
            // Look up the ship
            $ship = Chapter::where('chapter_name', '=', 'HMS ' . $mardet[0])->firstOrFail();

            $mardet[1] = date('Y-m-d', strtotime($mardet[1]));

            $this->createChapter(
                'MARDET ' . $mardet[0],
                $rmmcEchelonTypes[$mardet[2]],
                '',
                'RMMC',
                $ship->id,
                true,
                $mardet[1]
            );
        }

        // Create the assult shuttle

        $ship = Chapter::where('chapter_name', '=', 'HMS Invictus')->firstOrFail();

        $this->createChapter('AS Invictus-01', 'shuttle', '', 'RMMC', $ship->id, true, '2014-08-10');
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

    function createChapter(
        $name,
        $type = "ship",
        $hull_number = '',
        $branch = '',
        $assignedTo = null,
        $joinable = true,
        $commisionDate = null
    ) {
        $query = \Chapter::where('chapter_name', '=', $name)->first();

        if (empty($query->id) === true) {
            $record =
                [
                    'chapter_name' => $name,
                    'chapter_type' => $type,
                    'hull_number'  => $hull_number,
                    'branch'       => $branch,
                    'joinable'     => $joinable
                ];

            if (is_null($assignedTo) === false) {
                $record['assigned_to'] = $assignedTo;
            }

            if (is_null($commisionDate) === false) {
                $record['commission_date'] = $commisionDate;
            }

            $this->writeAuditTrail(
                'system user',
                'create',
                'chapters',
                null,
                json_encode($record),
                'create rmmc chapters'
            );
            return \Chapter::create($record);
        } else {
            echo "Skipping " . $name . ", unit already exists.\n";
            return $query;
        }
    }
}
