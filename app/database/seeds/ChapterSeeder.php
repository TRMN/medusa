<?php

class ChapterSeeder extends Seeder
{

    public function run()
    {
        DB::collection( 'chapters' )->delete();

        // Setup the Naval Districts

        $districts = [
          1 => ['chapter_name' => 'First Naval District', 'tool_tip' => 'DC, MD, NJ, DE, PA, NY, CT, MA, RI, VT, ME, NH, Northern VA*, Quebec, New Brunswick, Nova Scotia, P.E.I. & Newfoundland', 'chapter_type' => 'district', 'hull_number' => '1'],
          2 => ['chapter_name' => 'Second  Naval District', 'tool_tip' => 'MI, OH, IL, WI, IN, KY, MN & Ontario', 'chapter_type' => 'district', 'hull_number' => '2'],
          3 => ['chapter_name' => 'Third Naval District', 'tool_tip' => 'Southern VA, WV, NC, SC, AL, TN, MS, GA, FL, Mexico & The Caribbean', 'chapter_type' => 'district', 'hull_number' => '3'],
          4 => ['chapter_name' => 'Fourth Naval District', 'tool_tip' => 'Correspondence Chapters', 'chapter_type' => 'district', 'hull_number' => '4'],
          5 => ['chapter_name' => 'Fifth Naval District', 'tool_tip' => 'Australia, New Zealand, Oceania, China, Japan, Philippines and the Indochina Peninsula', 'chapter_type' => 'district', 'hull_number' => '5'],
          6 => ['chapter_name' => 'Sixth Naval District', 'tool_tip' => 'LA, TX, AR, OK, MO, KS, IA, NE, SD, ND and Manitoba', 'chapter_type' => 'district', 'hull_number' => '6'],
          7 => ['chapter_name' => 'Seventh Naval District', 'tool_tip' => 'Europe, The Russian Federation and South Africa', 'chapter_type' => 'district', 'hull_number' => '7'],
          8 => ['chapter_name' => 'Eight Naval District', 'tool_tip' => 'AZ, NM, UT, CO, WY, MT, Alberta and Saskatchewan', 'chapter_type' => 'district', 'hull_number' => '8'],
          9 => ['chapter_name' => 'Ninth Naval District', 'tool_tip' => 'Special Operations (Ad Astra and BuNine Staffs Only)', 'chapter_type' => 'district', 'hull_number' => '9'],
          10 => ['chapter_name' => 'Tenth Naval District', 'tool_tip' => 'CA, NV, OR, ID, WA, HI, AK, British Columbia and the Yukon Territory', 'chapter_type' => 'district', 'hull_number' => '10'],
        ];

        // Setup the Fleets

        $fleets = [
            1  => ['chapter_name' => 'Home Fleet', 'chapter_type' => 'fleet', 'hull_number' => '1'],
            2  => ['chapter_name' => 'Gryphon Fleet', 'chapter_type' => 'fleet', 'hull_number' => '2'],
            3  => ['chapter_name' => 'San Martino Fleet', 'chapter_type' => 'fleet', 'hull_number' => '3'],
            4  => ['chapter_name' => 'Grayson Space Navy', 'chapter_type' => 'fleet', 'hull_number' => '4'],
            5  => ['chapter_name' => 'Zanzibar Fleet', 'chapter_type' => 'fleet', 'hull_number' => '5'],
            6  => ['chapter_name' => 'Sphinx Fleet', 'chapter_type' => 'fleet', 'hull_number' => '6'],
            7  => ['chapter_name' => 'Andermani Fleet', 'chapter_type' => 'fleet', 'hull_number' => '7'],
            8  => ['chapter_name' => 'Basilisk Fleet', 'chapter_type' => 'fleet', 'hull_number' => '8'],
            9  => ['chapter_name' => 'Torch Fleet', 'chapter_type' => 'fleet', 'hull_number' => '9'],
            10 => ['chapter_name' => 'Talbott Fleet', 'chapter_type' => 'fleet', 'hull_number' => '10'],
        ];

        foreach ($districts as  $district) {
            $district['joinable'] = false;
            $this->command->comment("Creating " . $district['chapter_name']);
            $result = Chapter::create($district);
            $fleets[$district['hull_number']]['assigned_to'] = $result->_id;
        }

        foreach ($fleets as $fleet) {
            $fleet['joinable'] = false;
            $this->command->comment("Creating " . $fleet['chapter_name'] . " assigned to " . $districts[$fleet['hull_number']]['chapter_name']);
            $result = Chapter::create($fleet);
            $fleets[$fleet['hull_number']]['_id'] = $result->_id;
        }

        // Create Admiralty House
        $ah = $this->createChapter('Admiralty House', 'headquarters', 'AH', 'RMN', false);

        // Create the Bureau's

        $bureaus = [
            '1' => 'Office of the First Space Lord',
            '2' => 'Bureau of Planning (BuPlan)',
            '3' => 'Bureau of Ships (BuShip)',
            '4' => 'Bureau of Communications (BuComm)',
            '5' => 'Bureau of Personnel (BuPers)',
            '6' => 'Bureau of Training (BuTrain)',
            '7' => 'Bureau of Supply (BuSup)'
        ];

        foreach ($bureaus as $num => $bureau) {
            $record = ['chapter_name' => $bureau, 'chapter_type' => 'bureau', 'hull_number' => $num, 'assigned_to' => $ah->_id, 'joinable' => false];
            $this->command->comment('Creating ' . $bureau);
            Chapter::create($record);
        }

        // Create King William's Tower
        $this->createChapter('King William\'s Tower', 'headquarters', 'KWT', 'RMA', false);

        // Add the holding chapters
        $this->createChapter('HMSS Greenwich', 'station', 'SS-001', 'RMN');
        $this->createChapter('GNSS Katherine Mayhew', 'station', 'SS-002', 'GSN');
        $this->createChapter('London Point', 'headquarters', 'LP', 'RMMC');
        $this->createChapter('Headquarters Company', 'headquarters', 'HC', 'RMA');

    }

    function createChapter( $name, $type = "ship", $hull_number = '', $branch='', $joinable = true )
    {
        $this->command->comment('Creating ' . $name);
        return Chapter::create( ['chapter_name' => $name, 'chapter_type' => $type, 'hull_number' => $hull_number, 'branch' => $branch, 'joinable' => $joinable] );
    }
}
