<?php

class BilletSeeder extends Seeder
{
    use \Medusa\Audit\MedusaAudit;

    public function run()
    {
        DB::collection('billets')->delete();

        $billets = [
            'Special Advisor, RMMC',
            'Aide-de-Camp, MCD',
            'Staff Communications Officer, MCD',
            'Staff Logistics Officer, MCD',
            'Staff Intelligence Officer, MCD',
            'Chief of Staff, MCD',
            'Aide-de-Camp, HA',
            'Staff Communications Officer, HA',
            'Staff Logistics Officer, HA',
            'Staff Intelligence Officer, HA',
            'Chief of Staff, HA',
            'Chief of Staff',
            'Aide-de-Camp, FSL',
            'Staff Communications Officer,FSL',
            'Staff Logistics Officer,FSL',
            'Staff Intelligence Officer,FSL',
            'Chief of Staff, FSL',
            'Community Outreach Liaison - FLA',
            'Judge Advocate General',
            'Judge Advocate General - Ombudsman',
            'Aide-de-Camp, FLA',
            'Staff Communications Officer, FLA',
            'Staff Logistics Officer, FLA',
            'Chief of Staff, FLA',
            'Staff Intelligence Officer, FLA',
            'Sergeant Major, RMA',
            'Sergeant Major, RMMC',
            'OC, Company',
            'Deputy Commandant, RMMC',
            'CO, Talbott Fleet',
            'CO, Torch Fleet',
            'CO,  Andermani Fleet',
            'CO, Sphinx Fleet',
            'CO, Zanzibar Fleet',
            'CO, San Martino Fleet',
            'CO, Gryphon Fleet',
            'CO, Home Fleet',
            'Seventh Space Lord',
            'Sixth Space Lord',
            'Fifth Space Lord',
            'Fourth Space Lord',
            'Third Space Lord',
            'Second Space Lord',
            'Marshal of the Army, RMA',
            'Commandant, Royal Manticoran Marine Corps',
            'High Admiral, GSN',
            'First Space Lord',
            'First Lord of the Admiralty',
            'Chief of Staff, AD',
            'Staff Intelligence Officer, AD',
            'Staff Logistics Officer, AD',
            'Staff Communications Officer, AD',
            'Aide-de-Camp, AD',
            'Chief of Staff, 4SL',
            'Director, Publications, 4SL',
            'Manager, RMN News Bureau, 4SL',
            'Manager, Publications, E-Certs, 4SL',
            'RMN News Bureau Reporter, 4SL',
            'Chief of Staff, 5SL',
            'Director, Membership Processing, 5SL',
            'Manager, Membership Processing, 5SL',
            'Membership Processing, 5SL',
            'Chief of Staff, 7SL',
            'Publications Editor, 7SL',
            'GSN Liaison, 7SL',
            'RMMC Liaison, 7SL',
            'RMA Liaison, 7SL',
            'TRMN Official Mascot',
            'CO, Task Force',
            'CO, Task Group',
            'CO, Squadron',
            'CO, Joint Fleet',
            'CO, Joint Task Force',
            'CO, Joint Task Group',
            'CO, Joint Squadron',
            'CO, Forces Command',
            'CO, Corps',
            'CO, Planetary Command',
            'CO, Force',
            'CO, Division',
            'CO, Brigade',
            'CO, Regiment',
            'CO, Battalion',
            'CO, Company',
            'CO, Platoon',
            'CO, Squad',
            'CO, Section',
            'OC, Planetary Command',
            'OC, Fort',
            'OC, Outpost',
            'OC, Platoon',
            'OC, Regiment',
            'OC, Battalion',
            'Commanding Officer',
            'Executive Officer',
            'Bosun',
            'Yeoman',
            'Chief Security Officer',
            'Chief Engineering Officer',
            'Chief Weapons Officer',
            'Chief Communications Officer',
            'Chief Astrogation Officer',
            'Chief EW Officer',
            'Chief Medical Officer',
            'Sailing Master',
            'Security Officer',
            'Engineering Officer',
            'Communications Officer',
            'Astrogation Officer',
            'EW Officer',
            'Medical Officer',
            'Security Technician',
            'Engineering Technician',
            'Communications Technician',
            'Helmsman',
            'Sick Berth Attendant',
            'Small Craft Pilot',
            'Chaplain',
            'Midshipman',
            'Civilian One',
            'CO, Basilisk Fleet',
            'CO, Grayson Fleet',
            'Civilian Two',
            'Civilian Three',
            'Administrator',
            'Probationar Special Agent',
            'Section Chief',
            'Chargé d\'affaires',
            'Special Agent',
            'Foreign Service Officer',
            'Minister Resident',
            'Consular Staff',
            'Senior Special Agent',
            'Consul',
            'Embassy/Consulate Attache',
            'Senior Principle Officer',
            'Special Envoy',
            'Consul-General',
            'Envoy Extraordinary and Plenipotentiary',
            'Chief of Station',
            'Ambassador Extraordinary and Plenipotentiary',
            'Crewman',
            'Sr. MP Associate, 5SL',
            'Marine',
            'Soldier',
            'Chief of Staff, RMA',
            'OC, Regimental Combat Team',
            'OC, Theater Command',
            'OC, Battlegroup',
            'OC, ODCSOPS',
            'OC, ODCSPER',
            'OC, ODCSLOG',
            'OC, ODCSINTEL',
            'OC, ODCSTRA',
            'Senior Staff, ODCSOPS',
            'Senior Staff, ODCSPER',
            'Senior Staff, ODCSLOG',
            'Senior Staff, ODCSINTEL',
            'Senior Staff, ODCSTRA',
            'Staff, ODCSINTEL',
            'Staff, ODCSLOG',
            'Staff, ODCSOPS',
            'Staff, ODCSPER',
            'Staff, ODCSTRA',
            'NCO, Bivouac',
            'NCO, Barracks',
            'NCO, Outpost',
            'NCO, Fort',
            'NCO, Fireteam',
            'NCO, Squad',
            'NCO, Platoon',
            'NCO, Company',
            'NCO, Battalion',
            'NCO, Regiment',
            'NCO, Regimental Combat Team',
            'NCO, Battlegroup',
            'NCO, Planetary Command',
            'NCO, Theater Command',
            'Head, College of Arms',
            'Commissioner, Sphinxian Forresty Commission',
            'Staff Liaison, FLA',
            'BuNine',
            'FLA\'s SITS Bitch',
            'Chief of Staff, 2SL',
            'Department Head',
            'Division Officer',
            'XO, Company',
            'Steward',
            'OC, Company (HG)',
            'Flag Lt- 7SL',
            'Regional Director - 7SL',
            'Personnelman',
            'Steward',
            'Coxswain',
            'Plotting Specialist',
            'Fire Control Technician',
            'Electronic Warfare Technician',
            'Data System Technician',
            'Electronics Technician',
            'Impeller Technician',
            'Power Technician',
            'Gravitics Technician',
            'Environmental Technician',
            'Hydroponics Technician',
            'Damage Control Technician',
            'Storekeeper',
            'Disbursing Clerk',
            'Ship\'s Serviceman',
            'Corpsman',
            'Operations Specialist',
            'Intelligence Specialist',
            'Missile Technician',
            'Beam Weapons Technician',
            'Master-at-Arms',
            'Sensor Technician',
            'Armorer',
            'Military Police',
            'Missile Crew',
            'Laser/Graser Crew',
            'Assault Marine',
            'Recon Marine',
            'Rifleman',
            'Heavy Weapons',
            'Admin Specialist',
            'Embassy Guard',
            'Deputy Sixth Space Lord',
            'Chief of Staff, 6SL',
            'Yeoman - 6SL',
            'Graphic Artist (6SL)',
            'Director of Publications (6SL)',
            'Publications Yeoman for Manuals (6SL)',
            'Publications Yeoman for Newsletters (6SL)',
            'Instructor/Researcher for Course Development (6SL)',
            'Instructor/Researcher for Course Development (6SL)',
            'Yeoman for Course Development (6SL)',
            'Grayson Liaison (6SL)',
            'Provost Marshal (6SL)',
            'Deputy Provost (6SL)',
            'Dean, Landing University',
            'LU, Core Instructor',
            'LU, King\'s College Instructor',
            'LU, Queen\'s College Instructor',
            'Commissioner, Sphinx Forestry Service',
            'Board Member, RMN Bureau of Training',
            'Commandant, Saganami Island Academy',
            'Chief of Staff, SIA',
            'Administrative Officer, SIA',
            'Commandant, Remote Testing Institute',
            'Chief Instructor, RTI',
            'Assistant Instructor, RTI',
            'Kommondant, Prinz-Adalbert-Andermani Marineakademie',
            'Instructor, PAAM',
            'Commandant, RMMC Academy',
            'Instructor, RMMCA',
            'Commandant, Merchant Fleet Academy ',
            'Instructor, MFA',
            'Commandant, Astro-Control Service Academy ',
            'Instructor, ACS',
            'Commanding Officer, SIA Enlisted Training Center',
            'Commandant, Saganami War College',
            'Commandant, SIA Advanced Tactical Center',
            'Commanding Officer, SIA Technical Specialties Center',
            'Chief of Staff, TSC',
            'Instructor, SIA',
            'Instructor, TSC',
            'Department Chair, SIA',
            'Department Head, SIA',
            'Commandant, King Roger I Military Academy',
            'Instructor, KRMA',
            'Commandant, Isaiah MacKenzie Naval Academy*',
            'Vice Commandant, IMNA',
            'S1 Personnel, IMNA',
            'S2 Intelligence, IMNA',
            'IMNA Liaison to Saganami Island Academy',
            'IMNA Liaison to King Roger I Military Academy',
            'IMNA Liaison to Prinz-Adalbert-Andermani Marineakademie',
            'S3 Operations, IMNA',
            'S5 Planning and Strategy, IMNA',
            'S6 Communications, IMNA',
            'Commanding Officer, IMNA Enlisted Training Center',
            'Instructor, IMNA',
            'Commanding Officer, IMNA Officer Training Center',
            'Commandant, IMNA War College',
            'Commanding Officer, IMNA Technical Specialties Center',
            'Department Chair, IMNA',
            'MarDet CO',
            'MarDet XO',
            'MarDet Senior NCO',
            'Chief Steward',
            'Dean of Stewards',
            'Director of Web Services, 4SL',
            'First Fleet Staff Operations Officer',
            'Chief of Staff, 3SL',
            'Command Senior Master Chief of BuTrain',
            'First Fleet Staff Logistics Officer',
            'First Fleet Flag Lieutenant',
        ];

        foreach ($billets as $billet) {
            $this->command->comment('Adding '.$billet);
            $this->writeAuditTrail('db:seed', 'create', 'billets', null, json_encode(['billet_name' => $billet]), 'billet');
            Billet::create(['billet_name' => $billet]);
        }
    }
}
