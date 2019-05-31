<?php

use Illuminate\Database\Migrations\Migration;

class AddExamList extends Migration
{
    use \App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $exams = [
            'IMNA-AFLTC-01'  => 'An Introduction to Light Attack Craft Exam ',
            'IMNA-AFLTC-33A' => 'Basic Fission Power Technician Exam ',
            'IMNA-AFLTC-33C' => ' Master Fission Power Technician Exam ',
            'IMNA-AFLTC-33D' => ' Fission Power Officer Exam ',
            'IMNA-AFLTC-33M' => ' Senior Fission Power Technician Exam ',
            'IMNA-AFLTC-33W' => 'Fission Power Warrant Exam ',
            'IMNA-GSN-0001'  => 'Basic Enlisted Exam ',
            'IMNA-GSN-0002'  => 'Basic NCO Exam ',
            'IMNA-GSN-0003'  => 'Advanced NCO Exam ',
            'IMNA-GSN-0004'  => 'Senior CPO Exam ',
            'IMNA-GSN-0005'  => 'Master CPO Exam ',
            'IMNA-GSN-0006'  => 'SMCPO Exam ',
            'IMNA-GSN-0011'  => 'Basic Warrant Exam ',
            'IMNA-GSN-0012'  => 'Senior Chief Warrant Exam ',
            'IMNA-GSN-0013'  => 'Senior Master Chief Warrant Exam ',
            'IMNA-GSN-0100'  => 'Midshipman Exam ',
            'IMNA-GSN-0101'  => 'Ensign Exam ',
            'IMNA-GSN-0102'  => 'Lieutenant (JG) Exam ',
            'IMNA-GSN-0103'  => 'Lieutenant (SG) Exam ',
            'IMNA-GSN-0104'  => 'Lieutenant Commander Exam ',
            'IMNA-GSN-0105'  => 'Commander Exam ',
            'IMNA-GSN-0106'  => 'Captain Exam ',
            'IMNA-GSN-1001'  => 'Commodore Exam ',
            'IMNA-GSN-1002'  => 'Rear Admiral Exam ',
            'IMNA-GSN-1003'  => 'Vice Admiral Exam ',
            'IMNA-GSN-1004'  => 'Admiral Exam ',
            'IMNA-GTSC-10C'  => 'Tactical Senior Chief Exam ',
            'IMNA-GTSC-10D'  => 'Tactical Department Head Exam ',
            'IMNA-GTSC-11A'  => 'Basic Fire Control Specialist Exam ',
            'IMNA-GTSC-11C'  => 'Master Fire Control Specialist Exam ',
            'IMNA-GTSC-11D'  => 'Fire Control Officer Exam ',
            'IMNA-GTSC-11M'  => 'Senior Fire Control Specialist Exam ',
            'IMNA-GTSC-11W'  => 'Fire Control Warrant Exam ',
            'IMNA-GTSC-12A'  => 'Basic Tracking Specialist Exam ',
            'IMNA-GTSC-12C'  => 'Master Tracking Specialist Exam ',
            'IMNA-GTSC-12D'  => 'Tracking Officer Exam ',
            'IMNA-GTSC-12M'  => 'Senior Tracking Specialist Exam ',
            'IMNA-GTSC-12W'  => 'Tracking Warrant Exam ',
            'IMNA-GTSC-13A'  => 'Basic Electronic Warfare Technician Exam ',
            'IMNA-GTSC-13C'  => 'Master Electronic Warfare Technician Exam ',
            'IMNA-GTSC-13D'  => 'Electronic Warfare Officer Exam ',
            'IMNA-GTSC-13M'  => 'Senior Electronic Warfare Technician Exam ',
            'IMNA-GTSC-13W'  => 'Electronic Warfare Warrant Exam ',
            'IMNA-GTSC-141A' => 'Basic Beam Weapons Specialist Exam ',
            'IMNA-GTSC-141M' => 'Senior Beam Weapons Specialist Exam ',
            'IMNA-GTSC-142A' => 'Basic Missile Weapons Specialist Exam ',
            'IMNA-GTSC-142M' => 'Senior Missile Weapons Specialist Exam ',
            'IMNA-GTSC-14C'  => 'Gunnery Chief Exam ',
            'IMNA-GTSC-14D'  => 'Gunnery Officer Exam ',
            'IMNA-GTSC-14W'  => 'Gunnery Warrant Exam ',
            'IMNA-GTSC-17D'  => 'Naval Chaplain Exam ',
            'IMNA-GTSC-20C'  => 'Operations Senior Chief Exam ',
            'IMNA-GTSC-20D'  => 'Operations Department Head Exam ',
            'IMNA-GTSC-21A'  => 'Basic Operations Specialist Exam ',
            'IMNA-GTSC-21C'  => 'Master Operations Specialist Exam ',
            'IMNA-GTSC-21D'  => 'Operations Officer Exam ',
            'IMNA-GTSC-21M'  => 'Senior Operations Specialist Exam ',
            'IMNA-GTSC-21W'  => 'Operations Warrant Exam ',
            'IMNA-GTSC-22A'  => 'Basic Intelligence Specialist Exam ',
            'IMNA-GTSC-22C'  => 'Master Intelligence Specialist Exam ',
            'IMNA-GTSC-22D'  => 'Intelligence Officer Exam ',
            'IMNA-GTSC-22M'  => 'Senior Intelligence Specialist Exam ',
            'IMNA-GTSC-22W'  => 'Intelligence Warrant Exam ',
            'IMNA-GTSC-23A'  => 'Basic Data Systems Technician Exam ',
            'IMNA-GTSC-23C'  => 'Master Data Systems Technician Exam ',
            'IMNA-GTSC-23D'  => 'Data Systems Officer Exam ',
            'IMNA-GTSC-23M'  => 'Senior Data Systems Technician Exam ',
            'IMNA-GTSC-23W'  => 'Data Systems Warrant Exam ',
            'IMNA-GTSC-24A'  => 'Basic Electronics Technician Exam ',
            'IMNA-GTSC-24C'  => 'Master Electronics Technician Exam ',
            'IMNA-GTSC-24D'  => 'Electronics Officer Exam ',
            'IMNA-GTSC-24M'  => 'Senior Electronics Technician Exam ',
            'IMNA-GTSC-24W'  => 'Electronics Warrant Exam ',
            'IMNA-GTSC-25A'  => 'Basic Communications Specialist Exam ',
            'IMNA-GTSC-25C'  => 'Master Communications Specialist Exam ',
            'IMNA-GTSC-25D'  => 'Communications Officer Exam ',
            'IMNA-GTSC-25M'  => 'Senior Communications Specialist Exam ',
            'IMNA-GTSC-25W'  => 'Communications Warrant Exam ',
            'IMNA-GTSC-30C'  => 'Engineering Senior Chief Exam ',
            'IMNA-GTSC-30D'  => 'Engineering Department Head Exam ',
            'IMNA-GTSC-31A'  => 'Basic Impeller Technician Exam ',
            'IMNA-GTSC-31C'  => 'Master Impeller Technician Exam ',
            'IMNA-GTSC-31D'  => 'Impeller Officer Exam ',
            'IMNA-GTSC-31M'  => 'Senior Impeller Technician Exam ',
            'IMNA-GTSC-31W'  => 'Impeller Warrant Exam ',
            'IMNA-GTSC-32A'  => 'Basic Gravitics Technician Exam ',
            'IMNA-GTSC-32C'  => 'Master Gravitcis Technician Exam ',
            'IMNA-GTSC-32D'  => 'Gravitics Officer Exam ',
            'IMNA-GTSC-32M'  => 'Senior Gravitics Technician Exam ',
            'IMNA-GTSC-32W'  => 'Gravitics Warrant Exam ',
            'IMNA-GTSC-33A'  => 'Basic Fusion Power Technician Exam ',
            'IMNA-GTSC-33C'  => 'Master Fusion Power Technician Exam ',
            'IMNA-GTSC-33D'  => 'Fusion Room Officer Exam ',
            'IMNA-GTSC-33M'  => 'Senior Fusion Power Technician Exam ',
            'IMNA-GTSC-33W'  => 'Fusion Room Warrant Exam ',
            'IMNA-GTSC-34A'  => 'Basic Damage Control Technician Exam ',
            'IMNA-GTSC-34C'  => 'Master Damage Control Technician Exam ',
            'IMNA-GTSC-34D'  => 'Damage Control Officer Exam ',
            'IMNA-GTSC-34M'  => 'Senior Damage Control Technician Exam ',
            'IMNA-GTSC-34W'  => 'Damage Control Warrant Exam ',
            'IMNA-GTSC-35A'  => 'Basic Life Support Technician Exam ',
            'IMNA-GTSC-35C'  => 'Master Life Support Technician Exam ',
            'IMNA-GTSC-35D'  => 'Life Support Officer Exam ',
            'IMNA-GTSC-35M'  => 'Senior Life Support Technician Exam ',
            'IMNA-GTSC-35W'  => 'Life Support Warrant Exam ',
            'IMNA-GTSC-36A'  => 'Basic Sensor Technician Exam ',
            'IMNA-GTSC-36C'  => 'Master Sensor Technician Exam ',
            'IMNA-GTSC-36D'  => 'Sensor Officer Exam ',
            'IMNA-GTSC-36M'  => 'Senior Sensor Technician Exam ',
            'IMNA-GTSC-36W'  => 'Sensor Warrant Exam ',
            'IMNA-GTSC-40C'  => 'Astrogation Senior Chief Exam ',
            'IMNA-GTSC-40D'  => 'Astrogation Department Head Exam ',
            'IMNA-GTSC-41A'  => 'Quartermaster\'s Assistant Exam ',
            'IMNA-GTSC-41C'  => 'Quartermaster\'s Mate Exam ',
            'IMNA-GTSC-41D'  => 'Helm Officer Exam ',
            'IMNA-GTSC-41M'  => 'Senior Quartermaster\'s Assistant Exam ',
            'IMNA-GTSC-41W'  => 'Quartermaster Warrant Exam ',
            'IMNA-GTSC-42A'  => 'Saling Master\'s Assistant Exam ',
            'IMNA-GTSC-42C'  => 'Sailing Master\'s Mate Exam ',
            'IMNA-GTSC-42D'  => 'Sailing Master Exam ',
            'IMNA-GTSC-42M'  => 'Senior Sailing Master\'s Assistant Exam ',
            'IMNA-GTSC-42W'  => 'Sailing Master Warrant Exam ',
            'IMNA-GTSC-43A'  => 'Basic Coxswain Exam ',
            'IMNA-GTSC-43C'  => 'Master Coxswain Exam ',
            'IMNA-GTSC-43D'  => 'Flight Operations Officer Exam ',
            'IMNA-GTSC-43M'  => 'Senior Coxswain Exam ',
            'IMNA-GTSC-43W'  => 'Flight Operations Warrant Exam ',
            'IMNA-GTSC-50C'  => 'Support Senior Chief Exam ',
            'IMNA-GTSC-50D'  => 'Support Department Head Exam ',
            'IMNA-GTSC-511C' => 'Galley Captain Exam ',
            'IMNA-GTSC-511M' => 'Cook Exam ',
            'IMNA-GTSC-512C' => 'Senior Steward Exam ',
            'IMNA-GTSC-512M' => 'Steward Exam ',
            'IMNA-GTSC-51A'  => 'Assistant Cook Exam ',
            'IMNA-GTSC-51D'  => 'Mess Officer Exam ',
            'IMNA-GTSC-51W'  => 'Steward Warrant Exam ',
            'IMNA-GTSC-52A'  => 'Basic Storekeeper Exam ',
            'IMNA-GTSC-52C'  => 'Master Storekeeper Exam ',
            'IMNA-GTSC-52D'  => 'Logistics Officer Exam ',
            'IMNA-GTSC-52M'  => 'Senior Storekeeper Exam ',
            'IMNA-GTSC-52W'  => 'Logistics Warrant Exam ',
            'IMNA-GTSC-53A'  => 'Basic Ship_s Servicemember Exam ',
            'IMNA-GTSC-53C'  => 'Master Ship_s Servicemember Exam ',
            'IMNA-GTSC-53D'  => 'Ship_s Service Officer Exam ',
            'IMNA-GTSC-53M'  => 'Senior Ship_s Servicemember Exam ',
            'IMNA-GTSC-53W'  => 'Ship_s Service Warrant Exam ',
            'IMNA-GTSC-54A'  => 'Basic Yeoman Exam ',
            'IMNA-GTSC-54C'  => 'Master Yeoman Exam ',
            'IMNA-GTSC-54D'  => 'Personnel Officer Exam ',
            'IMNA-GTSC-54M'  => 'Senior Yeoman Exam ',
            'IMNA-GTSC-54W'  => 'Personnel Warrant Exam ',
            'IMNA-GTSC-55A'  => 'Sick Berth Attendant Exam ',
            'IMNA-GTSC-55C'  => 'Master Sick Berth Attendant Exam ',
            'IMNA-GTSC-55D'  => 'Medical Officer Exam ',
            'IMNA-GTSC-55M'  => 'Senior Sick Berth Attendant Exam ',
            'IMNA-GTSC-55W'  => 'Physician\'s Assistant Exam ',
            'IMNA-GTSC-56C'  => 'Chaplain\'s Assistant Exam ',
            'IMNA-GTSC-57C'  => 'Paralegal Exam ',
            'IMNA-GTSC-57D'  => 'Legal Officer Exam ',
            'IMNA-STC-0001A' => 'Basic Armsman Exam ',
            'IMNA-STC-0001C' => 'Master Armsman Exam ',
            'IMNA-STC-0001D' => 'Armsman Officer Exam ',
            'IMNA-STC-0001M' => 'Senior Armsman Exam ',
            'IMNA-STC-0002A' => 'Layperson Exam ',
            'IMNA-STC-0002B' => 'Jurist Exam ',
            'IMNA-STC-0002C' => 'Advanced Layperson Exam ',
            'IMNA-STC-0002D' => 'Brother Exam ',
            'IMNA-STC-0101'  => 'Introduction to Management Exam ',
            'IMNA-STC-0102'  => 'Introduction to Leadership Exam ',
            'IMNA-STC-0103'  => 'Non-Violent Communication Exam ',
            'IMNA-STC-0104'  => 'Military & Diplomatic Etiquette Exam ',
            'IMNA-STC-0201'  => 'Bosun Exam ',
            'IMNA-STC-0202'  => 'COLAC Exam ',
            'IMNA-STC-0203'  => 'Executive Officer Exam ',
            'IMNA-STC-0204'  => 'Commanding Officer Exam ',
            'IMNA-STC-0205'  => 'Chaplain Officer Exam ',
            'KR1MA-RMA-0001' => 'Basic Training Exam ',
            'KR1MA-RMA-0002' => 'Secondary Training Exam ',
            'KR1MA-RMA-0003' => 'Advanced Training Exam ',
            'KR1MA-RMA-0004' => 'NCO Basic Training Exam ',
            'KR1MA-RMA-0005' => 'NCO Secondary Training Exam ',
            'KR1MA-RMA-0006' => 'NCO Advanced Training Exam ',
            'KR1MA-RMA-0007' => 'NCO Senior Training Exam ',
            'KR1MA-RMA-0008' => 'NCO Senior Command Training Exam ',
            'KR1MA-RMA-0011' => 'Basic Warrant Exam ',
            'KR1MA-RMA-0012' => 'Chief Warrant Exam ',
            'KR1MA-RMA-0013' => 'Senior Chief Warrant Exam ',
            'KR1MA-RMA-0014' => 'Master Chief Warrant Exam ',
            'KR1MA-RMA-0101' => 'Basic Officer Training Exam ',
            'KR1MA-RMA-0102' => 'Secondary Officer Training Exam ',
            'KR1MA-RMA-0103' => 'Advanced Officer Training Exam ',
            'KR1MA-RMA-0104' => 'Field Officer Training Exam ',
            'KR1MA-RMA-0105' => 'Senior Officer Training Exam ',
            'KR1MA-RMA-0106' => 'Senior Command Officer Training Exam ',
            'KR1MA-RMA-1001' => 'Brigadier Exam ',
            'KR1MA-RMA-1002' => 'Major General Exam ',
            'KR1MA-RMA-1003' => 'Lieutenant General Exam ',
            'KR1MA-RMA-1004' => 'General Exam ',
            'KR1MA-RMA-1005' => 'Field Marshall Exam ',
            'KR1MA-RMA-2001' => 'Administration Exam ',
            'KR1MA-RMA-2002' => 'Large Unit Tactics Exam ',
            'KR1MA-RMA-2003' => 'Advanced Leadership Exam ',
            'KR1MA-RMAT-01A' => 'Basic Armorer Exam ',
            'KR1MA-RMAT-01B' => 'Advanced Armorer Exam ',
            'KR1MA-RMAT-02A' => 'Basic Military Police Exam ',
            'KR1MA-RMAT-02B' => 'Advanced Military Police Exam ',
            'KR1MA-RMAT-03A' => 'Basic Tank Crewman Exam ',
            'KR1MA-RMAT-03B' => 'Advanced Tank Crewman Exam ',
            'KR1MA-RMAT-04A' => 'Basic Reconnaissance Specialist Exam ',
            'KR1MA-RMAT-04B' => 'Advanced Reconnaissance Specialist Exam ',
            'KR1MA-RMAT-05A' => 'Basic Stingship Pilot Exam ',
            'KR1MA-RMAT-05B' => 'Advanced Stingship Pilot Exam ',
            'KR1MA-RMAT-06A' => 'Basic Indirect Fire Specialist Exam ',
            'KR1MA-RMAT-06B' => 'Advanced Indirect Fire Specialist Exam ',
            'KR1MA-RMAT-07A' => 'Basic Administrative Specialist Exam ',
            'KR1MA-RMAT-07B' => 'Advanced Administrative Specialist Exam ',
            'KR1MA-RMAT-08A' => 'Basic Infantryman Exam ',
            'KR1MA-RMAT-08B' => 'Advanced Infantryman Exam ',
            'KR1MA-RMAT-09A' => 'Basic Skimmer Crewman Exam ',
            'KR1MA-RMAT-09B' => 'Advanced Skimmer Crewman Exam ',
            'KR1MA-RMAT-10A' => 'Basic Cargo Pilot Exam ',
            'KR1MA-RMAT-10B' => 'Advanced Cargo Pilot Exam ',
            'KR1MA-RMAT-11A' => 'Basic Air Defense Specialist Exam ',
            'KR1MA-RMAT-11B' => 'Advanced Air Defense Specialist Exam ',
            'KR1MA-RMAT-12A' => 'Basic Orbital Defense Specialist Exam ',
            'KR1MA-RMAT-12B' => 'Advanced Orbital Defense Specialist Exam ',
            'KR1MA-RMAT-13A' => 'Basic Combat Engineer Exam ',
            'KR1MA-RMAT-13B' => 'Advanced Combat Engineer Exam ',
            'KR1MA-RMAT-14A' => 'Advanced Assault Specialist Exam ',
            'KR1MA-RMAT-14A' => 'Basic Assault Specialist Exam ',
            'KR1MA-RMAT-15A' => 'Basic Military Criminal Investigator Specialist Exam ',
            'KR1MA-RMAT-15B' => 'Advanced Military Criminal Investigator Specialist Exam ',
            'KR1MA-RMAT-16A' => 'Basic Lawyer Advocate Exam ',
            'KR1MA-RMAT-16B' => 'Advanced Lawyer Advocate Exam ',
            'KR1MA-RMAT-17A' => 'Basic Logistics Specialist Exam ',
            'KR1MA-RMAT-17B' => 'Advanced Logistics Specialist Exam ',
            'KR1MA-RMAT-18A' => 'Basic Finance Specialist Exam ',
            'KR1MA-RMAT-18B' => 'Advanced Finance Specialist Exam ',
            'KR1MA-RMAT-19A' => 'Basic Medical Specialist Exam ',
            'KR1MA-RMAT-19B' => 'Advanced Medical Specialist Exam ',
            'KR1MA-RMAT-20'  => 'Hospital Corpsman (ASI "A") Exam ',
            'KR1MA-RMAT-21'  => 'Pharmacist (ASI "B") Exam ',
            'KR1MA-RMAT-22'  => 'Physiotherapist (ASI "C") Exam ',
            'KR1MA-RMAT-23A' => 'Environmental Health Technician (ASI "D") Exam ',
            'KR1MA-RMAT-23B' => 'Environmental Health Officer Exam ',
            'KR1MA-RMAT-24A' => 'Medical Support Technician (ASI "F") Exam ',
            'KR1MA-RMAT-24B' => 'Medical Support Officer Exam ',
            'KR1MA-RMAT-25'  => 'Radiographer Exam (ASI "G") ',
            'KR1MA-RMAT-26'  => 'Operationg Department Practitioner Exam (ASI "H") ',
            'KR1MA-RMAT-27A' => 'Nurse Exam (ASI "I") ',
            'KR1MA-RMAT-27B' => 'Senior Nurse Exam ',
            'KR1MA-RMAT-28A' => 'Medical Officer ',
            'KR1MA-RMAT-28B' => 'Senior Medical Officer ',
            'KR1MA-RMAT-30'  => 'Aviation Entrance Exam ',
            'KR1MA-RMAT-31'  => 'Basic Flight Exam ',
            'KR1MA-RMAT-32'  => 'Intermediate Flight Exam ',
            'KR1MA-RMAT-33'  => 'Advanced Flight Exam ',
            'LU-Core-01'     => 'Civilian One',
            'LU-Core-02'     => 'Civilian Two',
            'LU-Core-03'     => 'Civilian Three',
            'LU-Core-04'     => 'Administration',
            'LU-KC-0005'     => 'Probationary Special Agent',
            'LU-KC-0006'     => 'Special Agent',
            'LU-KC-0011'     => 'Foreign Service Officer',
            'LU-KC-0012'     => 'Section Chief',
            'LU-KC-0013'     => 'Embassy Intelligence Liaison',
            'LU-KC-0101'     => 'Senior Special Agent',
            'LU-KC-0102'     => 'Senior Principle Officer',
            'LU-KC-0103'     => 'Chief of Station',
            'LU-KC-0104'     => 'Embassy Senior Intelligence Liaison',
            'LU-KC-0105'     => 'Zone Chief',
            'LU-KC-0113'     => 'Embassy Intelligence Liaison',
            'LU-KC-0115'     => 'Sector Chief',
            'LU-KC-1001'     => 'Regional Director',
            'LU-KC-1002'     => 'Deputy Director of Operations',
            'LU-KC-1003'     => 'Deputy Director of Intelligence',
            'LU-KC-1004'     => 'Director of Intelligence',
            'LU-QC-0005'     => 'Consular Staff',
            'LU-QC-0006'     => 'Consular Agent',
            'LU-QC-0011'     => 'Embassy Staff',
            'LU-QC-0012'     => 'Section Chief',
            'LU-QC-0013'     => 'Consulate Attach&eacute;',
            'LU-QC-0101'     => 'Vice-consul',
            'LU-QC-0102'     => 'Special Envoy',
            'LU-QC-0103'     => 'Consul Chief',
            'LU-QC-0104'     => 'Embassy Senior Attach&eacute;',
            'LU-QC-0105'     => 'Consul General',
            'LU-QC-0113'     => 'Embassy Attach&eacute;',
            'LU-QC-0115'     => 'Minister Resident',
            'LU-QC-1001'     => 'Envoy Extraordinary and Plenipotentiary',
            'LU-QC-1002'     => 'Charg&eacute; d\'affairs',
            'LU-QC-1003'     => 'Ambassador Extraordinary and Plenipotentiary',
            'LU-QC-1004'     => 'Foreign Minister',
            'SIA-RMMC-0001'  => 'Basic Enlisted (E1)',
            'SIA-RMMC-0002'  => 'Basic NonCom (E4)',
            'SIA-RMMC-0003'  => 'Advanced NonCom (E6)',
            'SIA-RMMC-0004'  => 'First Sergeant (E8)',
            'SIA-RMMC-0005'  => 'Sergeant Major (E9)',
            'SIA-RMMC-0006'  => 'Regimental Sergeant Major (E10)',
            'SIA-RMMC-0007'  => 'RMN Officer Conversion Course',
            'SIA-RMMC-0011'  => 'Basic Warrant (WO1)',
            'SIA-RMMC-0012'  => 'Chief Warrant (WO3)',
            'SIA-RMMC-0013'  => 'Master Chief Warrant (WO5)',
            'SIA-RMMC-0101'  => '2nd Lieutenant Exam',
            'SIA-RMMC-0102'  => '1st Lieutenant Exam',
            'SIA-RMMC-0103'  => 'Captain RMMC Exam',
            'SIA-RMMC-0104'  => 'Major Exam',
            'SIA-RMMC-0105'  => 'Lt Colonel Exam',
            'SIA-RMMC-0106'  => 'Colonel Exam',
            'SIA-RMMC-0113'  => 'Intro to Mgmt Exam',
            'SIA-RMMC-0115'  => 'Intro to Leadership Exam',
            'SIA-RMMC-1001'  => 'Colonel (List) Exam',
            'SIA-RMMC-1002'  => 'Large Unit Tactics Exam',
            'SIA-RMMC-1003'  => 'Military Administration Exam',
            'SIA-RMMC-1004'  => 'Advanced Leadership Exam',
            'SIA-RMMC-G-A'   => 'GSO - Basic',
            'SIA-RMMC-G-B'   => 'GSO - Advanced',
            'SIA-RMMC-G-C'   => 'GSO - Expert',
            'SIA-RMMC-JTF-A' => 'JTFSO - Basic',
            'SIA-RMMC-JTF-B' => 'JTFSO - Advanced',
            'SIA-RMMC-JTF-C' => 'JTFSO - Expert',
            'SIA-RMMC-S-A'   => 'Staff Officer - Basic',
            'SIA-RMMC-S-B'   => 'Staff Officer - Advanced',
            'SIA-RMMC-S-C'   => 'Staff Officer - Expert',
            'SIA-RMN-0001'   => 'Basic Enlisted Exam',
            'SIA-RMN-0002'   => 'Basic Non-Comm Exam',
            'SIA-RMN-0003'   => 'Advanced Non-Comm Exam',
            'SIA-RMN-0004'   => 'SCPO Exam',
            'SIA-RMN-0005'   => 'MCPO Exam',
            'SIA-RMN-0006'   => 'SMCPO Exam',
            'SIA-RMN-0011'   => 'Basic Warrant Exam',
            'SIA-RMN-0012'   => 'Chief Warrant Exam',
            'SIA-RMN-0013'   => 'Master Chief Warrant Exam',
            'SIA-RMN-0101'   => 'Ensign Exam',
            'SIA-RMN-0102'   => 'Lieutenant (JG) Exam',
            'SIA-RMN-0103'   => 'Lieutenant Exam',
            'SIA-RMN-0104'   => 'Lt. Commander Exam',
            'SIA-RMN-0105'   => 'Commander Exam',
            'SIA-RMN-0106'   => 'Captain (JG) Exam',
            'SIA-RMN-0113'   => 'Intro to Management Exam',
            'SIA-RMN-0115'   => 'Intro to Leadership Exam',
            'SIA-RMN-1001'   => 'Captain (List) Exam',
            'SIA-RMN-1002'   => 'Large Fleet Tactics Exam',
            'SIA-RMN-1003'   => 'Military Administration Exam',
            'SIA-RMN-1004'   => 'Advanced Leadership Exam',
            'SIA-RMN-1005'   => 'Tactical Simulator Course',
            'SIA-SFC-0101'   => 'Reading',
            'SIA-SFC-0102'   => 'Language and Communication',
            'SIA-SFC-0103'   => 'Astronomy',
            'SIA-SFC-0104'   => 'Environmental Studies',
            'SIA-SFC-0105'   => 'Military History',
            'SIA-SFC-0106'   => 'Technology',
            'SIA-SFC-0107'   => 'Transportation',
            'SIA-SFC-0108'   => 'Zoology',
            'SIA-SFC-0201'   => 'Environmental Studies',
            'SIA-SFC-0202'   => 'Military History',
            'SIA-SFC-0203'   => 'Transportation',
            'SIA-SFC-0204'   => 'Zoology',
            'SIA-SFC-0301'   => 'Communication',
            'SIA-SFC-0302'   => 'Environmental Studies',
            'SIA-SFC-0303'   => 'Military',
            'SIA-SFC-0304'   => 'Reading',
            'SIA-SFC-0305'   => 'Technology',
            'SIA-SFC-0306'   => 'Transportation',
            'SIA-SFC-0307'   => 'Zoology',
            'SIA-SRMC-01A'   => 'Basic Armorer',
            'SIA-SRMC-01C'   => 'Advanced Armorer',
            'SIA-SRMC-01D'   => 'Expert Armorer',
            'SIA-SRMC-01W'   => 'Armorer Warrant Officer Project',
            'SIA-SRMC-02A'   => 'Basic Military Police',
            'SIA-SRMC-02C'   => 'Advanced Military Police',
            'SIA-SRMC-02D'   => 'Expert Military Police',
            'SIA-SRMC-02W'   => 'Military Police Warrant Officer Project',
            'SIA-SRMC-03A'   => 'Basic Missile Crew',
            'SIA-SRMC-03C'   => 'Advanced Missile Crew',
            'SIA-SRMC-03D'   => 'Expert Missile Crew',
            'SIA-SRMC-03W'   => 'Missile Crew Warrant Officer Project',
            'SIA-SRMC-04A'   => 'Basic Laser/Graser Crew',
            'SIA-SRMC-04C'   => 'Advanced Laser/Graser Crew',
            'SIA-SRMC-04D'   => 'Expert Laser/Graser Crew',
            'SIA-SRMC-04W'   => 'Laser/Graser Crew Warrant Officer Project',
            'SIA-SRMC-05A'   => 'Basic Assault Marine',
            'SIA-SRMC-05C'   => 'Advanced Assault Marine',
            'SIA-SRMC-05D'   => 'Expert Assault Marine',
            'SIA-SRMC-05W'   => 'Assault Marine Warrant Officer Project',
            'SIA-SRMC-06A'   => 'Basic Recon Marine',
            'SIA-SRMC-06C'   => 'Advanced Recon Marine',
            'SIA-SRMC-06D'   => 'Expert Recon Marine',
            'SIA-SRMC-06W'   => 'Recon Marine Warrant Officer Project',
            'SIA-SRMC-07A'   => 'Basic Rifleman',
            'SIA-SRMC-07C'   => 'Advanced Rifleman',
            'SIA-SRMC-07D'   => 'Expert Rifleman',
            'SIA-SRMC-07W'   => 'Rifleman Warrant Officer Project',
            'SIA-SRMC-08A'   => 'Basic Heavy Weapons',
            'SIA-SRMC-08C'   => 'Advanced Heavy Weapons',
            'SIA-SRMC-08D'   => 'Expert Heavy Weapons',
            'SIA-SRMC-08W'   => 'Heavy Weapons Warrant Officer Project',
            'SIA-SRMC-09A'   => 'Basic Admin Specialist',
            'SIA-SRMC-09C'   => 'Advanced Admin Specialist',
            'SIA-SRMC-09D'   => 'Expert Admin Specialist',
            'SIA-SRMC-09W'   => 'Admin Specialist Warrant Officer Project',
            'SIA-SRMC-10A'   => 'Basic Embassy Guard',
            'SIA-SRMC-10C'   => 'Advanced Embassy Guard',
            'SIA-SRMC-10D'   => 'Expert Embassy Guard',
            'SIA-SRMC-10W'   => 'Embassy Guard Warrant Officer Project',
            'SIA-SRN-01A'    => 'Personnelman Specialist Exam',
            'SIA-SRN-01C'    => 'Personnelman Advanced Specialist Exam',
            'SIA-SRN-01D'    => 'Personnelman Qualifying Exam',
            'SIA-SRN-01W'    => 'Personnelman  Warrant Officer Project',
            'SIA-SRN-02A'    => 'Navy Counselor Specialist Exam',
            'SIA-SRN-02C'    => 'Navy Counselor Advanced Specialist Exam',
            'SIA-SRN-02D'    => 'Navy Counselor Qualifying Exam',
            'SIA-SRN-02W'    => 'Navy Counselor  Warrant Officer Project',
            'SIA-SRN-03A'    => 'Steward Specialist Exam',
            'SIA-SRN-03C'    => 'Steward Advanced Specialist Exam',
            'SIA-SRN-03D'    => 'Steward Qualifying Exam',
            'SIA-SRN-03W'    => 'Steward  Warrant Officer Project',
            'SIA-SRN-04A'    => 'Yeoman Specialist Exam',
            'SIA-SRN-04C'    => 'Yeoman Advanced Specialist Exam',
            'SIA-SRN-04D'    => 'Yeoman Qualifying Exam',
            'SIA-SRN-04W'    => 'Yeoman  Warrant Officer Project',
            'SIA-SRN-05A'    => 'Coxswain Specialist Exam',
            'SIA-SRN-05C'    => 'Coxswain Advanced Specialist Exam',
            'SIA-SRN-05D'    => 'Coxswain Qualifying Exam',
            'SIA-SRN-05W'    => 'Coxswain  Warrant Officer Project',
            'SIA-SRN-06A'    => 'Helmsman Specialist Exam',
            'SIA-SRN-06C'    => 'Helmsman Advanced Specialist Exam',
            'SIA-SRN-06D'    => 'Helmsman Qualifying Exam',
            'SIA-SRN-06W'    => 'Helmsman  Warrant Officer Project',
            'SIA-SRN-07A'    => 'Plotting Specialist Specialist Exam',
            'SIA-SRN-07C'    => 'Plotting Specialist Advanced Specialist Exam',
            'SIA-SRN-07D'    => 'Plotting Specialist Qualifying Exam',
            'SIA-SRN-07W'    => 'Plotting Specialist  Warrant Officer Project',
            'SIA-SRN-08A'    => 'Fire Control Technician Specialist Exam',
            'SIA-SRN-08C'    => 'Fire Control Technician Advanced Specialist Exam',
            'SIA-SRN-08D'    => 'Fire Control Technician Qualifying Exam',
            'SIA-SRN-08W'    => 'Fire Control Technician  Warrant Officer Project',
            'SIA-SRN-09A'    => 'Electronic Warfare Technician Specialist Exam',
            'SIA-SRN-09C'    => 'Electronic Warfare Technician Advanced Specialist Exam',
            'SIA-SRN-09D'    => 'Electronic Warfare Technician Qualifying Exam',
            'SIA-SRN-09W'    => 'Electronic Warfare Technician  Warrant Officer Project',
            'SIA-SRN-10A'    => 'Tracking Specialist Specialist Exam',
            'SIA-SRN-10C'    => 'Tracking Specialist Advanced Specialist Exam',
            'SIA-SRN-10D'    => 'Tracking Specialist Qualifying Exam',
            'SIA-SRN-10W'    => 'Tracking Specialist  Warrant Officer Project',
            'SIA-SRN-11A'    => 'Data Systems Technician Specialist Exam',
            'SIA-SRN-11C'    => 'Data Systems Technician Advanced Specialist Exam',
            'SIA-SRN-11D'    => 'Data Systems Technician Qualifying Exam',
            'SIA-SRN-11W'    => 'Data Systems Technician  Warrant Officer Project',
            'SIA-SRN-12A'    => 'Electronics Technician Specialist Exam',
            'SIA-SRN-12C'    => 'Electronics Technician Advanced Specialist Exam',
            'SIA-SRN-12D'    => 'Electronics Technician Qualifying Exam',
            'SIA-SRN-12W'    => 'Electronics Technician  Warrant Officer Project',
            'SIA-SRN-13A'    => 'Communications Technician Specialist Exam',
            'SIA-SRN-13C'    => 'Communications Technician Advanced Specialist Exam',
            'SIA-SRN-13D'    => 'Communications Technician Qualifying Exam',
            'SIA-SRN-13W'    => 'Communications Technician  Warrant Officer Project',
            'SIA-SRN-14A'    => 'Impeller Technician Specialist Exam',
            'SIA-SRN-14C'    => 'Impeller Technician Advanced Specialist Exam',
            'SIA-SRN-14D'    => 'Impeller Technician Qualifying Exam',
            'SIA-SRN-14W'    => 'Impeller Technician  Warrant Officer Project',
            'SIA-SRN-15A'    => 'Power Technician Specialist Exam',
            'SIA-SRN-15C'    => 'Power Technician Advanced Specialist Exam',
            'SIA-SRN-15D'    => 'Power Technician Qualifying Exam',
            'SIA-SRN-15W'    => 'Power Technician  Warrant Officer Project',
            'SIA-SRN-16A'    => 'Gravitics Technician Specialist Exam',
            'SIA-SRN-16C'    => 'Gravitics Technician Advanced Specialist Exam',
            'SIA-SRN-16D'    => 'Gravitics Technician Qualifying Exam',
            'SIA-SRN-16W'    => 'Gravitics Technician  Warrant Officer Project',
            'SIA-SRN-17A'    => 'Environmental Technician Specialist Exam',
            'SIA-SRN-17C'    => 'Environmental Technician Advanced Specialist Exam',
            'SIA-SRN-17D'    => 'Environmental Technician Qualifying Exam',
            'SIA-SRN-17W'    => 'Environmental Technician  Warrant Officer Project',
            'SIA-SRN-18A'    => 'Hydroponics Technician Specialist Exam',
            'SIA-SRN-18C'    => 'Hydroponics Technician Advanced Specialist Exam',
            'SIA-SRN-18D'    => 'Hydroponics Technician Qualifying Exam',
            'SIA-SRN-18W'    => 'Hydroponics Technician  Warrant Officer Project',
            'SIA-SRN-19A'    => 'Damage Control Technician Specialist Exam',
            'SIA-SRN-19C'    => 'Damage Control Technician Advanced Specialist Exam',
            'SIA-SRN-19D'    => 'Damage Control Technician Qualifying Exam',
            'SIA-SRN-19W'    => 'Damage Control Technician  Warrant Officer Project',
            'SIA-SRN-20A'    => 'Storekeeper Specialist Exam',
            'SIA-SRN-20C'    => 'Storekeeper Advanced Specialist Exam',
            'SIA-SRN-20D'    => 'Storekeeper Qualifying Exam',
            'SIA-SRN-20W'    => 'Storekeeper  Warrant Officer Project',
            'SIA-SRN-21A'    => 'Disbursing Clerk Specialist Exam',
            'SIA-SRN-21C'    => 'Disbursing Clerk Advanced Specialist Exam',
            'SIA-SRN-21D'    => 'Disbursing Clerk Qualifying Exam',
            'SIA-SRN-21W'    => 'Disbursing Clerk  Warrant Officer Project',
            'SIA-SRN-22A'    => 'Ship\'s Serviceman Specialist Exam',
            'SIA-SRN-22C'    => 'Ship\'s Serviceman Advanced Specialist Exam',
            'SIA-SRN-22D'    => 'Ship\'s Serviceman Qualifying Exam',
            'SIA-SRN-22W'    => 'Ship\'s Serviceman  Warrant Officer Project',
            'SIA-SRN-23A'    => 'Corpsman Specialist Exam',
            'SIA-SRN-23C'    => 'Corpsman Advanced Specialist Exam',
            'SIA-SRN-23D'    => 'Corpsman Qualifying Exam',
            'SIA-SRN-23W'    => 'Corpsman  Warrant Officer Project',
            'SIA-SRN-24A'    => 'Sick Berth Attendant Specialist Exam',
            'SIA-SRN-24C'    => 'Sick Berth Attendant Advanced Specialist Exam',
            'SIA-SRN-24D'    => 'Sick Berth Attendant Qualifying Exam',
            'SIA-SRN-24W'    => 'Sick Berth Attendant  Warrant Officer Project',
            'SIA-SRN-25A'    => 'Operations Specialist Specialist Exam',
            'SIA-SRN-25C'    => 'Operations Specialist Advanced Specialist Exam',
            'SIA-SRN-25D'    => 'Operations Specialist Qualifying Exam',
            'SIA-SRN-25W'    => 'Operations Specialist  Warrant Officer Project',
            'SIA-SRN-26A'    => 'Intelligence Specialist Specialist Exam',
            'SIA-SRN-26C'    => 'Intelligence Specialist Advanced Specialist Exam',
            'SIA-SRN-26D'    => 'Intelligence Specialist Qualifying Exam',
            'SIA-SRN-26W'    => 'Intelligence Specialist  Warrant Officer Project',
            'SIA-SRN-27A'    => 'Missile Technician Specialist Exam',
            'SIA-SRN-27C'    => 'Missile Technician Advanced Specialist Exam',
            'SIA-SRN-27D'    => 'Missile Technician Qualifying Exam',
            'SIA-SRN-27W'    => 'Missile Technician  Warrant Officer Project',
            'SIA-SRN-28A'    => 'Beam Weapons Technician Specialist Exam',
            'SIA-SRN-28C'    => 'Beam Weapons Technician Advanced Specialist Exam',
            'SIA-SRN-28D'    => 'Beam Weapons Technician Qualifying Exam',
            'SIA-SRN-28W'    => 'Beam Weapons Technician  Warrant Officer Project',
            'SIA-SRN-29A'    => 'Gunner Specialist Exam',
            'SIA-SRN-29C'    => 'Gunner Advanced Specialist Exam',
            'SIA-SRN-29D'    => 'Gunner Qualifying Exam',
            'SIA-SRN-29W'    => 'Gunner  Warrant Officer Project',
            'SIA-SRN-30A'    => 'Boatswain Specialist Exam',
            'SIA-SRN-30C'    => 'Boatswain Advanced Specialist Exam',
            'SIA-SRN-30D'    => 'Boatswain Qualifying Exam',
            'SIA-SRN-30W'    => 'Boatswain  Warrant Officer Project',
            'SIA-SRN-31A'    => 'Master-at-Arms Specialist Exam',
            'SIA-SRN-31C'    => 'Master-at-Arms Advanced Specialist Exam',
            'SIA-SRN-31D'    => 'Master-at-Arms Qualifying Exam',
            'SIA-SRN-31W'    => 'Master-at-Arms  Warrant Officer Project',
            'SIA-SRN-32A'    => 'Sensor Technician Specialist Exam',
            'SIA-SRN-32C'    => 'Sensor Technician Advanced Specialist Exam',
            'SIA-SRN-32D'    => 'Sensor Technician Qualifying Exam',
            'SIA-SRN-32W'    => 'Sensor Technician  Warrant Officer Project',
        ];
        foreach ($exams as $id => $name) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'exam_list',
                null,
                json_encode(['exam_id' => $id, 'name' => $name, 'enabled' => true]),
                'add_exam_list'
            );
            ExamList::create(['exam_id' => $id, 'name' => $name, 'enabled' => true]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (ExamList::all() as $exam) {
            $exam->forceDelete();
        }
    }
}
