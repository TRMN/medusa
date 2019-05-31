<?php

use Illuminate\Database\Migrations\Migration;

class RMMMDivisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $medical = [
            'rate_code' => 'MEDICAL',
            'rate'      => [
                'description' => 'RMMM Medical Division',
                'RMMM'        => [
                    'C-6'  => 'Sick Berth Attendant',
                    'C-8'  => 'Senior Sick Berth Attendant',
                    'C-12' => 'Nurse',
                    'C-13' => 'Senior Nurse',
                    'C-15' => 'Assistant Merchant Surgeon',
                    'C-16' => 'Merchant Surgeon',
                    'C-18' => 'Fleet Medical Director',
                    'C-19' => 'Superintendent',
                    'C-20' => 'Managing Director ',
                    'C-21' => 'Owner',
                    'C-22' => 'Trade Minister',
                ],
            ],
        ];

        $catering = [
            'rate_code' => 'CATERING',
            'rate'      => [
                'description' => 'RMMM Catering Division',
                'RMMM'        => [
                    'C-2'  => 'Steward\'s Assistant',
                    'C-3'  => 'Pantry Attendant',
                    'C-6'  => 'Baker',
                    'C-7'  => 'Chief Cook',
                    'C-8'  => 'Chief Steward',
                    'C-12' => 'Junior Purser',
                    'C-13' => 'Purser',
                    'C-15' => 'Assistant Cruise Director',
                    'C-16' => 'Cruise Director',
                    'C-18' => 'Fleet Passenger Director',
                    'C-19' => 'Superintendent',
                    'C-20' => 'Managing Director ',
                    'C-21' => 'Owner',
                    'C-22' => 'Trade Minister',
                ],
            ],
        ];

        $eng = [
            'rate_code' => 'ENG',
            'rate'      => [
                'description' => 'RMMM Engineering Division',
                'RMMM'        => [
                    'C-2'  => 'Wiper',
                    'C-3'  => 'Technician 3',
                    'C-6'  => 'Technician 4',
                    'C-7'  => 'Technician 5',
                    'C-8'  => 'Technician 6',
                    'C-12' => 'Fourth Engineer',
                    'C-13' => 'Third Engineer',
                    'C-15' => 'Second Engineer',
                    'C-16' => 'First Engineer',
                    'C-17' => 'Chief Engineer',
                    'C-18' => 'Fleet Port Engineer',
                    'C-19' => 'Superintendent',
                    'C-20' => 'Managing Director ',
                    'C-21' => 'Owner',
                    'C-22' => 'Trade Minister',
                ],
            ],
        ];

        $deck = [
            'rate_code' => 'DECK',
            'rate'      => [
                'description' => 'RMMM Deck Division',
                'RMMM'        => [
                    'C-2'  => 'Ordinary Spacer',
                    'C-3'  => 'Efficient Spacer',
                    'C-6'  => 'Able Spacer',
                    'C-7'  => 'Leading Spacer',
                    'C-8'  => 'Certified Bosun',
                    'C-12' => 'Fourth Officer',
                    'C-13' => 'Third Officer',
                    'C-15' => 'Second Officer',
                    'C-16' => 'First Officer',
                    'C-17' => 'Master',
                    'C-18' => 'Fleet Manager',
                    'C-19' => 'Superintendent',
                    'C-20' => 'Managing Director ',
                    'C-21' => 'Owner',
                    'C-22' => 'Trade Minister',
                ],
            ],
        ];

        $ratings = [$medical, $catering, $eng, $deck];

        foreach ($ratings as $rating) {
            \App\Models\Rating::insert($rating);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Rating::whereIn('rate_code', ['DECK', 'ENG', 'CATERING', 'MEDICAL'])
                   ->delete();
    }
}
