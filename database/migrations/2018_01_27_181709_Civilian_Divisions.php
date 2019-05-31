<?php

use Illuminate\Database\Migrations\Migration;

class CivilianDivisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // New divisions
        $commons = [
            'rate_code' => 'COMMONS',
            'rate'      => [
                'description'  => 'House of Commons',
                'CIVIL'        => [
                    'C-4'  => 'Administrative Specialist',
                    'C-5'  => 'Clerk',
                    'C-9'  => 'Aide',
                    'C-10' => 'Chief Aide',
                    'C-11' => 'District Office Staffer',
                    'C-16' => 'Chief of Staff',
                    'C-20' => 'Member of Parliament',
                    'C-22' => 'Speaker of the House',
                ],
            ],
        ];

        $lords = [
            'rate_code' => 'LORDS',
            'rate'      => [
                'description'  => 'House of Lords',
                'CIVIL'        => [
                    'C-4'  => 'Administrative Specialist',
                    'C-5'  => 'Clerk',
                    'C-9'  => 'Aide',
                    'C-10' => 'Chief Aide',
                    'C-11' => 'Local Office Staffer',
                    'C-16' => 'Chief of Staff',
                    'C-20' => 'Member of the Lords',
                    'C-22' => 'Lord Speaker',
                ],
            ],
        ];

        $diplo = [
            'rate_code' => 'DIPLOMATIC',
            'rate'      => [
                'description' => 'Diplomatic Corps',
                'CIVIL'       => [
                    'C-4'  => 'Administrative Specialist',
                    'C-5'  => 'Administrator',
                    'C-6'  => 'Senior Administrator',
                    'C-7'  => 'Consular Staff',
                    'C-8'  => 'Consular Agent',
                    'C-9'  => 'Embassy Staff',
                    'C-10' => 'Section Chief',
                    'C-11' => 'Consular Attaché',
                    'C-12' => 'Vice-Consul',
                    'C-13' => 'Special Envoy',
                    'C-14' => 'Consul',
                    'C-15' => 'Embassy Attaché',
                    'C-16' => 'Senior Embassy Attaché',
                    'C-17' => 'Consul General',
                    'C-18' => 'Resident Minister',
                    'C-19' => 'Envoy Extraordinary and Plenipotentiary',
                    'C-20' => 'Chargé d’affairs',
                    'C-21' => 'Ambassador Extraordinary and Plenipotentiary',
                    'C-22' => 'Foreign Minister',
                    'C-23' => 'Home Secretary',

                ],
            ],
        ];

        $intel = [
            'rate_code' => 'INTEL',
            'rate'      => [
                'description' => 'Intelligence Corps',
                'CIVIL'       => [
                    'C-4'  => 'Administrative Specialist',
                    'C-5'  => 'Administrator',
                    'C-6'  => 'Senior Administrator',
                    'C-7'  => 'Probationary Special Agent',
                    'C-8'  => 'Special Agent',
                    'C-9'  => 'Foreign Service Officer',
                    'C-10' => 'Section Chief',
                    'C-11' => 'Consulate Intelligence Liaison',
                    'C-12' => 'Senior Special Agent',
                    'C-13' => 'Senior Principal Officer',
                    'C-14' => 'Chief of Station',
                    'C-15' => 'Embassy Intelligence Liaison',
                    'C-16' => 'Senior Embassy Intelligence Liaison',
                    'C-17' => 'Zone Chief',
                    'C-18' => 'Sector Chief',
                    'C-19' => 'Regional Director',
                    'C-20' => 'Deputy Director of Operations',
                    'C-21' => 'Deputy Director of Intelligence',
                    'C-22' => 'Director of Intelligence',
                    'C-23' => 'Home Secretary',

                ],
            ],
        ];

        // Add the new divisions

        foreach ([$intel, $diplo, $commons, $lords] as $division) {
            \App\Models\Rating::insert($division);
        }

        // If a Civil member is C-6 or higher, set their rating/division to DIPLO
        foreach (\App\Models\User::where('branch', 'CIVIL')->get() as $member) {
            list($type, $grade) = explode('-', $member->rank['grade']);
            if ($grade > 5) {
                $member->rating = 'DIPLOMATIC';
                $member->save();
            }
        }

        // Change all the members with branch = INTEL to CIVIL and set their
        // rating to INTEL

        foreach (\App\Models\User::where('branch', 'INTEL')->get() as $member) {
            $member->branch = 'CIVIL';
            $member->rating = 'INTEL';
            $member->save();
        }

        // Set all the unrated civilian ranks to "Civilian One", etc
        for ($i = 1; $i <= 23; $i++) {
            $fmt = new \NumberFormatter('en_US', \NumberFormatter::SPELLOUT);

            $record = \App\Models\Grade::where('grade', 'C-'.$i)->first();

            $rank = $record->rank;
            unset($rank['INTEL']);
            $rank['CIVIL'] = 'Civilian '.ucfirst($fmt->format($i));

            $record->rank = $rank;
            $record->save();
        }

        // Update branches

        \App\Models\Branch::where('branch', 'INTEL')->delete();

        $civil = \App\Models\Branch::where('branch', 'CIVIL')->first();
        $civil->branch_name = 'Civil Service';
        $civil->save();

        // Update branches to show in list members

        $memberlist = \App\Models\MedusaConfig::get('memberlist.branches');

        unset($memberlist['INTEL']);

        \App\Models\MedusaConfig::set('memberlist.branches', $memberlist);
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
