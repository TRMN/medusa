<?php
/**
 * Created by PhpStorm.
 * User: dweiner
 * Date: 10/13/14
 * Time: 7:19 AM
 */

class TigSeeder extends Seeder {

    public function run()
    {
        DB::collection( 'tig' )->delete();

        $tigs = array(
            "E2" => array("tig_as" => "E1", "tig" => "3"),
            "E3" => array("tig_as" => "E2", "tig" => "5"),
            "E4" => array("tig_as" => "E3", "tig" => "7"),
            "E5" => array("tig_as" => "E4", "tig" => "9"),
            "E6" => array("tig_as" => "E5", "tig" => "11"),
            "E7" => array("tig_as" => "E6", "tig" => "13"),
            "E8" => array("tig_as" => "E7", "tig" => "15"),
            "E9" => array("tig_as" => "E8", "tig" => "19"),
            "E10" => array("tig_as" => "E9", "tig" => "24"),
            "WO1" => array("tig_as" => "E6", "tig" => "6"),
            "WO2" => array("tig_as" => "W21", "tig" => "9"),
            "WO3" => array("tig_as" => "WO2", "tig" => "11"),
            "WO4" => array("tig_as" => "WO3", "tig" => "13"),
            "WO5" => array("tig_as" => "WO4", "tig" => "15"),
            "01" => array("tig_as" => "E1", "tig" => "6"),
            "O2" => array("tig_as" => "O1", "tig" => "6"),
            "O3" => array("tig_as" => "O2", "tig" => "9"),
            "04" => array("tig_as" => "O3", "tig" => "12"),
            "O5" => array("tig_as" => "O4", "tig" => "15"),
            "O6A" => array("tig_as" => "05", "tig" => "18"),
            "O6B" => array("tig_as" => "O6A", "tig" => "18"),
            "F1" => array("tig_as" => "O6B", "tig" => "18"),
            "F2" => array("tig_as" => "F1", "tig" => "24"),
            "F3" => array("tig_as" => "F2", "tig" => "36"),
            "F4" => array("tig_as" => "F3", "tig" => "48"),
            "C2" => array("tig_as" => "C1", "tig" => "3"),
            "C3" => array("tig_as" => "C2", "tig" => "5"),
            "C4" => array("tig_as" => "C3", "tig" => "15"),
            "C5" => array("tig_as" => "C4", "tig" => "24"),
            "C6" => array("tig_as" => "C5", "tig" => "24"),
            "C7" => array("tig_as" => "C6", "tig" => "24"),
            "C8" => array("tig_as" => "C5", "tig" => "6"),
            "C9" => array("tig_as" => "C5", "tig" => "9"),
            "C10" => array("tig_as" => "C9", "tig" => "12"),
            "C11" => array("tig_as" => "C10", "tig" => "12"),
            "C12" => array("tig_as" => "C11", "tig" => "18"),
            "C13" => array("tig_as" => "C12", "tig" => "18"),
            "C14" => array("tig_as" => "C13", "tig" => "20"),
            "C15" => array("tig_as" => "C14", "tig" => "20"),
            "C16" => array("tig_as" => "C15", "tig" => "20"),
            "C17" => array("tig_as" => "C16", "tig" => "24"),
        );

        foreach ($tigs as $grade => $tig) {
            Tig::create([ 'grade' => $grade, 'tig' => $tig ]);
        }
    }

} 
