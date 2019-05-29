<?php

use Illuminate\Database\Migrations\Migration;

class UpdateRankTitles extends Migration
{
    use \App\Models\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $grades = [
            'E-1'   => [
                'RMN'  => 'Spacer 3rd Class',
                'RMMC' => 'Private',
                'RMA'  => 'Private',
                'GSN'  => 'Spacer 3rd Class',
                'RHN'  => 'Spacer 3rd Class',
                'IAN'  => 'Gefraiter',
            ],
            'E-2'   => [
                'RMN'  => 'Spacer 2nd Class',
                'RMMC' => 'Private First Class   ',
                'RMA'  => 'Private First Class   ',
                'GSN'  => 'Spacer 2nd Class',
                'RHN'  => 'Spacer 2nd Class',
                'IAN'  => 'Obergefraiter',
            ],
            'E-3'   => [
                'RMN'  => 'Spacer 1st Class',
                'RMMC' => 'Lance Corporal',
                'RMA'  => 'Lance Corporal',
                'GSN'  => 'Spacer 1st Class',
                'RHN'  => 'Spacer 1st Class',
                'IAN'  => 'Hauptgefraiter',
            ],
            'E-4'   => [
                'RMN'  => 'Petty Officer 3rd Class',
                'RMMC' => 'Corporal',
                'RMA'  => 'Corporal',
                'GSN'  => 'Petty Officer 3rd Class   ',
                'RHN'  => 'Petty Officer 3rd Class   ',
                'IAN'  => 'Maat',
            ],
            'E-5'   => [
                'RMN'  => 'Petty Officer 2nd Class',
                'RMMC' => '(Platoon) Sergeant   ',
                'RMA'  => '(Platoon) Sergeant   ',
                'GSN'  => 'Petty Officer 2nd Class',
                'RHN'  => 'Petty Officer 2nd Class',
                'IAN'  => 'Obermaat',
            ],
            'E-6'   => [
                'RMN'  => 'Petty Officer 1st Class',
                'RMMC' => 'Staff Sergeant',
                'RMA'  => 'Staff Sergeant',
                'GSN'  => 'Petty Officer 1st Class',
                'RHN'  => 'Petty Officer 1st Class',
                'IAN'  => 'Bootsman',
            ],
            'E-7'   => [
                'RMN'  => 'Chief Petty Officer',
                'RMMC' => 'First Sergeant',
                'RMA'  => 'First Sergeant',
                'GSN'  => 'Chief Petty Officer',
                'RHN'  => 'Chief Petty Officer',
                'IAN'  => 'Oberbootsman',
            ],
            'E-8'   => [
                'RMN'  => 'Senior Chief Petty Officer',
                'RMMC' => 'Master Sergeant',
                'RMA'  => 'Master Sergeant',
                'GSN'  => 'Senior Chief Petty Officer',
                'RHN'  => 'Senior Chief Petty Officer',
                'IAN'  => 'Stabsbootsman',
            ],
            'E-9'   => [
                'RMN'  => 'Master Chief Petty Officer',
                'RMMC' => 'Sergeant Major',
                'RMA'  => 'Sergeant Major',
                'GSN'  => 'Master Chief Petty Officer',
                'RHN'  => 'Master Chief Petty Officer',
                'IAN'  => 'Oberstabsbootsman',
            ],
            'E-10'  => [
                'RMN'  => 'Senior Master Chief Petty Officer',
                'RMMC' => 'Regimental Sergeant Major   ',
                'RMA'  => 'Regimental Sergeant Major   ',
                'GSN'  => 'Senior Master Chief Petty Officer',
                'RHN'  => 'Master Chief Petty Officer of the Navy',
                'IAN'  => 'Oberstabsbootsman der Flotte',
            ],
            'WO-1'  => [
                'RMN'  => 'Warrant Officer 2nd Class',
                'RMMC' => 'Warrant Officer 2nd Class',
                'RMA'  => 'Warrant Officer 2nd Class',
                'GSN'  => 'Warrant Officer 2nd Class',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'WO-2'  => [
                'RMN'  => 'Warrant Officer 1st Class',
                'RMMC' => 'Warrant Officer 1st Class',
                'RMA'  => 'Warrant Officer 1st Class',
                'GSN'  => 'Warrant Officer 1st Class',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'WO-3'  => [
                'RMN'  => 'Chief Warrant Officer',
                'RMMC' => 'Chief Warrant Officer',
                'RMA'  => 'Chief Warrant Officer',
                'GSN'  => 'Chief Warrant Officer',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'WO-4'  => [
                'RMN'  => 'Senior Chief Warrant Officer',
                'RMMC' => 'Senior Chief Warrant Officer',
                'RMA'  => 'Senior Chief Warrant Officer',
                'GSN'  => 'Senior Chief Warrant Officer',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'WO-5'  => [
                'RMN'  => 'Master Chief Warrant Officer',
                'RMMC' => 'Master Chief Warrant Officer',
                'RMA'  => 'Master Chief Warrant Officer',
                'GSN'  => 'Master Chief Warrant Officer',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'O-1'   => [
                'RMN'  => 'Ensign',
                'RMMC' => '2nd Lieutenant',
                'RMA'  => '2nd Lieutenant',
                'GSN'  => 'Ensign',
                'RHN'  => 'Ensign',
                'IAN'  => 'Leutnant der Sterne',
            ],
            'O-2'   => [
                'RMN'  => 'Lieutenant (JG)',
                'RMMC' => '1st Lieutenant',
                'RMA'  => '1st Lieutenant',
                'GSN'  => 'Lieutenant (JG)',
                'RHN'  => 'Lieutenant (JG)',
                'IAN'  => 'Oberleutnant der Sterne',
            ],
            'O-3'   => [
                'RMN'  => 'Lieutenant (SG)',
                'RMMC' => 'Captain',
                'RMA'  => 'Captain',
                'GSN'  => 'Lieutenant (SG)',
                'RHN'  => 'Lieutenant (SG)',
                'IAN'  => 'Kapitainleutnant',
            ],
            'O-4'   => [
                'RMN'  => 'Lieutenant Commander',
                'RMMC' => 'Major',
                'RMA'  => 'Major',
                'GSN'  => 'Lieutenant Commander',
                'RHN'  => 'Lieutenant Commander',
                'IAN'  => 'Korvettenkapitain',
            ],
            'O-5'   => [
                'RMN'  => 'Commander',
                'RMMC' => 'Lieutenant Colonel',
                'RMA'  => 'Lieutenant Colonel',
                'GSN'  => 'Commander',
                'RHN'  => 'Commander',
                'IAN'  => 'Fregattenkapitain',
            ],
            'O-6'   => [
                'RMN'  => '',
                'RMMC' => 'Colonel',
                'RMA'  => 'Colonel',
                'GSN'  => 'Captain',
                'RHN'  => 'Captain',
                'IAN'  => 'Kapitain der Sterne',
            ],
            'O-6-A' => ['RMN' => 'Captain (JG)', 'RMMC' => '', 'RMA' => '', 'GSN' => '', 'RHN' => '', 'IAN' => ''],
            'O-6-B' => [
                'RMN'  => 'Captain (SG)',
                'RMMC' => '',
                'RMA'  => '',
                'GSN'  => 'Captain',
                'RHN'  => 'Captain',
                'IAN'  => 'Kapitain der Sterne',
            ],
            'F-1'   => [
                'RMN'  => 'Commodore',
                'RMMC' => 'Brigadier General',
                'RMA'  => 'Brigadier General',
                'GSN'  => 'Commodore',
                'RHN'  => 'Commodore',
                'IAN'  => 'Flotillenadmiral',
            ],
            'F-2'   => [
                'RMN'  => '',
                'RMMC' => 'Major General',
                'RMA'  => 'Major General',
                'GSN'  => 'Rear Admiral',
                'RHN'  => 'Rear Admiral',
                'IAN'  => 'Konteradmiral',
            ],
            'F-2-A' => [
                'RMN'  => 'Rear Admiral of the Red',
                'RMMC' => '',
                'RMA'  => '',
                'GSN'  => '',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'F-2-B' => [
                'RMN'  => 'Rear Admiral of the Green',
                'RMMC' => '',
                'RMA'  => '',
                'GSN'  => '',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'F-3'   => [
                'RMN'  => '',
                'RMMC' => 'Lieutenant General',
                'RMA'  => 'Lieutenant General',
                'GSN'  => 'Vice Admiral',
                'RHN'  => 'Vice Admiral',
                'IAN'  => 'Vizeadmiral',
            ],
            'F-3-A' => [
                'RMN'  => 'Vice Admiral of the Red',
                'RMMC' => '',
                'RMA'  => '',
                'GSN'  => '',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'F-3-B' => [
                'RMN'  => 'Vice Admiral of the Green',
                'RMMC' => '',
                'RMA'  => '',
                'GSN'  => '',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'F-4'   => [
                'RMN'  => '',
                'RMMC' => 'General',
                'RMA'  => 'General',
                'GSN'  => 'Admiral',
                'RHN'  => 'Admiral',
                'IAN'  => 'Admiral',
            ],
            'F-4-A' => [
                'RMN'  => 'Admiral of the Red',
                'RMMC' => '',
                'RMA'  => '',
                'GSN'  => '',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'F-4-B' => [
                'RMN'  => 'Admiral of the Green',
                'RMMC' => '',
                'RMA'  => '',
                'GSN'  => '',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'F-5'   => [
                'RMN'  => '',
                'RMMC' => 'Field Marshall',
                'RMA'  => 'Field Marshall',
                'GSN'  => 'Fleet Admiral',
                'RHN'  => 'Fleet Admiral',
                'IAN'  => 'Großadmiral',
            ],
            'F-5-A' => [
                'RMN'  => 'Fleet Admiral of the Red',
                'RMMC' => '',
                'RMA'  => '',
                'GSN'  => '',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'F-5-B' => [
                'RMN'  => 'Fleet Admiral of the Green',
                'RMMC' => '',
                'RMA'  => '',
                'GSN'  => '',
                'RHN'  => '',
                'IAN'  => '',
            ],
            'F-6'   => [
                'RMN'  => 'Admiral of the Fleet',
                'RMMC' => 'Marshall of the Corps',
                'RMA'  => 'Marshall of the Army',
                'GSN'  => 'High Admiral',
                'RHN'  => '',
                'IAN'  => 'Großadmiral der Flotte',
            ],
            'C-1'   => [
                'CIVIL' => 'Civilian One',
                'INTEL' => 'Civilian One',
                'SFS'   => 'Cadet Ranger One',
                'RMMM'  => 'Apprentice Merchant Spacer',
                'RMACS' => 'Trainee',
            ],
            'C-2'   => [
                'CIVIL' => 'Civilian Two',
                'INTEL' => 'Civilian Two',
                'SFS'   => 'Cadet Ranger Two',
                'RMMM'  => 'Able Merchant Spacer',
                'RMACS' => 'Petty Officer 3rd Class',
            ],
            'C-3'   => [
                'CIVIL' => 'Civilian Three',
                'INTEL' => 'Civilian Three',
                'SFS'   => 'Cadet Ranger Three',
                'RMMM'  => 'Leading Merchant Spacer',
                'RMACS' => 'Petty Officer 2nd Class',
            ],
            'C-4'   => [
                'CIVIL' => 'Administrative Specialist',
                'INTEL' => 'Administrative Specialist',
                'SFS'   => '',
                'RMMM'  => '',
                'RMACS' => '',
            ],
            'C-5'   => [
                'CIVIL' => 'Administrator',
                'INTEL' => 'Administrator',
                'SFS'   => '',
                'RMMM'  => '',
                'RMACS' => '',
            ],
            'C-6'   => [
                'CIVIL' => 'Senior Administrator',
                'INTEL' => 'Senior Administrator',
                'SFS'   => 'Senior Cadet Ranger',
                'RMMM'  => '',
                'RMACS' => 'Petty Officer 1st Class',
            ],
            'C-7'   => [
                'CIVIL' => 'Consular Staff',
                'INTEL' => 'Probationary Special Agent',
                'SFS'   => 'Ranger',
                'RMMM'  => 'Chief Petty Officer',
                'RMACS' => 'Chief Petty Officer',
            ],
            'C-8'   => [
                'CIVIL' => 'Consular Agent',
                'INTEL' => 'Special Agent',
                'SFS'   => '',
                'RMMM'  => 'Senior Chief Petty Officer',
                'RMACS' => 'Senior Chief Petty Officer',
            ],
            'C-9'   => [
                'CIVIL' => 'Embassy Staff',
                'INTEL' => 'Foreign Service Officer',
                'SFS'   => 'Ranger Corporal',
                'RMMM'  => '',
                'RMACS' => 'Master Chief Petty Officer',
            ],
            'C-10'  => [
                'CIVIL' => 'Section Chief',
                'INTEL' => 'Section Chief',
                'SFS'   => '',
                'RMMM'  => '',
                'RMACS' => '',
            ],
            'C-11'  => [
                'CIVIL' => 'Consular Attaché',
                'INTEL' => 'Consulate Intelligence Liaison',
                'SFS'   => 'Ranger Sergeant',
                'RMMM'  => '',
                'RMACS' => '',
            ],
            'C-12'  => [
                'CIVIL' => 'Vice-consul',
                'INTEL' => 'Senior Special Agent',
                'SFS'   => 'Ranger Lieutenant',
                'RMMM'  => 'Officer Cadet',
                'RMACS' => ' Ensign',
            ],
            'C-13'  => [
                'CIVIL' => 'Special Envoy',
                'INTEL' => 'Senior Principle Officer',
                'SFS'   => 'Ranger Captain',
                'RMMM'  => 'Fourth Officer',
                'RMACS' => ' Lieutenant (JG)',
            ],
            'C-14'  => [
                'CIVIL' => 'Consul',
                'INTEL' => 'Chief of Station',
                'SFS'   => 'Ranger Major',
                'RMMM'  => 'Third Officer',
                'RMACS' => ' Lieutenant (SG)',
            ],
            'C-15'  => [
                'CIVIL' => 'Embassy Attaché',
                'INTEL' => 'Embassy Intelligence Liaison',
                'SFS'   => 'Ranger Lt. Colonel',
                'RMMM'  => 'Second Officer',
                'RMACS' => ' Lieutenant Commander',
            ],
            'C-16'  => [
                'CIVIL' => 'Embassy Senior Attaché',
                'INTEL' => 'Embassy Senior Intelligence Liaison',
                'SFS'   => 'Ranger Colonel',
                'RMMM'  => 'Chief Officer',
                'RMACS' => ' Commander',
            ],
            'C-17'  => [
                'CIVIL' => 'Consul General',
                'INTEL' => 'Zone Chief',
                'SFS'   => 'Station Chief Ranger',
                'RMMM'  => 'Master/Captain',
                'RMACS' => 'Captain',
            ],
            'C-18'  => [
                'CIVIL' => 'Minister Resident',
                'INTEL' => 'Sector Chief',
                'SFS'   => 'Sector Chief Ranger',
                'RMMM'  => '',
                'RMACS' => '',
            ],
            'C-19'  => [
                'CIVIL' => 'Envoy Extraordinary and Plenipotentiary',
                'INTEL' => 'Regional Director',
                'SFS'   => 'Planetary Chief Ranger',
                'RMMM'  => '',
                'RMACS' => 'Rear Admiral',
            ],
            'C-20'  => [
                'CIVIL' => 'Chargé d’affairs',
                'INTEL' => 'Deputy Director of Operations',
                'SFS'   => 'Head Ranger',
                'RMMM'  => '',
                'RMACS' => 'Vice Admiral',
            ],
            'C-21'  => [
                'CIVIL' => 'Ambassador Extraordinary and Plenipotentiary',
                'INTEL' => 'Deputy Director of Intelligence',
                'SFS'   => '',
                'RMMM'  => '',
                'RMACS' => 'Admiral',
            ],
            'C-22'  => [
                'CIVIL' => 'Foreign Minister',
                'INTEL' => 'Director of Intelligence',
                'SFS'   => 'Commissioner',
                'RMMM'  => '',
                'RMACS' => '',
            ],
            'C-23'  => ['CIVIL' => 'Home Secretary', 'INTEL' => '', 'SFS' => '', 'RMMM' => '', 'RMACS' => ''],
        ];

        foreach ($grades as $grade => $titles) {
            $record = App\Models\Grade::where('grade', '=', $grade)->first();

            if (empty($record) === true) {
                // Grade does not exist, we must create it
                $record = new App\Models\Grade();

                $record->grade = $grade;
                $record->rank = $titles;

                $this->writeAuditTrail(
                    'system user',
                    'insert',
                    'grades',
                    null,
                    $record->toJson(),
                    'update_rank_titles'
                );
            } else {
                // Update the existing record
                $record->rank = $titles;

                $this->writeAuditTrail(
                    'system user',
                    'update',
                    'grades',
                    $record->id,
                    $record->toJson(),
                    'update_rank_titles'
                );
            }

            $record->save();
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
