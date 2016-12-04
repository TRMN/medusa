<?php

class GradeSeeder extends Seeder
{
    use \Medusa\Audit\MedusaAudit;

    public function run()
    {
        DB::collection( 'grades' )->delete();

        $grades = [
            "E-1"   => [
                "RMN"  => "Spacer 3rd Class",
                "RMMC" => "Private",
                "RMA"  => "Private",
                "GSN"  => "Spacer 3rd Class",
                "IAN"  => "Gerfraiter",
                "RHN"  => "Spacer 3rd Class"
            ],
            "E-2"   => [
                "RMA"  => "Private 1st Class",
                "RMMC" => "Private 1st Class",
                "RMN"  => "Spacer 2nd Class",
                "GSN"  => "Spacer 2nd Class",
                "IAN"  => "Obergefraiter",
                "RHN"  => "Spacer 2nd Class"
            ],
            "E-3"   => [
                "RMA"  => "Lance Corporal",
                "RMMC" => "Lance Corporal",
                "RMN"  => "Spacer 1st Class",
                "GSN"  => "Spacer 1st Class",
                "IAN"  => "Hauptgefraiter",
                "RHN"  => "Spacer 1st Class"
            ],
            "E-4"   => [
                "RMA"  => "Corporal",
                "RMMC" => "Corporal",
                "RMN"  => "Petty Officer 3rd Class",
                "GSN"  => "Petty Officer 3rd Class",
                "IAN"  => "Maat",
                "RHN"  => "Petty Officer 3rd Class"
            ],
            "E-5"   => [
                "RMA"  => "Platoon Sergeant",
                "RMMC" => "Platoon Sergeant",
                "RMN"  => "Petty Officer 2nd Class",
                "GSN"  => "Petty Officer 2nd Class",
                "IAN"  => "Obermaat",
                "RHN"  => "Petty Officer 2nd Class"
            ],
            "E-6"   => [
                "RMA"  => "Staff Sergeant",
                "RMMC" => "Staff Sergeant",
                "RMN"  => "Petty Officer 1st Class",
                "GSN"  => "Petty Officer 1st Class",
                "IAN"  => "Bootsman",
                "RHN"  => "Petty Officer 1st Class"
            ],
            "E-7"   => [
                "RMA"  => "Master Sergeant",
                "RMMC" => "Master Sergeant",
                "RMN"  => "Chief Petty Officer",
                "GSN"  => "Chief Petty Officer",
                "IAN"  => "Oberbootsman",
                "RHN"  => "Chief Petty Officer"
            ],
            "E-8"   => [
                "RMA"  => "First Sergeant",
                "RMMC" => "First Sergeant",
                "RMN"  => "Senior Chief Petty Officer",
                "GSN"  => "Senior Chief Petty Officer",
                "IAN"  => "Stabsbootsman",
                "RHN"  => "Senior Chief Petty Officer"
            ],
            "E-9"   => [
                "RMA"  => "Sergeant Major",
                "RMMC" => "Sergeant Major",
                "RMN"  => "Master Chief Petty Officer",
                "GSN"  => "Master Chief Petty Officer",
                "IAN"  => "Oberstabsbootsman",
                "RHN"  => "Master Chief Petty Officer"
            ],
            "E-10"  => [
                "RMA"  => "Regimental Sergeant Major",
                "RMMC" => "Regimental Sergeant Major",
                "RMN"  => "Senior Master Chief Petty Officer",
                "GSN"  => "Senior Master Chief Petty Officer",
                "IAN"  => "Oberstabsbootsman der Flotte",
                "RHN"  => "Master Chief Petty Officer of the Navy"
            ],
            "WO-1"  => [
                "RMA"  => "Warrant Officer 1st Class",
                "RMMC" => "Warrant Officer",
                "RMN"  => "Warrant Officer",
                "GSN"  => "Warrant Officer",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "WO-2"  => [
                "RMA"  => "Warrant Officer 2nd Class",
                "RMMC" => "Warrant Officer 1st Class",
                "RMN"  => "Warrant Officer 1st Class",
                "GSN"  => "Chief Warrant Officer",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "WO-3"  => [
                "RMA"  => "Chief Warrant Officer",
                "RMMC" => "Chief Warrant Officer",
                "RMN"  => "Chief Warrant Officer",
                "GSN"  => "Senior Chief Warrant Officer",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "WO-4"  => [
                "RMA"  => "Senior Chief Warrant Officer",
                "RMMC" => "Senior Chief Warrant Officer",
                "RMN"  => "Senior Chief Warrant Officer",
                "GSN"  => "Master Chief Warrant Officer",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "WO-5"  => [
                "RMA"  => "Master Chief Warrant Officer",
                "RMMC" => "Master Chief Warrant Officer",
                "RMN"  => "Master Chief Warrant Officer",
                "GSN"  => "Senior Master Chief Warrant Officer",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "MID"   => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Midshipman",
                "GSN"  => "Midshipman",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "O-1"   => [
                "RMA"  => "Second Lieutenant",
                "RMMC" => "Second Lieutenant",
                "RMN"  => "Ensign",
                "GSN"  => "Ensign",
                "IAN"  => "Leutnant der Sterne",
                "RHN"  => "Ensign"
            ],
            "O-2"   => [
                "RMA"  => "First Lieutenant",
                "RMMC" => "First Lieutenant",
                "RMN"  => "Lieutenant (JG)",
                "GSN"  => "Lieutenant (JG)",
                "IAN"  => "Oberleutnant der Sterne",
                "RHN"  => "Lieutenant (JG)"
            ],
            "O-3"   => [
                "RMA"  => "Captain",
                "RMMC" => "Captain",
                "RMN"  => "Lieutenant (SG)",
                "GSN"  => "Lieutenant (SG)",
                "IAN"  => "Kapitainleutnant",
                "RHN"  => "Lieutenant (SG)"
            ],
            "O-4"   => [
                "RMA"  => "Major",
                "RMMC" => "Major",
                "RMN"  => "Lieutenant Commander",
                "GSN"  => "Lieutenant Commander",
                "IAN"  => "Korvettenkapitain",
                "RHN"  => "Lieutenant Commander"
            ],
            "O-5"   => [
                "RMA"  => "Lieutenant Colonel",
                "RMMC" => "Lieutenant Colonel",
                "RMN"  => "Commander",
                "GSN"  => "Commander",
                "IAN"  => "Fregattenkapitain",
                "RHN"  => "Commander"
            ],
            "O-6"   => [
                "RMA"  => "Colonel",
                "RMMC" => "Colonel",
                "RMN"  => "",
                "GSN"  => "Captain",
                "IAN"  => "Kapitain der Sterne",
                "RHN"  => "Captain"
            ],
            "O-6-A" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Captain (JG)",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "O-6-B" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Captain (SG)",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "F-1"   => [
                "RMA"  => "Brigadier",
                "RMMC" => "Brigadier General",
                "RMN"  => "Commodore",
                "GSN"  => "Commodore",
                "IAN"  => "Flotillenadmiral",
                "RHN"  => "Commodore"
            ],
            "F-2"   => [
                "RMA"  => "Major General",
                "RMMC" => "Major General",
                "RMN"  => "",
                "GSN"  => "Rear Admiral",
                "IAN"  => "Konteradmiral",
                "RHN"  => "Rear Admiral"
            ],
            "F-2-A" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Rear Admiral of the Red",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "F-2-B" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Rear Admiral of the Green",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "F-3"   => [
                "RMA"  => "Lieutenant General",
                "RMMC" => "Lieutenant General",
                "RMN"  => "",
                "GSN"  => "Vice Admiral",
                "IAN"  => "Vizeadmiral",
                "RHN"  => "Vice Admiral"
            ],
            "F-3-A" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Vice Admiral of the Red",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "F-3-B" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Vice Admiral of the Green",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "F-4"   => [
                "RMA"  => "General",
                "RMMC" => "General",
                "RMN"  => "",
                "GSN"  => "Admiral",
                "IAN"  => "Admiral",
                "RHN"  => "Admmiral"
            ],
            "F-4-A" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Admiral of the Red",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "F-4-B" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Admiral of the Green",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "F-5"   => [
                "RMA"  => "Field Marshal",
                "RMMC" => "Field Marshal",
                "RMN"  => "",
                "GSN"  => "High Admiral",
                "IAN"  => "Großadmiral",
                "RHN"  => "Fleet Admiral"
            ],
            "F-5-A" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Fleet Admiral of the Red",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "F-5-B" => [
                "RMA"  => "",
                "RMMC" => "",
                "RMN"  => "Fleet Admiral of the Green",
                "GSN"  => "",
                "IAN"  => "",
                "RHN"  => ""
            ],
            "F-6"   => [
                "RMA"  => "Marshal of the Army",
                "RMMC" => "Marshal of the Corp",
                "RMN"  => "Admiral of the Fleet",
                "GSN"  => "",
                "IAN"  => "Großadmiral der Flotte",
                "RHN"  => ""
            ],
            "C-1"   => [
                "CIVIL" => "Civilian One",
                "INTEL" => "Civilian One",
                "SFS"   => "Junior Ranger"
            ],
            "C-2"   => [
                "CIVIL" => "Civilian Two",
                "INTEL" => "Civilian Two",
                "SFS"   => "Cadet Ranger One"
            ],
            "C-3"   => [
                "CIVIL" => "Civilian Three",
                "INTEL" => "Civilian Three",
                "SFS"   => "Cadet Ranger Two"
            ],
            "C-4"   => [
                "CIVIL" => "Administrator",
                "INTEL" => "Administrator",
                "SFS"   => "Cadet Ranger Three"
            ],
            "C-5"   => [
                "CIVIL" => "Consular Staff",
                "INTEL" => "Probationary Special Agent",
                "SFS"   => "Senior Cadet Ranger"
            ],
            "C-6"   => [
                "CIVIL" => "Consular Agent",
                "INTEL" => "Special Agent",
                "SFS"   => "Ranger"
            ],
            "C-7"   => [
                "CIVIL" => "Embassy Staff",
                "INTEL" => "Foreign Service Officer",
                "SFS"   => "Ranger Sergeant"
            ],
            "C-8"   => [
                "CIVIL" => "Section Chief",
                "INTEL" => "Section Chief",
                "SFS"   => "Ranger Lieutenant"
            ],
            "C-9"   => [
                "CIVIL" => "Consulate Attaché",
                "INTEL" => "Consulate Intelligence Liason",
                "SFS"   => "Ranger Captain"
            ],
            "C-10"  => [
                "CIVIL" => "Vice-consul",
                "INTEL" => "Senior Special Agent",
                "SFS"   => "Ranger Major"
            ],
            "C-11"  => [
                "CIVIL" => "Special Envoy",
                "INTEL" => "Senior Principle Officer",
                "SFS"   => "Ranger Colonel"
            ],
            "C-12"  => [
                "CIVIL" => "Consul",
                "INTEL" => "Chief of Station",
                "SFS"   => "Station Chief Ranger"
            ],
            "C-13"  => [
                "CIVIL" => "Embassy Attaché",
                "INTEL" => "Embassy Intelligence Liaison",
                "SFS"   => "Sector Chief Ranger"
            ],
            "C-14"  => [
                "CIVIL" => "Embassy Senior Attaché",
                "INTEL" => "Embassy Senior Intelligence Liaison",
                "SFS"   => "Planetary Chief Ranger"
            ],
            "C-15"  => [
                "CIVIL" => "Consul General",
                "INTEL" => "Zone Chief",
                "SFS"   => "Head Ranger"
            ],
            "C-16"  => [
                "CIVIL" => "Minister Resident",
                "INTEL" => "Sector Chief"
            ],
            "C-17"  => [
                "CIVIL" => "Envoy Extraordinary and Plenipotentiary",
                "INTEL" => "Regional Director"
            ],
            "C-18"  => [
                "CIVIL" => "Chargé d'affairs",
                "INTEL" => "Deputy Directory of Operations"
            ],
            "C-19"  => [
                "CIVIL" => "Ambassador Extraordinary and Plenipotentiary",
                "INTEL" => "Deputy Director of Intelligence"
            ],
            "C-20"  => [
                "CIVIL" => "Foreign Minister",
                "INTEL" => "Directory of Intelligence"
            ]
        ];

        foreach ( $grades as $grade => $ranks )
        {
            $this->command->comment('Creating ' . $grade);
            $this->writeAuditTrail(
                'db:seed',
                'create',
                'grades',
                null,
                json_encode(["grade" => $grade, "rank" => $ranks]),
                'grade'
            );
            Grade::create( ["grade" => $grade, "rank" => $ranks] );
        }
    }
}