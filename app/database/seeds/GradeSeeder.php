<?php

class GradeSeeder extends Seeder
{
    public function run()
    {
        DB::collection('grades')->delete();

        $grades = array(
        "E1" => array(
            "RMN" => "Spacer 3rd Class",
            "RMMC" => "Private",
            "RMA" => "Private",
            "GSN" => "Spacer 3rd Class",
            "IAN" => "Gerfraiter",
            "RHN" => "Spacer 3rd Class"),
        "E2" => array(
            "RMA" => "Private 1st Class",
            "RMMC" => "Private 1st Class",
            "RMN" => "Spacer 2nd Class",
            "GSN" => "Spacer 2nd Class",
            "IAN" => "Obergefraiter",
            "RHN" => "Spacer 2nd Class"
        ),
        "E3" => array(
            "RMA" => "Lance Corporal",
            "RMMC" => "Lance Corporal",
            "RMN" => "Spacer 1st Class",
            "GSN" => "Spacer 1st Class",
            "IAN" => "Hauptgefraiter",
            "RHN" => "Spacer 1st Class"
        ),
            "E4" => array(
                "RMA" => "Corporal",
                "RMMC" => "Corporal",
                "RMN" => "Petty Officer 3rd Class",
                "GSN" => "Petty Officer 3rd Class",
                "IAN" => "Maat",
                "RHN" => "Petty Officer 3rd Class"
            ),
            "E5" => array(
                "RMA" => "Platoon Sergeant",
                "RMMC" => "Platoon Sergeant",
                "RMN" => "Petty Officer 2nd Class",
                "GSN" => "Petty Officer 2nd Class",
                "IAN" => "Obermaat",
                "RHN" => "Petty Officer 2nd Class"
            ),
            "E6" => array(
                "RMA" => "Staff Sergeant",
                "RMMC" => "Staff Sergeant",
                "RMN" => "Petty Officer 1st Class",
                "GSN" => "Petty Officer 1st Class",
                "IAN" => "Bootsman",
                "RHN" => "Petty Officer 1st Class"
            ),
            "E7" => array(
                "RMA" => "Master Sergeant",
                "RMMC" => "Master Sergeant",
                "RMN" => "Chief Petty Officer",
                "GSN" => "Chief Petty Officer",
                "IAN" => "Oberbootsman",
                "RHN" => "Chief Petty Officer"
            ),
            "E8" => array(
                "RMA" => "First Sergeant",
                "RMMC" => "First Sergeant",
                "RMN" => "Senior Chief Petty Officer",
                "GSN" => "Senior Chief Petty Officer",
                "IAN" => "Stabsbootsman",
                "RHN" => "Senior Chief Petty Officer"
            ),
            "E9" => array(
                "RMA" => "Sergeant Major",
                "RMMC" => "Sergeant Major",
                "RMN" => "Master Chief Petty Officer",
                "GSN" => "Master Chief Petty Officer",
                "IAN" => "Oberstabsbootsman",
                "RHN" => "Master Chief Petty Officer"
            ),
            "E10" => array(
                "RMA" => "Regimental Sergeant Major",
                "RMMC" => "Regimental Sergeant Major",
                "RMN" => "Senior Master Chief Petty Officer",
                "GSN" => "Senior Master Chief Petty Officer",
                "IAN" => "Oberstabsbootsman der Flotte",
                "RHN" => "Master Chief Petty Officer of the Navy"
            ),
            "E10+" => array(
                "RMA" => "",
                "RMMC" => "",
                "RMN" => "Command/Fleet Senior Master Chief",
                "GSN" => "",
                "IAN" => "",
                "RHN" => ""
            ),
            "E11" => array(
                "RMA" => "Command Sergeant Major",
                "RMMC" => "",
                "RMN" => "",
                "GSN" => "",
                "IAN" => "",
                "RHN" => ""
            ),
            "E12" => array(
                "RMA" => "Sergeant Major of the Army",
                "RMMC" => "",
                "RMN" => "",
                "GSN" => "",
                "IAN" => "",
                "RHN" => ""
            ),
            "WO1" => array(
                "RMA" => "Warrant Officer 1st Class",
                "RMMC" => "Warrant Officer",
                "RMN" => "Warrant Officer",
                "GSN" => "Warrant Officer",
                "IAN" => "",
                "RHN" => ""
            ),
            "WO2" => array(
                "RMA" => "Warrant Officer 2nd Class",
                "RMMC" => "Warrant Officer 1st Class",
                "RMN" => "Warrant Officer 1st Class",
                "GSN" => "Chief Warrant Officer",
                "IAN" => "",
                "RHN" => ""
            ),
            "WO3" => array(
                "RMA" => "Chief Warrant Officer",
                "RMMC" => "Chief Warrant Officer",
                "RMN" => "Chief Warrant Officer",
                "GSN" => "Senior Chief Warrant Officer",
                "IAN" => "",
                "RHN" => ""
            ),
            "WO4" => array(
                "RMA" => "Senior Chief Warrant Officer",
                "RMMC" => "Senior Chief Warrant Officer",
                "RMN" => "Senior Chief Warrant Officer",
                "GSN" => "Master Chief Warrant Officer",
                "IAN" => "",
                "RHN" => ""
            ),
            "WO5" => array(
                "RMA" => "Master Chief Warrant Officer",
                "RMMC" => "Master Chief Warrant Officer",
                "RMN" => "Master Chief Warrant Officer",
                "GSN" => "Senior Master Chief Warrant Officer",
                "IAN" => "",
                "RHN" => ""
            ),
            "MID" => array(
                "RMA" => "",
                "RMMC" => "",
                "RMN" => "Midshipman",
                "GSN" => "Midshipman",
                "IAN" => "",
                "RHN" => ""
            ),
            "O1" => array(
                "RMA" => "Second Lieutenant",
                "RMMC" => "Second Lieutenant",
                "RMN" => "Ensign",
                "GSN" => "Ensign",
                "IAN" => "Leutnant der Sterne",
                "RHN" => "Ensign"
            ),
            "O2" => array(
                "RMA" => "First Lieutenant",
                "RMMC" => "First Lieutenant",
                "RMN" => "Lieutenant (JG)",
                "GSN" => "Lieutenant (JG)",
                "IAN" => "Oberleutnant der Sterne",
                "RHN" => "Lieutenant (JG)"
            ),
            "O3" => array(
                "RMA" => "Captain",
                "RMMC" => "Captain",
                "RMN" => "Lieutenant (SG)",
                "GSN" => "Lieutenant (SG)",
                "IAN" => "Kapitainleutnant",
                "RHN" => "Lieutenant (SG)"
            ),
            "O4" => array(
                "RMA" => "Major",
                "RMMC" => "Major",
                "RMN" => "Lieutenant Commander",
                "GSN" => "Lieutenant Commander",
                "IAN" => "Korvettenkapitain",
                "RHN" => "Lieutenant Commander"
            ),
            "O5" => array(
                "RMA" => "Lieutenant Colonel",
                "RMMC" => "Lieutenant Colonel",
                "RMN" => "Commander",
                "GSN" => "Commander",
                "IAN" => "Fregattenkapitain",
                "RHN" => "Commander"
            ),
            "O6" => array(
                "RMA" => "Colonel",
                "RMMC" => "Colonel",
                "RMN" => "",
                "GSN" => "Captain",
                "IAN" => "Kapitain der Sterne",
                "RHN" => "Captain"
            ),
            "O6A" => array(
                "RMA" => "",
                "RMMC" => "",
                "RMN" => "Captain (JG)",
                "GSN" => "",
                "IAN" => "",
                "RHN" => ""
            ),
            "O6B" => array(
                "RMA" => "",
                "RMMC" => "",
                "RMN" => "Captain (SG)",
                "GSN" => "",
                "IAN" => "",
                "RHN" => ""
            ),
            "F1" => array(
                "RMA" => "Brigadier",
                "RMMC" => "Brigadier General",
                "RMN" => "Commodore",
                "GSN" => "Commodore",
                "IAN" => "Flotillenadmiral",
                "RHN" => "Commodore"
            ),
            "F2" => array(
                "RMA" => "Major General",
                "RMMC" => "Major General",
                "RMN" => "Rear Admiral",
                "GSN" => "Rear Admiral",
                "IAN" => "Konteradmiral",
                "RHN" => "Rear Admiral"
            ),
            "F3" => array(
                "RMA" => "Lieutenant General",
                "RMMC" => "Lieutenant General",
                "RMN" => "Vice Admiral",
                "GSN" => "Vice Admiral",
                "IAN" => "Vizeadmiral",
                "RHN" => "Vice Admiral"
            ),
            "F4" => array(
                "RMA" => "General",
                "RMMC" => "General",
                "RMN" => "Admiral",
                "GSN" => "Admiral",
                "IAN" => "Admiral",
                "RHN" => "Admmiral"
            ),
            "F5" => array(
                "RMA" => "Field Marshal",
                "RMMC" => "Field Marshal",
                "RMN" => "Fleet Admiral",
                "GSN" => "High Admiral",
                "IAN" => "Großadmiral",
                "RHN" => "Fleet Admiral"
            ),
            "F6" => array(
                "RMA" => "Marshal of the Army",
                "RMMC" => "Marshal of the Corp",
                "RMN" => "Admiral of the Fleet",
                "GSN" => "",
                "IAN" => "Großadmiral der Flotte",
                "RHN" => ""
            ),
            "C1" => array(
                "CIVIL" => "Civilian One",
                "INTEL" => "Civilian One",
                "SFS" => "Junior Ranger"
            ),
            "C2" => array(
                "CIVIL" => "Civilian Two",
                "INTEL" => "Civilian Two",
                "SFS" => "Cadet Ranger One"
            ),
            "C3" => array(
                "CIVIL" => "Civilian Three",
                "INTEL" => "Civilian Three",
                "SFS" => "Cadet Ranger Two"
            ),
            "C4" => array(
                "CIVIL" => "Administrator",
                "INTEL" => "Administrator",
                "SFS" => "Cadet Ranger Three"
            ),
            "C5" => array(
                "CIVIL" => "Consular Staff",
                "INTEL" => "Probationary Special Agent",
                "SFS" => "Senior Cadet Ranger"
            ),
            "C6" => array(
                "CIVIL" => "Consular Agent",
                "INTEL" => "Special Agent",
                "SFS" => "Ranger"
            ),
            "C7" => array(
                "CIVIL" => "Embassy Staff",
                "INTEL" => "Foreign Service Officer",
                "SFS" => "Ranger Sergeant"
            ),
            "C8" => array(
                "CIVIL" => "Section Chief",
                "INTEL" => "Section Chief",
                "SFS" => "Ranger Lieutenant"
            ),
            "C9" => array(
                "CIVIL" => "Consulate Attaché",
                "INTEL" => "Consulate Intelligence Liason",
                "SFS" => "Ranger Captain"
            ),
            "C10" => array(
                "CIVIL" => "Vice-consul",
                "INTEL" => "Senior Special Agent",
                "SFS" => "Ranger Major"
            ),
            "C11" => array(
                "CIVIL" => "Special Envoy",
                "INTEL" => "Senior Principle Officer",
                "SFS" => "Ranger Colonel"
            ),
            "C12" => array(
                "CIVIL" => "Consul",
                "INTEL" => "Chief of Station",
                "SFS" => "Station Chief Ranger"
            ),
            "C13" => array(
                "CIVIL" => "Embassy Attaché",
                "INTEL" => "Embassy Intelligence Liaison",
                "SFS" => "Sector Chief Ranger"
            ),
            "C14" => array(
                "CIVIL" => "Embassy Senior Attaché",
                "INTEL" => "Embassy Senior Intelligence Liaison",
                "SFS" => "Planetary Chief Ranger"
            ),
            "C15" => array(
                "CIVIL" => "Consul General",
                "INTEL" => "Zone Chief",
                "SFS" => "Head Ranger"
            ),
            "C16" => array(
                "CIVIL" => "Minister Resident",
                "INTEL" => "Sector Chief"
            ),
            "C17" => array(
                "CIVIL" => "Envoy Extraordinary and Plenipotentiary",
                "INTEL" => "Regional Director"
            ),
            "C18" => array(
                "CIVIL" => "Chargé d'affairs",
                "INTEL" => "Deputy Directory of Operations"
            ),
            "C19" => array(
                "CIVIL" => "Ambassador Extraordinary and Plenipotentiary",
                "INTEL" => "Deputy Director of Intelligence"
            ),
            "C20" => array(
                "CIVIL" => "Foreign Minister",
                "INTEL" => "Directory of Intelligence"
            )
        );

        foreach($grades as $grade => $ranks) {
            Grade::create(["grade" => $grade, "rank" => $ranks]);
        }
    }
}
