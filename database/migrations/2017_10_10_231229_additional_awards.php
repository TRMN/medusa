<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Award;

class AdditionalAwards extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $loh = Award::where('code', 'LOH')->first();

        $loh->name = 'List of Honor Citation';
        $loh->replaces = '';
        $loh->multiple = true;
        $loh->group_label = '';

        $loh->save();

        // Update the FEA in Gold
        $fea = Award::where('code', 'FEA')->first();
        $fea->name = "Fleet Excellence Award";
        $fea->save();

        foreach (['LOHP', 'QE3SJM', 'QE3GJM', 'FEAS'] as $code) {
            Award::where('code', $code)->delete();
        }

        // Remove the Army weapons qualifications/rating

        $quals = ['HER', 'ER', 'SR', 'MC',];

        $weapons = [
            'G' => 'Grenade',
            'D' => 'Disrupter',
            'FG' => 'Flechette Gun',
            'P' => 'Pistol',
            'R' => 'Rifle',
            'GL' => 'Grenade Launcher',
            'T' => 'Tribarrel',
            'PC' => 'Plasma Carbine',
            'PR' => 'Plasma Rifle',
        ];

        foreach ($quals as $qual) {
            foreach ($weapons as $code => $weapon) {
                Award::where('code', 'A' . $code . $qual)->delete();
            }
        }

        // Pull everything up after removing the Jubilee medals

        Award::where('display_order', '>=', 77)->where('display_order', '<', 1000)->decrement('display_order', 2);


        // Pull everything up 1 after removing the Fleet Excellence Award in Silver
        Award::where('display_order', '>=', 65)->where('display_order', '<', 1000)->decrement('display_order', 1);

        // Renumber the Navy Marksmanship Awards, the Recruit Training Ribbon, NCO Senior Course Ribbon and the AFS

        $marksmanship = [
            'NRHE' => 80,
            'NPHE' => 81,
            'NRE' => 83,
            'NPE' => 84,
            'NRS' => 86,
            'NPS' => 87,
            'NRMC' => 88,
            'NPMC' => 89,
            'RTR' => 91,
            'NCOSCR' => 92,
            'AFSM' => 93,
        ];

        foreach ($marksmanship as $code => $display_order) {
            $award = Award::where('code', $code)->first();
            $award->display_order = $display_order;
            if ($code !== 'NRMC' && $code !== 'NPMC') {
                $award->replaces = $award->replaces . ',' . substr($code, 0, 2) . 'MC';
            }
            $award->save();
        }


    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update the List of Honor listing

        $loh = Award::where('code', 'LOH')->first();

        $loh->name = 'List of Honor Citation (Chapter)';
        $loh->replaces = 'LOHP';
        $loh->multiple = true;
        $loh->group_label = 'List of Honor Citation';

        $loh->save();

        // Add Personal LOH citation
        Award::create([
            "display_order" => 61,
            "name" => "List of Honor Citation (Personal)",
            "code" => "LOHP",
            "post_nominal" => "",
            "replaces" => "",
            "location" => "R",
            "multiple" => false,
            "points" => 2
        ]);

        // Push everything down to make room for the Jubilee medals

        Award::where('display_order', '>=', 75)->where('display_order', '<', 1000)->increment('display_order', 2);

        // Add the Jubilee medals

        Award::create([
            "display_order" => 75,
            "name" => "Queen Elizabeth III Silver Jubilee Medal",
            "code" => "QE3SJM",
            "post_nominal" => "",
            "replaces" => "",
            "location" => "L",
            "multiple" => false,
            "points" => 1
        ]);

        Award::create([
            "display_order" => 76,
            "name" => "Queen Elizabeth III Gold Jubilee Medal",
            "code" => "QE3GJM",
            "post_nominal" => "",
            "replaces" => "",
            "location" => "L",
            "multiple" => false,
            "points" => 1
        ]);

        // Renumber the Navy Marksmanship Awards, the Recruit Training Ribbon, NCO Senior Course Ribbon and the AFS

        $renumber = [
            'NRHE' => 82,
            'NPHE' => 83,
            'NRE' => 93,
            'NPE' => 94,
            'NRS' => 104,
            'NPS' => 105,
            'NRMC' => 115,
            'NPMC' => 116,
            'RTR' => 126,
            'NCOSCR' => 127,
            'AFSM' => 128,
        ];

        foreach ($renumber as $code => $display_order) {
            $award = Award::where('code', $code)->first();
            $award->display_order = $display_order;
            if ($code !== 'NRMC' && $code !== 'NPMC') {
                $award->replaces = $award->replaces . ',' . substr($code, 0, 2) . 'MC';
            }
            $award->save();
        }

        // Add the Army weapons qualifications/rating

        $quals = [
            'HER' => ['start' => 84, 'suffix' => 'High Expert Rating', 'points' => 4, 'replaces' => '@ER,@SR,@MC'],
            'ER' => ['start' => 95, 'suffix' => 'Expert Rating', 'points' => 3, 'replaces' => '@SR,@MC'],
            'SR' => ['start' => 106, 'suffix' => 'Sharpshooter Rating', 'points' => 2, 'replaces' => '@MC'],
            'MC' => ['start' => 117, 'suffix' => 'Marksmanship Certificate', 'points' => 1, 'replaces' => ''],
        ];

        $weapons = [
            'G' => 'Grenade',
            'D' => 'Disrupter',
            'FG' => 'Flechette Gun',
            'P' => 'Pistol',
            'R' => 'Rifle',
            'GL' => 'Grenade Launcher',
            'T' => 'Tribarrel',
            'PC' => 'Plasma Carbine',
            'PR' => 'Plasma Rifle',
        ];

        foreach ($quals as $suffix => $typeInfo) {
            $display_order = $typeInfo['start'];
            foreach ($weapons as $code => $weapon) {

                Award::create([
                    "display_order" => $display_order,
                    "name" => "Army " . $weapon . " " . $typeInfo['suffix'],
                    "code" => "A" . $code . $suffix,
                    "post_nominal" => "",
                    "replaces" => str_replace('@', 'A' . $code, $typeInfo['replaces']),
                    "location" => "NA",
                    "multiple" => false,
                    "points" => $typeInfo['points'],
                    "group_label" => 'Army ' . $weapon . ' Marksmanship',
                ]);
                $display_order++;
            }
        }

        // Push everything down 1 and insert the Fleet Excellence Award in Silver
        Award::where('display_order', '>=', 64)->where('display_order', '<', 1000)->increment('display_order', 1);

        // Add the FEA in Silver
        Award::create([
            "display_order" => 64,
            "name" => "Fleet Excellence Award in Silver",
            "code" => "FEAS",
            "post_nominal" => "",
            "replaces" => "",
            "location" => "L",
            "multiple" => true,
            "points" => 1,
        ]);

        // Update the FEA in Gold
        $fea = Award::where('code', 'FEA')->first();
        $fea->name = "Fleet Excellence Award in Gold";
        $fea->save();
    }


}
