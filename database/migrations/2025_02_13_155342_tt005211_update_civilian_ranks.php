<?php

use App\Grade;
use App\Rating;
use Illuminate\Database\Migrations\Migration;

class TT005211UpdateCivilianRanks extends Migration
{
    public function update_paygrades(string $branch, array $paygrades)
    {
        foreach ($paygrades as $paygrade => $title) {
            $rec = Grade::where('grade', $paygrade)->first();
            $ranks = $rec->rank;
            if (is_null($title)) {
                unset($ranks[$branch]);
            } else {
                $ranks[$branch] = $title;
            }

            $rec->rank = $ranks;
            $rec->save();
        }
    }

    public function update_ratings(string $ratecode, string $branch, array $new_ratings)
    {
        $rec = Rating::where('grade', $ratecode)->first();

        foreach ($new_ratings as $paygrade => $title) {
            if (is_null($title)) {
                unset($rec->rate[$branch][$paygrade]);
            } else {
                $rec->rate[$branch][$paygrade] = $title;
            }
        }

        $rec->save();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up_rhn() {
        $paygrades = [
            'E-10' => 'Senior Master Chief Petty Officer',
        ];

        $this->update_paygrades('RHN', $paygrades);
    }

    public function up_diplomatic() {

        $rate_code = 'DIPLOMATIC';
        $ratings = [
            'C-1' => 'Consulate Staff',
            'C-2' => 'Senior Consulate Staff',
            'C-3' => 'Junior Attaché',
            'C-4' => 'Attaché',
            'C-5' => 'Consular Attaché',
            'C-6' => 'Senior Consular Attaché',
            'C-7' => 'Third Secretary',
            'C-8' => 'Second Secretary',
            'C-9' => 'First Secretary',
            'C-10' => 'Senior Administrator',
            'C-11' => 'Foreign Service Officer',
            'C-12' => 'Vice Consul',
            'C-13' => 'Counselor',
            'C-14' => 'Minister-Counselor',
            'C-15' => 'Minister',
            'C-16' => 'Ambassador',
            'C-17' => 'Legate',
            'C-18' => 'Special Envoy',
            'C-19' => 'Permanent Representative',
            'C-20' => 'Minister Resident',
            'C-21' => 'Ambassador at Large',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_ratings($rate_code, 'CIVIL', $ratings);
    }

    public function up_intel()
    {
        $rate_code = 'INTEL';
        $ratings = [
            'C-1' => 'Analyst',
            'C-2' => 'Senior Analyst',
            'C-3' => 'Junior Agent',
            'C-4' => 'Agent 3rd Class',
            'C-5' => 'Agent 2nd Class',
            'C-6' => 'Agent 1st Class',
            'C-7' => 'Senior Agent',
            'C-8' => 'Supervising Agent',
            'C-9' => 'Section Chief',
            'C-10' => 'Station Supervisor',
            'C-11' => 'Special Agent 3rd Class',
            'C-12' => 'Special Agent 2nd Class',
            'C-13' => 'Special Agent 1st Class',
            'C-14' => 'Senior Special Agent',
            'C-15' => 'Principal Agent',
            'C-16' => 'System Agent',
            'C-17' => 'Regional Agent',
            'C-18' => 'Sector Agent',
            'C-19' => 'Quadrant Agent',
            'C-20' => 'Department Director',
            'C-21' => 'Bureau Head',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_ratings($rate_code, 'CIVIL', $ratings);
    }

    public function up_rmacs()
    {
        $paygrades = [
            'C-1' => 'Recruit',
            'C-2' => 'Trainee',
            'C-3' => 'Candidate',
            'C-4' => 'Petty Officer Third Class',
            'C-5' => 'Petty Officer Second Class',
            'C-6' => 'Petty Officer First Class',
            'C-7' => 'Chief Petty Officer',
            'C-8' => 'Senior Chief Petty Officer',
            'C-9' => 'Master Chief Petty Officer',
            'C-10' => 'Senior Master Chief Petty Officer',
            'C-11' => 'Ensign',
            'C-12' => 'Lieutenant (JG)',
            'C-13' => 'Lieutenant (SG)',
            'C-14' => 'Lieutenant Commander',
            'C-15' => 'Commander',
            'C-16' => 'Captain',
            'C-17' => 'Commodore',
            'C-18' => 'Rear Admiral',
            'C-19' => 'Vice Admiral',
            'C-20' => 'Admiral',
            'C-21' => 'Transport Minister',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_paygrades('RMACS', $paygrades);
    }

    public function up_rmmm_basic()
    {
        $ratings = [
            'rate_code' => 'BASIC',
            'rate' => [
                'description' => 'RMMM Basic Division',
                'RMMM' => [
                    'C-1' => 'Apprentice Spacer',
                    'C-2' => 'General Vessel Assistant',
                    'C-3' => 'Spacer I',
                    'C-4' => 'Spacer II',
                    'C-5' => 'Spacer III',
                    'C-6' => 'Spacer IV',
                    'C-7' => 'Spacer V',
                    'C-8' => 'Spacer VI',
                    'C-9' => null,
                    'C-10' => null,
                ],
            ],
        ];

        Rating::insert($ratings);
    }

    public function up_rmmm_deck()
    {
        $rate_code = 'DECK';
        $ratings = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'General Vessel Assistant',
            'C-3' => 'Ordinary Spacer',
            'C-4' => 'Senior Ordinary Spacer',
            'C-5' => 'Efficient Spacer',
            'C-6' => 'Able Spacer',
            'C-7' => 'Leading Spacer',
            'C-8' => 'Certified Bosun',
            'C-9' => 'Patrolman',
            'C-10' => 'President',
            'C-11' => 'Fourth Officer',
            'C-12' => 'Third Officer',
            'C-13' => 'Second Officer',
            'C-14' => 'Senior Second Officer',
            'C-15' => 'First Officer',
            'C-16' => 'Master',
            'C-17' => 'Fleet Manager',
            'C-18' => 'Superintendent',
            'C-19' => 'Managing Director',
            'C-20' => 'Owner',
            'C-21' => 'Board Director',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_ratings($rate_code, 'RMMM', $ratings);
    }

    public function up_rmmm_engineering()
    {
        $rate_code = 'ENG';
        $ratings = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'General Vessel Assistant',
            'C-3' => 'Wiper',
            'C-4' => 'Technician',
            'C-5' => 'Technician II',
            'C-6' => 'Technician III',
            'C-7' => 'Technician IV',
            'C-8' => 'Technician V',
            'C-9' => 'Patrolman',
            'C-10' => 'President',
            'C-11' => 'Fourth Engineer',
            'C-12' => 'Third Engineer',
            'C-13' => 'Second Engineer',
            'C-14' => 'Senior Second Engineer',
            'C-15' => 'First Engineer',
            'C-16' => 'Chief Engineer',
            'C-17' => 'Fleet Port Manager',
            'C-18' => 'Superintendent',
            'C-19' => 'Managing Director',
            'C-20' => 'Owner',
            'C-21' => 'Board Director',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_ratings($rate_code, 'RMMM', $ratings);
    }

    public function up_rmmm_catering()
    {
        $rate_code = 'CATERING';
        $ratings = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'General Vessel Assistant',
            'C-3' => 'Steward Assistant',
            'C-4' => 'Second Cook',
            'C-5' => 'Steward',
            'C-6' => 'Baker',
            'C-7' => 'Chief Cook',
            'C-8' => 'Chief Steward',
            'C-9' => 'Patrolman',
            'C-10' => 'President',
            'C-11' => 'Junior Assistant Purser',
            'C-12' => 'Junior Purser',
            'C-13' => 'Purser',
            'C-14' => 'Entertainment Director',
            'C-15' => 'Cruise Director',
            'C-16' => 'Hotel Manager',
            'C-17' => 'Fleet Passenger Director',
            'C-18' => 'Superintendent',
            'C-19' => 'Managing Director',
            'C-20' => 'Owner',
            'C-21' => 'Board Director',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_ratings($rate_code, 'RMMM', $ratings);
    }

    public function up_rmmm_medical()
    {
        $rate_code = 'MEDICAL';
        $ratings = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'General Vessel Assistant',
            'C-3' => 'Medical Aide',
            'C-4' => 'Medical Assistant',
            'C-5' => 'Medical Technician',
            'C-6' => 'Paramedic',
            'C-7' => 'Sick Berth Attendant',
            'C-8' => 'Senior Sick Berth Attendant',
            'C-9' => 'Patrolman',
            'C-10' => 'President',
            'C-11' => 'Nursing Assistant',
            'C-12' => 'Nurse',
            'C-13' => 'Senior Nurse',
            'C-14' => 'Practical Nurse',
            'C-15' => 'Assistant Merchant Surgeon',
            'C-16' => 'Merchant Surgeon',
            'C-17' => 'Fleet Medical Director',
            'C-18' => 'Superintendent',
            'C-19' => 'Managing Director',
            'C-20' => 'Owner',
            'C-21' => 'Board Director',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_ratings($rate_code, 'RMMM', $ratings);
    }

    public function up_sfc()
    {
        $paygrades = [
            'C-1' => 'Assistant Ranger',
            'C-2' => 'Ranger',
            'C-3' => 'Ranger II',
            'C-4' => 'Ranger III',
            'C-5' => 'Senior Ranger',
            'C-6' => 'Senior Ranger II',
            'C-7' => 'Senior Ranger III',
            'C-8' => 'Deputy Chief Ranger',
            'C-9' => 'Chief Ranger',
            'C-10' => 'Senior Chief Ranger',
            'C-11' => 'Ranger 2nd Lieutenant',
            'C-12' => 'Ranger 1st Lieutenant',
            'C-13' => 'Ranger Captain',
            'C-14' => 'Ranger Major',
            'C-15' => 'Ranger Lieutenant Colonel',
            'C-16' => 'Ranger Colonel',
            'C-17' => 'Ranger Brigadier General',
            'C-18' => 'Ranger Major General',
            'C-19' => 'Ranger Lieutenant General',
            'C-20' => 'Ranger General',
            'C-21' => 'Ranger Marshal',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_paygrades('SFC', $paygrades);
    }


    public function up()
    {
        $this->up_rhn();
        $this->up_diplomatic();
        $this->up_intel();
        $this->up_rmacs();
        $this->up_rmmm_basic();
        $this->up_rmmm_deck();
        $this->up_rmmm_engineering();
        $this->up_rmmm_catering();
        $this->up_rmmm_medical();
        $this->up_sfc();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
