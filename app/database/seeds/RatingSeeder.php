<?php

class RatingSeeder extends Seeder
{
    use \Medusa\Audit\MedusaAudit;

    public function run()
    {
        DB::collection('ratings')->delete();

        $ratings = [
            "SRN-01" => ["description" => "Personnelman",
                "RMN" => [

                    "E-1" => "Personnelman 3/c",
                    "E-2" => "Personnelman 2/c",
                    "E-3" => "Personnelman 1/c",
                    "E-4" => "Personnelman Petty Officer 3/c",
                    "E-5" => "Personnelman Petty Officer 2/c",
                    "E-6" => "Personnelman Petty Officer 1/c",
                    "E-7" => "Chief Personnelman",
                    "E-8" => "Senior Chief Personnelman",
                    "E-9" => "Master Chief Personnelman",
                    "E-10" => "Senior Master Chief Personnelman"
                ],
                "GSN" => [

                    "E-1" => "Personnelman 3/c",
                    "E-2" => "Personnelman 2/c",
                    "E-3" => "Personnelman 1/c",
                    "E-4" => "Personnelman Petty Officer 3/c",
                    "E-5" => "Personnelman Petty Officer 2/c",
                    "E-6" => "Personnelman Petty Officer 1/c",
                    "E-7" => "Chief Personnelman",
                    "E-8" => "Senior Chief Personnelman",
                    "E-9" => "Master Chief Personnelman",
                    "E-10" => "Senior Master Chief Personnelman"
                ],
                "RHN" => [

                    "E-1" => "Personnelman 3/c",
                    "E-2" => "Personnelman 2/c",
                    "E-3" => "Personnelman 1/c",
                    "E-4" => "Personnelman Petty Officer 3/c",
                    "E-5" => "Personnelman Petty Officer 2/c",
                    "E-6" => "Personnelman Petty Officer 1/c",
                    "E-7" => "Chief Personnelman",
                    "E-8" => "Senior Chief Personnelman",
                    "E-9" => "Master Chief Personnelman",
                    "E-10" => "Senior Master Chief Personnelman"
                ]
            ],
            "SRN-02" => ["description" => "Navy Counselor",
                "RMN" => [

                    "E-1" => "Navy Counselor 3/c",
                    "E-2" => "Navy Counselor 2/c",
                    "E-3" => "Navy Counselor 1/c",
                    "E-4" => "Navy Counselor Petty Officer 3/c",
                    "E-5" => "Navy Counselor Petty Officer 2/c",
                    "E-6" => "Navy Counselor Petty Officer 1/c",
                    "E-7" => "Chief Navy Counselor",
                    "E-8" => "Senior Chief Navy Counselor",
                    "E-9" => "Master Chief Navy Counselor",
                    "E-10" => "Senior Master Chief Navy Counselor"
                ],
                "GSN" => [

                    "E-1" => "Navy Counselor 3/c",
                    "E-2" => "Navy Counselor 2/c",
                    "E-3" => "Navy Counselor 1/c",
                    "E-4" => "Navy Counselor Petty Officer 3/c",
                    "E-5" => "Navy Counselor Petty Officer 2/c",
                    "E-6" => "Navy Counselor Petty Officer 1/c",
                    "E-7" => "Chief Navy Counselor",
                    "E-8" => "Senior Chief Navy Counselor",
                    "E-9" => "Master Chief Navy Counselor",
                    "E-10" => "Senior Master Chief Navy Counselor"
                ],
                "RHN" => [

                    "E-1" => "Navy Counselor 3/c",
                    "E-2" => "Navy Counselor 2/c",
                    "E-3" => "Navy Counselor 1/c",
                    "E-4" => "Navy Counselor Petty Officer 3/c",
                    "E-5" => "Navy Counselor Petty Officer 2/c",
                    "E-6" => "Navy Counselor Petty Officer 1/c",
                    "E-7" => "Chief Navy Counselor",
                    "E-8" => "Senior Chief Navy Counselor",
                    "E-9" => "Master Chief Navy Counselor",
                    "E-10" => "Senior Master Chief Navy Counselor"
                ],
            ],
            "SRN-03" => ["description" => "Steward",
                "RMN" => [

                    "E-1" => "Steward 3/c",
                    "E-2" => "Steward 2/c",
                    "E-3" => "Steward 1/c",
                    "E-4" => "Steward Petty Officer 3/c",
                    "E-5" => "Steward Petty Officer 2/c",
                    "E-6" => "Steward Petty Officer 1/c",
                    "E-7" => "Chief Steward",
                    "E-8" => "Senior Chief Steward",
                    "E-9" => "Master Chief Steward",
                    "E-10" => "Senior Master Chief Steward"
                ],
                "GSN" => [

                    "E-1" => "Steward 3/c",
                    "E-2" => "Steward 2/c",
                    "E-3" => "Steward 1/c",
                    "E-4" => "Steward Petty Officer 3/c",
                    "E-5" => "Steward Petty Officer 2/c",
                    "E-6" => "Steward Petty Officer 1/c",
                    "E-7" => "Chief Steward",
                    "E-8" => "Senior Chief Steward",
                    "E-9" => "Master Chief Steward",
                    "E-10" => "Senior Master Chief Steward"
                ],
                "RHN" => [

                    "E-1" => "Steward 3/c",
                    "E-2" => "Steward 2/c",
                    "E-3" => "Steward 1/c",
                    "E-4" => "Steward Petty Officer 3/c",
                    "E-5" => "Steward Petty Officer 2/c",
                    "E-6" => "Steward Petty Officer 1/c",
                    "E-7" => "Chief Steward",
                    "E-8" => "Senior Chief Steward",
                    "E-9" => "Master Chief Steward",
                    "E-10" => "Senior Master Chief Steward"
                ],
            ],
            "SRN-04" => ["description" => "Yeoman",
                "RMN" => [

                    "E-1" => "Yeoman 3/c",
                    "E-2" => "Yeoman 2/c",
                    "E-3" => "Yeoman 1/c",
                    "E-4" => "Yeoman Petty Officer 3/c",
                    "E-5" => "Yeoman Petty Officer 2/c",
                    "E-6" => "Yeoman Petty Officer 1/c",
                    "E-7" => "Chief Yeoman",
                    "E-8" => "Senior Chief Yeoman",
                    "E-9" => "Master Chief Yeoman",
                    "E-10" => "Senior Master Chief Yeoman"
                ],
                "GSN" => [

                    "E-1" => "Yeoman 3/c",
                    "E-2" => "Yeoman 2/c",
                    "E-3" => "Yeoman 1/c",
                    "E-4" => "Yeoman Petty Officer 3/c",
                    "E-5" => "Yeoman Petty Officer 2/c",
                    "E-6" => "Yeoman Petty Officer 1/c",
                    "E-7" => "Chief Yeoman",
                    "E-8" => "Senior Chief Yeoman",
                    "E-9" => "Master Chief Yeoman",
                    "E-10" => "Senior Master Chief Yeoman"
                ],
                "RHN" => [

                    "E-1" => "Yeoman 3/c",
                    "E-2" => "Yeoman 2/c",
                    "E-3" => "Yeoman 1/c",
                    "E-4" => "Yeoman Petty Officer 3/c",
                    "E-5" => "Yeoman Petty Officer 2/c",
                    "E-6" => "Yeoman Petty Officer 1/c",
                    "E-7" => "Chief Yeoman",
                    "E-8" => "Senior Chief Yeoman",
                    "E-9" => "Master Chief Yeoman",
                    "E-10" => "Senior Master Chief Yeoman"
                ],
            ],
            "SRN-05" => ["description" => "Coxswain",
                "RMN" => [

                    "E-1" => "Coxswain 3/c",
                    "E-2" => "Coxswain 2/c",
                    "E-3" => "Coxswain 1/c",
                    "E-4" => "Coxswain Petty Officer 3/c",
                    "E-5" => "Coxswain Petty Officer 2/c",
                    "E-6" => "Coxswain Petty Officer 1/c",
                    "E-7" => "Chief Coxswain",
                    "E-8" => "Senior Chief Coxswain",
                    "E-9" => "Master Chief Coxswain",
                    "E-10" => "Senior Master Chief Coxswain"
                ],
                "GSN" => [

                    "E-1" => "Coxswain 3/c",
                    "E-2" => "Coxswain 2/c",
                    "E-3" => "Coxswain 1/c",
                    "E-4" => "Coxswain Petty Officer 3/c",
                    "E-5" => "Coxswain Petty Officer 2/c",
                    "E-6" => "Coxswain Petty Officer 1/c",
                    "E-7" => "Chief Coxswain",
                    "E-8" => "Senior Chief Coxswain",
                    "E-9" => "Master Chief Coxswain",
                    "E-10" => "Senior Master Chief Coxswain"
                ],
                "RHN" => [

                    "E-1" => "Coxswain 3/c",
                    "E-2" => "Coxswain 2/c",
                    "E-3" => "Coxswain 1/c",
                    "E-4" => "Coxswain Petty Officer 3/c",
                    "E-5" => "Coxswain Petty Officer 2/c",
                    "E-6" => "Coxswain Petty Officer 1/c",
                    "E-7" => "Chief Coxswain",
                    "E-8" => "Senior Chief Coxswain",
                    "E-9" => "Master Chief Coxswain",
                    "E-10" => "Senior Master Chief Coxswain"
                ],
            ],
            "SRN-06" => ["description" => "Helmsman",
                "RMN" => [

                    "E-1" => "Helmsman 3/c",
                    "E-2" => "Helmsman 2/c",
                    "E-3" => "Helmsman 1/c",
                    "E-4" => "Helmsman Petty Officer 3/c",
                    "E-5" => "Helmsman Petty Officer 2/c",
                    "E-6" => "Helmsman Petty Officer 1/c",
                    "E-7" => "Chief Helmsman",
                    "E-8" => "Senior Chief Helmsman",
                    "E-9" => "Master Chief Helmsman",
                    "E-10" => "Senior Master Chief Helmsman"
                ],
                "GSN" => [

                    "E-1" => "Helmsman 3/c",
                    "E-2" => "Helmsman 2/c",
                    "E-3" => "Helmsman 1/c",
                    "E-4" => "Helmsman Petty Officer 3/c",
                    "E-5" => "Helmsman Petty Officer 2/c",
                    "E-6" => "Helmsman Petty Officer 1/c",
                    "E-7" => "Chief Helmsman",
                    "E-8" => "Senior Chief Helmsman",
                    "E-9" => "Master Chief Helmsman",
                    "E-10" => "Senior Master Chief Helmsman"
                ],
                "RHN" => [

                    "E-1" => "Helmsman 3/c",
                    "E-2" => "Helmsman 2/c",
                    "E-3" => "Helmsman 1/c",
                    "E-4" => "Helmsman Petty Officer 3/c",
                    "E-5" => "Helmsman Petty Officer 2/c",
                    "E-6" => "Helmsman Petty Officer 1/c",
                    "E-7" => "Chief Helmsman",
                    "E-8" => "Senior Chief Helmsman",
                    "E-9" => "Master Chief Helmsman",
                    "E-10" => "Senior Master Chief Helmsman"
                ],
            ],
            "SRN-07" => ["description" => "Plotting Specialist",
                "RMN" => [

                    "E-1" => "Plotting Specialist 3/c",
                    "E-2" => "Plotting Specialist 2/c",
                    "E-3" => "Plotting Specialist 1/c",
                    "E-4" => "Plotting Mate 3/c",
                    "E-5" => "Plotting Mate 2/c",
                    "E-6" => "Plotting Mate 1/c",
                    "E-7" => "Chief Plotting Mate",
                    "E-8" => "Senior Chief Plotting Mate",
                    "E-9" => "Master Chief Plotting Mate",
                    "E-10" => "Senior Master Chief Plotting Mate"
                ],
                "GSN" => [

                    "E-1" => "Plotting Specialist 3/c",
                    "E-2" => "Plotting Specialist 2/c",
                    "E-3" => "Plotting Specialist 1/c",
                    "E-4" => "Plotting Mate 3/c",
                    "E-5" => "Plotting Mate 2/c",
                    "E-6" => "Plotting Mate 1/c",
                    "E-7" => "Chief Plotting Mate",
                    "E-8" => "Senior Chief Plotting Mate",
                    "E-9" => "Master Chief Plotting Mate",
                    "E-10" => "Senior Master Chief Plotting Mate"
                ],
                "RHN" => [

                    "E-1" => "Plotting Specialist 3/c",
                    "E-2" => "Plotting Specialist 2/c",
                    "E-3" => "Plotting Specialist 1/c",
                    "E-4" => "Plotting Mate 3/c",
                    "E-5" => "Plotting Mate 2/c",
                    "E-6" => "Plotting Mate 1/c",
                    "E-7" => "Chief Plotting Mate",
                    "E-8" => "Senior Chief Plotting Mate",
                    "E-9" => "Master Chief Plotting Mate",
                    "E-10" => "Senior Master Chief Plotting Mate"
                ],
            ],
            "SRN-08" => ["description" => "Fire Control Technician",
                "RMN" => [

                    "E-1" => "Fire Control Technician 3/c",
                    "E-2" => "Fire Control Technician 2/c",
                    "E-3" => "Fire Control Technician 1/c",
                    "E-4" => "Fire Control Mate 3/c",
                    "E-5" => "Fire Control Mate 2/c",
                    "E-6" => "Fire Control Mate 1/c",
                    "E-7" => "Chief Fire Control Mate",
                    "E-8" => "Senior Chief Fire Control Mate",
                    "E-9" => "Master Chief Fire Control Mate",
                    "E-10" => "Senior Master Chief Fire Control Mate"
                ],
                "GSN" => [

                    "E-1" => "Fire Control Technician 3/c",
                    "E-2" => "Fire Control Technician 2/c",
                    "E-3" => "Fire Control Technician 1/c",
                    "E-4" => "Fire Control Mate 3/c",
                    "E-5" => "Fire Control Mate 2/c",
                    "E-6" => "Fire Control Mate 1/c",
                    "E-7" => "Chief Fire Control Mate",
                    "E-8" => "Senior Chief Fire Control Mate",
                    "E-9" => "Master Chief Fire Control Mate",
                    "E-10" => "Senior Master Chief Fire Control Mate"
                ],
                "RHN" => [

                    "E-1" => "Fire Control Technician 3/c",
                    "E-2" => "Fire Control Technician 2/c",
                    "E-3" => "Fire Control Technician 1/c",
                    "E-4" => "Fire Control Mate 3/c",
                    "E-5" => "Fire Control Mate 2/c",
                    "E-6" => "Fire Control Mate 1/c",
                    "E-7" => "Chief Fire Control Mate",
                    "E-8" => "Senior Chief Fire Control Mate",
                    "E-9" => "Master Chief Fire Control Mate",
                    "E-10" => "Senior Master Chief Fire Control Mate"
                ],
            ],
            "SRN-09" => ["description" => "Electronic Warfare Technician",
                "RMN" => [

                    "E-1" => "Electronic Warfare Technician 3/c",
                    "E-2" => "Electronic Warfare Technician 2/c",
                    "E-3" => "Electronic Warfare Technician 1/c",
                    "E-4" => "Electronic Warfare Mate 3/c",
                    "E-5" => "Electronic Warfare Mate 2/c",
                    "E-6" => "Electronic Warfare Mate 1/c",
                    "E-7" => "Chief Electronic Warfare Mate",
                    "E-8" => "Senior Chief Electronic Warfare Mate",
                    "E-9" => "Master Chief Electronic Warfare Mate",
                    "E-10" => "Senior Master Chief Electronic Warfare Mate"
                ],
                "GSN" => [

                    "E-1" => "Electronic Warfare Technician 3/c",
                    "E-2" => "Electronic Warfare Technician 2/c",
                    "E-3" => "Electronic Warfare Technician 1/c",
                    "E-4" => "Electronic Warfare Mate 3/c",
                    "E-5" => "Electronic Warfare Mate 2/c",
                    "E-6" => "Electronic Warfare Mate 1/c",
                    "E-7" => "Chief Electronic Warfare Mate",
                    "E-8" => "Senior Chief Electronic Warfare Mate",
                    "E-9" => "Master Chief Electronic Warfare Mate",
                    "E-10" => "Senior Master Chief Electronic Warfare Mate"
                ],
                "RHN" => [

                    "E-1" => "Electronic Warfare Technician 3/c",
                    "E-2" => "Electronic Warfare Technician 2/c",
                    "E-3" => "Electronic Warfare Technician 1/c",
                    "E-4" => "Electronic Warfare Mate 3/c",
                    "E-5" => "Electronic Warfare Mate 2/c",
                    "E-6" => "Electronic Warfare Mate 1/c",
                    "E-7" => "Chief Electronic Warfare Mate",
                    "E-8" => "Senior Chief Electronic Warfare Mate",
                    "E-9" => "Master Chief Electronic Warfare Mate",
                    "E-10" => "Senior Master Chief Electronic Warfare Mate"
                ],
            ],
            "SRN-10" => ["description" => "Tracking Specialist",
                "RMN" => [

                    "E-1" => "Tracking Specialist 3/c",
                    "E-2" => "Tracking Specialist 2/c",
                    "E-3" => "Tracking Specialist 1/c",
                    "E-4" => "Tracking Mate 3/c",
                    "E-5" => "Tracking Mate 2/c",
                    "E-6" => "Tracking Mate 1/c",
                    "E-7" => "Chief Tracking Mate",
                    "E-8" => "Senior Chief Tracking Mate",
                    "E-9" => "Master Chief Tracking Mate",
                    "E-10" => "Senior Master Chief Tracking Mate"
                ],
                "GSN" => [

                    "E-1" => "Tracking Specialist 3/c",
                    "E-2" => "Tracking Specialist 2/c",
                    "E-3" => "Tracking Specialist 1/c",
                    "E-4" => "Tracking Mate 3/c",
                    "E-5" => "Tracking Mate 2/c",
                    "E-6" => "Tracking Mate 1/c",
                    "E-7" => "Chief Tracking Mate",
                    "E-8" => "Senior Chief Tracking Mate",
                    "E-9" => "Master Chief Tracking Mate",
                    "E-10" => "Senior Master Chief Tracking Mate"
                ],
                "RHN" => [

                    "E-1" => "Tracking Specialist 3/c",
                    "E-2" => "Tracking Specialist 2/c",
                    "E-3" => "Tracking Specialist 1/c",
                    "E-4" => "Tracking Mate 3/c",
                    "E-5" => "Tracking Mate 2/c",
                    "E-6" => "Tracking Mate 1/c",
                    "E-7" => "Chief Tracking Mate",
                    "E-8" => "Senior Chief Tracking Mate",
                    "E-9" => "Master Chief Tracking Mate",
                    "E-10" => "Senior Master Chief Tracking Mate"
                ]
            ],
            "SRN-11" => ["description" => "Data System Technician",
                "RMN" => [

                    "E-1" => "Data Systems Technician 3/c",
                    "E-2" => "Data Systems Technician 2/c",
                    "E-3" => "Data Systems Technician 1/c",
                    "E-4" => "Data Systems Mate 3/c",
                    "E-5" => "Data Systems Mate 2/c",
                    "E-6" => "Data Systems Mate 1/c",
                    "E-7" => "Chief Data Systems Mate",
                    "E-8" => "Senior Chief Data Systems Mate",
                    "E-9" => "Master Chief Data Systems Mate",
                    "E-10" => "Senior Master Chief Data Systems Mate"
                ],
                "GSN" => [

                    "E-1" => "Data Systems Technician 3/c",
                    "E-2" => "Data Systems Technician 2/c",
                    "E-3" => "Data Systems Technician 1/c",
                    "E-4" => "Data Systems Mate 3/c",
                    "E-5" => "Data Systems Mate 2/c",
                    "E-6" => "Data Systems Mate 1/c",
                    "E-7" => "Chief Data Systems Mate",
                    "E-8" => "Senior Chief Data Systems Mate",
                    "E-9" => "Master Chief Data Systems Mate",
                    "E-10" => "Senior Master Chief Data Systems Mate"
                ],
                "RHN" => [

                    "E-1" => "Data Systems Technician 3/c",
                    "E-2" => "Data Systems Technician 2/c",
                    "E-3" => "Data Systems Technician 1/c",
                    "E-4" => "Data Systems Mate 3/c",
                    "E-5" => "Data Systems Mate 2/c",
                    "E-6" => "Data Systems Mate 1/c",
                    "E-7" => "Chief Data Systems Mate",
                    "E-8" => "Senior Chief Data Systems Mate",
                    "E-9" => "Master Chief Data Systems Mate",
                    "E-10" => "Senior Master Chief Data Systems Mate"
                ]
            ],
            "SRN-12" => ["description" => "Electronics Technician",
                "RMN" => [

                    "E-1" => "Electronics Technician 3/c",
                    "E-2" => "Electronics Technician 2/c",
                    "E-3" => "Electronics Technician 1/c",
                    "E-4" => "Electronics Mate 3/c",
                    "E-5" => "Electronics Mate 2/c",
                    "E-6" => "Electronics Mate 1/c",
                    "E-7" => "Chief Electronics Mate",
                    "E-8" => "Senior Chief Electronics Mate",
                    "E-9" => "Master Chief Electronics Mate",
                    "E-10" => "Senior Master Chief Electronics Mate"
                ],
                "GSN" => [

                    "E-1" => "Electronics Technician 3/c",
                    "E-2" => "Electronics Technician 2/c",
                    "E-3" => "Electronics Technician 1/c",
                    "E-4" => "Electronics Mate 3/c",
                    "E-5" => "Electronics Mate 2/c",
                    "E-6" => "Electronics Mate 1/c",
                    "E-7" => "Chief Electronics Mate",
                    "E-8" => "Senior Chief Electronics Mate",
                    "E-9" => "Master Chief Electronics Mate",
                    "E-10" => "Senior Master Chief Electronics Mate"
                ],
                "RHN" => [

                    "E-1" => "Electronics Technician 3/c",
                    "E-2" => "Electronics Technician 2/c",
                    "E-3" => "Electronics Technician 1/c",
                    "E-4" => "Electronics Mate 3/c",
                    "E-5" => "Electronics Mate 2/c",
                    "E-6" => "Electronics Mate 1/c",
                    "E-7" => "Chief Electronics Mate",
                    "E-8" => "Senior Chief Electronics Mate",
                    "E-9" => "Master Chief Electronics Mate",
                    "E-10" => "Senior Master Chief Electronics Mate"
                ]
            ],
            "SRN-13" => ["description" => "Communications Technician",
                "RMN" => [

                    "E-1" => "Communications Technician 3/c",
                    "E-2" => "Communications Technician 2/c",
                    "E-3" => "Communications Technician 1/c",
                    "E-4" => "Communications Mate 3/c",
                    "E-5" => "Communications Mate 2/c",
                    "E-6" => "Communications Mate 1/c",
                    "E-7" => "Chief Communications Mate",
                    "E-8" => "Senior Chief Communications Mate",
                    "E-9" => "Master Chief Communications Mate",
                    "E-10" => "Senior Master Chief Communications Mate"
                ],
                "GSN" => [
                    "description" => "Communications Technician",
                    "E-1" => "Communications Technician 3/c",
                    "E-2" => "Communications Technician 2/c",
                    "E-3" => "Communications Technician 1/c",
                    "E-4" => "Communications Mate 3/c",
                    "E-5" => "Communications Mate 2/c",
                    "E-6" => "Communications Mate 1/c",
                    "E-7" => "Chief Communications Mate",
                    "E-8" => "Senior Chief Communications Mate",
                    "E-9" => "Master Chief Communications Mate",
                    "E-10" => "Senior Master Chief Communications Mate"
                ],
                "RHN" => [

                    "E-1" => "Communications Technician 3/c",
                    "E-2" => "Communications Technician 2/c",
                    "E-3" => "Communications Technician 1/c",
                    "E-4" => "Communications Mate 3/c",
                    "E-5" => "Communications Mate 2/c",
                    "E-6" => "Communications Mate 1/c",
                    "E-7" => "Chief Communications Mate",
                    "E-8" => "Senior Chief Communications Mate",
                    "E-9" => "Master Chief Communications Mate",
                    "E-10" => "Senior Master Chief Communications Mate"
                ]
            ],
            "SRN-14" => ["description" => "Impeller Technician",
                "RMN" => [

                    "E-1" => "Impeller Technician 3/c",
                    "E-2" => "Impeller Technician 2/c",
                    "E-3" => "Impeller Technician 1/c",
                    "E-4" => "Impeller Mate 3/c",
                    "E-5" => "Impeller Mate 2/c",
                    "E-6" => "Impeller Mate 1/c",
                    "E-7" => "Chief Impeller Mate",
                    "E-8" => "Senior Chief Impeller Mate",
                    "E-9" => "Master Chief Impeller Mate",
                    "E-10" => "Senior Master Chief Impeller Mate"
                ],
                "GSN" => [

                    "E-1" => "Impeller Technician 3/c",
                    "E-2" => "Impeller Technician 2/c",
                    "E-3" => "Impeller Technician 1/c",
                    "E-4" => "Impeller Mate 3/c",
                    "E-5" => "Impeller Mate 2/c",
                    "E-6" => "Impeller Mate 1/c",
                    "E-7" => "Chief Impeller Mate",
                    "E-8" => "Senior Chief Impeller Mate",
                    "E-9" => "Master Chief Impeller Mate",
                    "E-10" => "Senior Master Chief Impeller Mate"
                ],
                "RHN" => [

                    "E-1" => "Impeller Technician 3/c",
                    "E-2" => "Impeller Technician 2/c",
                    "E-3" => "Impeller Technician 1/c",
                    "E-4" => "Impeller Mate 3/c",
                    "E-5" => "Impeller Mate 2/c",
                    "E-6" => "Impeller Mate 1/c",
                    "E-7" => "Chief Impeller Mate",
                    "E-8" => "Senior Chief Impeller Mate",
                    "E-9" => "Master Chief Impeller Mate",
                    "E-10" => "Senior Master Chief Impeller Mate"
                ]
            ],
            "SRN-15" => ["description" => "Power Technician",
                "RMN" => [

                    "E-1" => "Power Technician 3/c",
                    "E-2" => "Power Technician 2/c",
                    "E-3" => "Power Technician 1/c",
                    "E-4" => "Power Mate 3/c",
                    "E-5" => "Power Mate 2/c",
                    "E-6" => "Power Mate 1/c",
                    "E-7" => "Chief Power Mate",
                    "E-8" => "Senior Chief Power Mate",
                    "E-9" => "Master Chief Power Mate",
                    "E-10" => "Senior Master Chief Power Mate"
                ],
                "GSN" => [

                    "E-1" => "Power Technician 3/c",
                    "E-2" => "Power Technician 2/c",
                    "E-3" => "Power Technician 1/c",
                    "E-4" => "Power Mate 3/c",
                    "E-5" => "Power Mate 2/c",
                    "E-6" => "Power Mate 1/c",
                    "E-7" => "Chief Power Mate",
                    "E-8" => "Senior Chief Power Mate",
                    "E-9" => "Master Chief Power Mate",
                    "E-10" => "Senior Master Chief Power Mate"
                ],
                "RHN" => [

                    "E-1" => "Power Technician 3/c",
                    "E-2" => "Power Technician 2/c",
                    "E-3" => "Power Technician 1/c",
                    "E-4" => "Power Mate 3/c",
                    "E-5" => "Power Mate 2/c",
                    "E-6" => "Power Mate 1/c",
                    "E-7" => "Chief Power Mate",
                    "E-8" => "Senior Chief Power Mate",
                    "E-9" => "Master Chief Power Mate",
                    "E-10" => "Senior Master Chief Power Mate"
                ]
            ],
            "SRN-16" => ["description" => "Gravatics Technician",
                "RMN" => [

                    "E-1" => "Gravatics Technician 3/c",
                    "E-2" => "Gravatics Technician 2/c",
                    "E-3" => "Gravatics Technician 1/c",
                    "E-4" => "Gravatics Mate 3/c",
                    "E-5" => "Gravatics Mate 2/c",
                    "E-6" => "Gravatics Mate 1/c",
                    "E-7" => "Chief Gravatics Mate",
                    "E-8" => "Senior Chief Gravatics Mate",
                    "E-9" => "Master Chief Gravatics Mate",
                    "E-10" => "Senior Master Chief Gravatics Mate"
                ],
                "GSN" => [

                    "E-1" => "Gravatics Technician 3/c",
                    "E-2" => "Gravatics Technician 2/c",
                    "E-3" => "Gravatics Technician 1/c",
                    "E-4" => "Gravatics Mate 3/c",
                    "E-5" => "Gravatics Mate 2/c",
                    "E-6" => "Gravatics Mate 1/c",
                    "E-7" => "Chief Gravatics Mate",
                    "E-8" => "Senior Chief Gravatics Mate",
                    "E-9" => "Master Chief Gravatics Mate",
                    "E-10" => "Senior Master Chief Gravatics Mate"
                ],
                "RHN" => [

                    "E-1" => "Gravatics Technician 3/c",
                    "E-2" => "Gravatics Technician 2/c",
                    "E-3" => "Gravatics Technician 1/c",
                    "E-4" => "Gravatics Mate 3/c",
                    "E-5" => "Gravatics Mate 2/c",
                    "E-6" => "Gravatics Mate 1/c",
                    "E-7" => "Chief Gravatics Mate",
                    "E-8" => "Senior Chief Gravatics Mate",
                    "E-9" => "Master Chief Gravatics Mate",
                    "E-10" => "Senior Master Chief Gravatics Mate"
                ]
            ],
            "SRN-17" => ["description" => "Environmental Technician",
                "RMN" => [

                    "E-1" => "Environmental Technician 3/c",
                    "E-2" => "Environmental Technician 2/c",
                    "E-3" => "Environmental Technician 1/c",
                    "E-4" => "Environmental Mate 3/c",
                    "E-5" => "Environmental Mate 2/c",
                    "E-6" => "Environmental Mate 1/c",
                    "E-7" => "Chief Environmental Mate",
                    "E-8" => "Senior Chief Environmental Mate",
                    "E-9" => "Master Chief Environmental Mate",
                    "E-10" => "Senior Master Chief Environmental Mate"
                ],
                "GSN" => [

                    "E-1" => "Environmental Technician 3/c",
                    "E-2" => "Environmental Technician 2/c",
                    "E-3" => "Environmental Technician 1/c",
                    "E-4" => "Environmental Mate 3/c",
                    "E-5" => "Environmental Mate 2/c",
                    "E-6" => "Environmental Mate 1/c",
                    "E-7" => "Chief Environmental Mate",
                    "E-8" => "Senior Chief Environmental Mate",
                    "E-9" => "Master Chief Environmental Mate",
                    "E-10" => "Senior Master Chief Environmental Mate"
                ],
                "RHN" => [

                    "E-1" => "Environmental Technician 3/c",
                    "E-2" => "Environmental Technician 2/c",
                    "E-3" => "Environmental Technician 1/c",
                    "E-4" => "Environmental Mate 3/c",
                    "E-5" => "Environmental Mate 2/c",
                    "E-6" => "Environmental Mate 1/c",
                    "E-7" => "Chief Environmental Mate",
                    "E-8" => "Senior Chief Environmental Mate",
                    "E-9" => "Master Chief Environmental Mate",
                    "E-10" => "Senior Master Chief Environmental Mate"
                ]
            ],
            "SRN-18" => ["description" => "Hydroponics Technician",
                "RMN" => [

                    "E-1" => "Hydroponics Technician 3/c",
                    "E-2" => "Hydroponics Technician 2/c",
                    "E-3" => "Hydroponics Technician 1/c",
                    "E-4" => "Hydroponics Mate 3/c",
                    "E-5" => "Hydroponics Mate 2/c",
                    "E-6" => "Hydroponics Mate 1/c",
                    "E-7" => "Chief Hydroponics Mate",
                    "E-8" => "Senior Chief Hydroponics Mate",
                    "E-9" => "Master Chief Hydroponics Mate",
                    "E-10" => "Senior Master Chief Hydroponics Mate"
                ],
                "GSN" => [

                    "E-1" => "Hydroponics Technician 3/c",
                    "E-2" => "Hydroponics Technician 2/c",
                    "E-3" => "Hydroponics Technician 1/c",
                    "E-4" => "Hydroponics Mate 3/c",
                    "E-5" => "Hydroponics Mate 2/c",
                    "E-6" => "Hydroponics Mate 1/c",
                    "E-7" => "Chief Hydroponics Mate",
                    "E-8" => "Senior Chief Hydroponics Mate",
                    "E-9" => "Master Chief Hydroponics Mate",
                    "E-10" => "Senior Master Chief Hydroponics Mate"
                ],
                "RHN" => [

                    "E-1" => "Hydroponics Technician 3/c",
                    "E-2" => "Hydroponics Technician 2/c",
                    "E-3" => "Hydroponics Technician 1/c",
                    "E-4" => "Hydroponics Mate 3/c",
                    "E-5" => "Hydroponics Mate 2/c",
                    "E-6" => "Hydroponics Mate 1/c",
                    "E-7" => "Chief Hydroponics Mate",
                    "E-8" => "Senior Chief Hydroponics Mate",
                    "E-9" => "Master Chief Hydroponics Mate",
                    "E-10" => "Senior Master Chief Hydroponics Mate"
                ]
            ],
            "SRN-19" => ["description" => "Damage Control Technician",
                "RMN" => [

                    "E-1" => "Damage Control Technician 3/c",
                    "E-2" => "Damage Control Technician 2/c",
                    "E-3" => "Damage Control Technician 1/c",
                    "E-4" => "Damage Control Mate 3/c",
                    "E-5" => "Damage Control Mate 2/c",
                    "E-6" => "Damage Control Mate 1/c",
                    "E-7" => "Chief Damage Control Mate",
                    "E-8" => "Senior Chief Damage Control Mate",
                    "E-9" => "Master Chief Damage Control Mate",
                    "E-10" => "Senior Master Chief Damage Control Mate"
                ],
                "GSN" => [

                    "E-1" => "Damage Control Technician 3/c",
                    "E-2" => "Damage Control Technician 2/c",
                    "E-3" => "Damage Control Technician 1/c",
                    "E-4" => "Damage Control Mate 3/c",
                    "E-5" => "Damage Control Mate 2/c",
                    "E-6" => "Damage Control Mate 1/c",
                    "E-7" => "Chief Damage Control Mate",
                    "E-8" => "Senior Chief Damage Control Mate",
                    "E-9" => "Master Chief Damage Control Mate",
                    "E-10" => "Senior Master Chief Damage Control Mate"
                ],
                "RHN" => [

                    "E-1" => "Damage Control Technician 3/c",
                    "E-2" => "Damage Control Technician 2/c",
                    "E-3" => "Damage Control Technician 1/c",
                    "E-4" => "Damage Control Mate 3/c",
                    "E-5" => "Damage Control Mate 2/c",
                    "E-6" => "Damage Control Mate 1/c",
                    "E-7" => "Chief Damage Control Mate",
                    "E-8" => "Senior Chief Damage Control Mate",
                    "E-9" => "Master Chief Damage Control Mate",
                    "E-10" => "Senior Master Chief Damage Control Mate"
                ]
            ],
            "SRN-20" => ["description" => "Storekeeper",
                "RMN" => [

                    "E-1" => "Storekeeper 3/c",
                    "E-2" => "Storekeeper 2/c",
                    "E-3" => "Storekeeper 1/c",
                    "E-4" => "Storekeeper Petty Officer 3/c",
                    "E-5" => "Storekeeper Petty Officer 2/c",
                    "E-6" => "Storekeeper Petty Officer 1/c",
                    "E-7" => "Chief Storekeeper",
                    "E-8" => "Senior Chief Storekeeper",
                    "E-9" => "Master Chief Storekeeper",
                    "E-10" => "Senior Master Chief Storekeeper"
                ],
                "GSN" => [

                    "E-1" => "Storekeeper 3/c",
                    "E-2" => "Storekeeper 2/c",
                    "E-3" => "Storekeeper 1/c",
                    "E-4" => "Storekeeper Petty Officer 3/c",
                    "E-5" => "Storekeeper Petty Officer 2/c",
                    "E-6" => "Storekeeper Petty Officer 1/c",
                    "E-7" => "Chief Storekeeper",
                    "E-8" => "Senior Chief Storekeeper",
                    "E-9" => "Master Chief Storekeeper",
                    "E-10" => "Senior Master Chief Storekeeper"
                ],
                "RHN" => [

                    "E-1" => "Storekeeper 3/c",
                    "E-2" => "Storekeeper 2/c",
                    "E-3" => "Storekeeper 1/c",
                    "E-4" => "Storekeeper Petty Officer 3/c",
                    "E-5" => "Storekeeper Petty Officer 2/c",
                    "E-6" => "Storekeeper Petty Officer 1/c",
                    "E-7" => "Chief Storekeeper",
                    "E-8" => "Senior Chief Storekeeper",
                    "E-9" => "Master Chief Storekeeper",
                    "E-10" => "Senior Master Chief Storekeeper"
                ]
            ],
            "SRN-21" => ["description" => "Disbursing Clerk",
                "RMN" => [

                    "E-1" => "Disbursing Clerk 3/c",
                    "E-2" => "Disbursing Clerk 2/c",
                    "E-3" => "Disbursing Clerk 1/c",
                    "E-4" => "Disbursing Clerk Petty Officer 3/c",
                    "E-5" => "Disbursing Clerk Petty Officer 2/c",
                    "E-6" => "Disbursing Clerk Petty Officer 1/c",
                    "E-7" => "Chief Disbursing Clerk",
                    "E-8" => "Senior Chief Disbursing Clerk",
                    "E-9" => "Master Chief Disbursing Clerk",
                    "E-10" => "Senior Master Chief Disbursing Clerk"
                ],
                "GSN" => [

                    "E-1" => "Disbursing Clerk 3/c",
                    "E-2" => "Disbursing Clerk 2/c",
                    "E-3" => "Disbursing Clerk 1/c",
                    "E-4" => "Disbursing Clerk Petty Officer 3/c",
                    "E-5" => "Disbursing Clerk Petty Officer 2/c",
                    "E-6" => "Disbursing Clerk Petty Officer 1/c",
                    "E-7" => "Chief Disbursing Clerk",
                    "E-8" => "Senior Chief Disbursing Clerk",
                    "E-9" => "Master Chief Disbursing Clerk",
                    "E-10" => "Senior Master Chief Disbursing Clerk"
                ],
                "RHN" => [

                    "E-1" => "Disbursing Clerk 3/c",
                    "E-2" => "Disbursing Clerk 2/c",
                    "E-3" => "Disbursing Clerk 1/c",
                    "E-4" => "Disbursing Clerk Petty Officer 3/c",
                    "E-5" => "Disbursing Clerk Petty Officer 2/c",
                    "E-6" => "Disbursing Clerk Petty Officer 1/c",
                    "E-7" => "Chief Disbursing Clerk",
                    "E-8" => "Senior Chief Disbursing Clerk",
                    "E-9" => "Master Chief Disbursing Clerk",
                    "E-10" => "Senior Master Chief Disbursing Clerk"
                ]
            ],
            "SRN-22" => ["description" => "Ship's Serviceman",
                "RMN" => [

                    "E-1" => "Ship's Serviceman 3/c",
                    "E-2" => "Ship's Serviceman 2/c",
                    "E-3" => "Ship's Serviceman 1/c",
                    "E-4" => "Ship's Serviceman Petty Officer 3/c",
                    "E-5" => "Ship's Serviceman Petty Officer 2/c",
                    "E-6" => "Ship's Serviceman Petty Officer 1/c",
                    "E-7" => "Chief Ship's Serviceman",
                    "E-8" => "Senior Chief Ship's Serviceman",
                    "E-9" => "Master Chief Ship's Serviceman",
                    "E-10" => "Senior Master Chief Ship's Serviceman"
                ],
                "GSN" => [

                    "E-1" => "Ship's Serviceman 3/c",
                    "E-2" => "Ship's Serviceman 2/c",
                    "E-3" => "Ship's Serviceman 1/c",
                    "E-4" => "Ship's Serviceman Petty Officer 3/c",
                    "E-5" => "Ship's Serviceman Petty Officer 2/c",
                    "E-6" => "Ship's Serviceman Petty Officer 1/c",
                    "E-7" => "Chief Ship's Serviceman",
                    "E-8" => "Senior Chief Ship's Serviceman",
                    "E-9" => "Master Chief Ship's Serviceman",
                    "E-10" => "Senior Master Chief Ship's Serviceman"
                ],
                "RHN" => [

                    "E-1" => "Ship's Serviceman 3/c",
                    "E-2" => "Ship's Serviceman 2/c",
                    "E-3" => "Ship's Serviceman 1/c",
                    "E-4" => "Ship's Serviceman Petty Officer 3/c",
                    "E-5" => "Ship's Serviceman Petty Officer 2/c",
                    "E-6" => "Ship's Serviceman Petty Officer 1/c",
                    "E-7" => "Chief Ship's Serviceman",
                    "E-8" => "Senior Chief Ship's Serviceman",
                    "E-9" => "Master Chief Ship's Serviceman",
                    "E-10" => "Senior Master Chief Ship's Serviceman"
                ]
            ],
            "SRN-23" => ["description" => "Corpsman",
                "RMN" => [

                    "E-1" => "Corpsman 3/c",
                    "E-2" => "Corpsman 2/c",
                    "E-3" => "Corpsman 1/c",
                    "E-4" => "Corpsman Petty Officer 3/c",
                    "E-5" => "Corpsman Petty Officer 2/c",
                    "E-6" => "Corpsman Petty Officer 1/c",
                    "E-7" => "Chief Corpsman",
                    "E-8" => "Senior Chief Corpsman",
                    "E-9" => "Master Chief Corpsman",
                    "E-10" => "Senior Master Chief Corpsman"
                ],
                "GSN" => [

                    "E-1" => "Corpsman 3/c",
                    "E-2" => "Corpsman 2/c",
                    "E-3" => "Corpsman 1/c",
                    "E-4" => "Corpsman Petty Officer 3/c",
                    "E-5" => "Corpsman Petty Officer 2/c",
                    "E-6" => "Corpsman Petty Officer 1/c",
                    "E-7" => "Chief Corpsman",
                    "E-8" => "Senior Chief Corpsman",
                    "E-9" => "Master Chief Corpsman",
                    "E-10" => "Senior Master Chief Corpsman"
                ],
                "RHN" => [

                    "E-1" => "Corpsman 3/c",
                    "E-2" => "Corpsman 2/c",
                    "E-3" => "Corpsman 1/c",
                    "E-4" => "Corpsman Petty Officer 3/c",
                    "E-5" => "Corpsman Petty Officer 2/c",
                    "E-6" => "Corpsman Petty Officer 1/c",
                    "E-7" => "Chief Corpsman",
                    "E-8" => "Senior Chief Corpsman",
                    "E-9" => "Master Chief Corpsman",
                    "E-10" => "Senior Master Chief Corpsman"
                ]
            ],
            "SRN-24" => ["description" => "Sick Berth Attendant",
                "RMN" => [

                    "E-1" => "Sick Berth Attendant 3/c",
                    "E-2" => "Sick Berth Attendant 2/c",
                    "E-3" => "Sick Berth Attendant 1/c",
                    "E-4" => "Sick Berth Attendant Petty Officer 3/c",
                    "E-5" => "Sick Berth Attendant Petty Officer 2/c",
                    "E-6" => "Sick Berth Attendant Petty Officer 1/c",
                    "E-7" => "Chief Sick Berth Attendant",
                    "E-8" => "Senior Chief Sick Berth Attendant",
                    "E-9" => "Master Chief Sick Berth Attendant",
                    "E-10" => "Senior Master Chief Sick Berth Attendant"
                ],
                "GSN" => [

                    "E-1" => "Sick Berth Attendant 3/c",
                    "E-2" => "Sick Berth Attendant 2/c",
                    "E-3" => "Sick Berth Attendant 1/c",
                    "E-4" => "Sick Berth Attendant Petty Officer 3/c",
                    "E-5" => "Sick Berth Attendant Petty Officer 2/c",
                    "E-6" => "Sick Berth Attendant Petty Officer 1/c",
                    "E-7" => "Chief Sick Berth Attendant",
                    "E-8" => "Senior Chief Sick Berth Attendant",
                    "E-9" => "Master Chief Sick Berth Attendant",
                    "E-10" => "Senior Master Chief Sick Berth Attendant"
                ],
                "RHN" => [

                    "E-1" => "Sick Berth Attendant 3/c",
                    "E-2" => "Sick Berth Attendant 2/c",
                    "E-3" => "Sick Berth Attendant 1/c",
                    "E-4" => "Sick Berth Attendant Petty Officer 3/c",
                    "E-5" => "Sick Berth Attendant Petty Officer 2/c",
                    "E-6" => "Sick Berth Attendant Petty Officer 1/c",
                    "E-7" => "Chief Sick Berth Attendant",
                    "E-8" => "Senior Chief Sick Berth Attendant",
                    "E-9" => "Master Chief Sick Berth Attendant",
                    "E-10" => "Senior Master Chief Sick Berth Attendant"
                ]
            ],
            "SRN-25" => ["description" => "Operations Specialist",
                "RMN" => [

                    "E-1" => "Operations Specialist 3/c",
                    "E-2" => "Operations Specialist 2/c",
                    "E-3" => "Operations Specialist 1/c",
                    "E-4" => "Operations Mate 3/c",
                    "E-5" => "Operations Mate 2/c",
                    "E-6" => "Operations Mate 1/c",
                    "E-7" => "Chief Operations Mate",
                    "E-8" => "Senior Chief Operations Mate",
                    "E-9" => "Master Chief Operations Mate",
                    "E-10" => "Senior Master Chief Operations Mate"
                ],
                "GSN" => [

                    "E-1" => "Operations Specialist 3/c",
                    "E-2" => "Operations Specialist 2/c",
                    "E-3" => "Operations Specialist 1/c",
                    "E-4" => "Operations Mate 3/c",
                    "E-5" => "Operations Mate 2/c",
                    "E-6" => "Operations Mate 1/c",
                    "E-7" => "Chief Operations Mate",
                    "E-8" => "Senior Chief Operations Mate",
                    "E-9" => "Master Chief Operations Mate",
                    "E-10" => "Senior Master Chief Operations Mate"
                ],
                "RHN" => [

                    "E-1" => "Operations Specialist 3/c",
                    "E-2" => "Operations Specialist 2/c",
                    "E-3" => "Operations Specialist 1/c",
                    "E-4" => "Operations Mate 3/c",
                    "E-5" => "Operations Mate 2/c",
                    "E-6" => "Operations Mate 1/c",
                    "E-7" => "Chief Operations Mate",
                    "E-8" => "Senior Chief Operations Mate",
                    "E-9" => "Master Chief Operations Mate",
                    "E-10" => "Senior Master Chief Operations Mate"
                ]
            ],
            "SRN-26" => ["description" => "Intelligence Specialist",
                "RMN" => [

                    "E-1" => "Intelligence Specialist 3/c",
                    "E-2" => "Intelligence Specialist 2/c",
                    "E-3" => "Intelligence Specialist 1/c",
                    "E-4" => "Intelligence Mate 3/c",
                    "E-5" => "Intelligence Mate 2/c",
                    "E-6" => "Intelligence Mate 1/c",
                    "E-7" => "Chief Intelligence Mate",
                    "E-8" => "Senior Chief Intelligence Mate",
                    "E-9" => "Master Chief Intelligence Mate",
                    "E-10" => "Senior Master Chief Intelligence Mate"
                ],
                "GSN" => [

                    "E-1" => "Intelligence Specialist 3/c",
                    "E-2" => "Intelligence Specialist 2/c",
                    "E-3" => "Intelligence Specialist 1/c",
                    "E-4" => "Intelligence Mate 3/c",
                    "E-5" => "Intelligence Mate 2/c",
                    "E-6" => "Intelligence Mate 1/c",
                    "E-7" => "Chief Intelligence Mate",
                    "E-8" => "Senior Chief Intelligence Mate",
                    "E-9" => "Master Chief Intelligence Mate",
                    "E-10" => "Senior Master Chief Intelligence Mate"
                ],
                "RHN" => [

                    "E-1" => "Intelligence Specialist 3/c",
                    "E-2" => "Intelligence Specialist 2/c",
                    "E-3" => "Intelligence Specialist 1/c",
                    "E-4" => "Intelligence Mate 3/c",
                    "E-5" => "Intelligence Mate 2/c",
                    "E-6" => "Intelligence Mate 1/c",
                    "E-7" => "Chief Intelligence Mate",
                    "E-8" => "Senior Chief Intelligence Mate",
                    "E-9" => "Master Chief Intelligence Mate",
                    "E-10" => "Senior Master Chief Intelligence Mate"
                ]
            ],
            "SRN-27" => ["description" => "Missile Technician",
                "RMN" => [

                    "E-1" => "Missile Technician 3/c",
                    "E-2" => "Missile Technician 2/c",
                    "E-3" => "Missile Technician 1/c",
                    "E-4" => "Missile Mate 3/c",
                    "E-5" => "Missile Mate 2/c",
                    "E-6" => "Missile Mate 1/c",
                    "E-7" => "Chief Missile Mate",
                    "E-8" => "Senior Chief Missile Mate",
                    "E-9" => "Master Chief Missile Mate",
                    "E-10" => "Senior Master Chief Missile Mate"
                ],
                "GSN" => [

                    "E-1" => "Missile Technician 3/c",
                    "E-2" => "Missile Technician 2/c",
                    "E-3" => "Missile Technician 1/c",
                    "E-4" => "Missile Mate 3/c",
                    "E-5" => "Missile Mate 2/c",
                    "E-6" => "Missile Mate 1/c",
                    "E-7" => "Chief Missile Mate",
                    "E-8" => "Senior Chief Missile Mate",
                    "E-9" => "Master Chief Missile Mate",
                    "E-10" => "Senior Master Chief Missile Mate"
                ],
                "RHN" => [

                    "E-1" => "Missile Technician 3/c",
                    "E-2" => "Missile Technician 2/c",
                    "E-3" => "Missile Technician 1/c",
                    "E-4" => "Missile Mate 3/c",
                    "E-5" => "Missile Mate 2/c",
                    "E-6" => "Missile Mate 1/c",
                    "E-7" => "Chief Missile Mate",
                    "E-8" => "Senior Chief Missile Mate",
                    "E-9" => "Master Chief Missile Mate",
                    "E-10" => "Senior Master Chief Missile Mate"
                ]
            ],
            "SRN-28" => ["description" => "Beam Weapons Technician",
                "RMN" => [

                    "E-1" => "Beam Weapons Technician 3/c",
                    "E-2" => "Beam Weapons Technician 2/c",
                    "E-3" => "Beam Weapons Technician 1/c",
                    "E-4" => "Beam Weapons Mate 3/c",
                    "E-5" => "Beam Weapons Mate 2/c",
                    "E-6" => "Beam Weapons Mate 1/c",
                    "E-7" => "Chief Beam Weapons Mate",
                    "E-8" => "Senior Chief Beam Weapons Mate",
                    "E-9" => "Master Chief Beam Weapons Mate",
                    "E-10" => "Senior Master Chief Beam Weapons Mate"
                ],
                "GSN" => [

                    "E-1" => "Beam Weapons Technician 3/c",
                    "E-2" => "Beam Weapons Technician 2/c",
                    "E-3" => "Beam Weapons Technician 1/c",
                    "E-4" => "Beam Weapons Mate 3/c",
                    "E-5" => "Beam Weapons Mate 2/c",
                    "E-6" => "Beam Weapons Mate 1/c",
                    "E-7" => "Chief Beam Weapons Mate",
                    "E-8" => "Senior Chief Beam Weapons Mate",
                    "E-9" => "Master Chief Beam Weapons Mate",
                    "E-10" => "Senior Master Chief Beam Weapons Mate"
                ],
                "RHN" => [

                    "E-1" => "Beam Weapons Technician 3/c",
                    "E-2" => "Beam Weapons Technician 2/c",
                    "E-3" => "Beam Weapons Technician 1/c",
                    "E-4" => "Beam Weapons Mate 3/c",
                    "E-5" => "Beam Weapons Mate 2/c",
                    "E-6" => "Beam Weapons Mate 1/c",
                    "E-7" => "Chief Beam Weapons Mate",
                    "E-8" => "Senior Chief Beam Weapons Mate",
                    "E-9" => "Master Chief Beam Weapons Mate",
                    "E-10" => "Senior Master Chief Beam Weapons Mate"
                ]
            ],
            "SRN-29" => ["description" => "Gunner",
                "RMN" => [

                    "E-1" => "Gunner 3/c",
                    "E-2" => "Gunner 2/c",
                    "E-3" => "Gunner 1/c",
                    "E-4" => "Gunner's Mate 3/c",
                    "E-5" => "Gunner's Mate 2/c",
                    "E-6" => "Gunner's Mate 1/c",
                    "E-7" => "Chief Gunner's Mate",
                    "E-8" => "Senior Chief Gunner's Mate",
                    "E-9" => "Master Chief Gunner's Mate",
                    "E-10" => "Senior Master Chief Gunner's Mate"
                ],
                "GSN" => [

                    "E-1" => "Gunner 3/c",
                    "E-2" => "Gunner 2/c",
                    "E-3" => "Gunner 1/c",
                    "E-4" => "Gunner's Mate 3/c",
                    "E-5" => "Gunner's Mate 2/c",
                    "E-6" => "Gunner's Mate 1/c",
                    "E-7" => "Chief Gunner's Mate",
                    "E-8" => "Senior Chief Gunner's Mate",
                    "E-9" => "Master Chief Gunner's Mate",
                    "E-10" => "Senior Master Chief Gunner's Mate"
                ],
                "RHN" => [

                    "E-1" => "Gunner 3/c",
                    "E-2" => "Gunner 2/c",
                    "E-3" => "Gunner 1/c",
                    "E-4" => "Gunner's Mate 3/c",
                    "E-5" => "Gunner's Mate 2/c",
                    "E-6" => "Gunner's Mate 1/c",
                    "E-7" => "Chief Gunner's Mate",
                    "E-8" => "Senior Chief Gunner's Mate",
                    "E-9" => "Master Chief Gunner's Mate",
                    "E-10" => "Senior Master Chief Gunner's Mate"
                ]
            ],
            "SRN-30" => ["description" => "Boatswain",
                "RMN" => [

                    "E-1" => "Boatswain 3/c",
                    "E-2" => "Boatswain 2/c",
                    "E-3" => "Boatswain 1/c",
                    "E-4" => "Boatswain's Mate 3/c",
                    "E-5" => "Boatswain's Mate 2/c",
                    "E-6" => "Boatswain's Mate 1/c",
                    "E-7" => "Chief Boatswain's Mate",
                    "E-8" => "Senior Chief Boatswain's Mate",
                    "E-9" => "Master Chief Boatswain's Mate",
                    "E-10" => "Senior Master Chief Boatswain's Mate"
                ],
                "GSN" => [

                    "E-1" => "Boatswain 3/c",
                    "E-2" => "Boatswain 2/c",
                    "E-3" => "Boatswain 1/c",
                    "E-4" => "Boatswain's Mate 3/c",
                    "E-5" => "Boatswain's Mate 2/c",
                    "E-6" => "Boatswain's Mate 1/c",
                    "E-7" => "Chief Boatswain's Mate",
                    "E-8" => "Senior Chief Boatswain's Mate",
                    "E-9" => "Master Chief Boatswain's Mate",
                    "E-10" => "Senior Master Chief Boatswain's Mate"
                ],
                "RHN" => [

                    "E-1" => "Boatswain 3/c",
                    "E-2" => "Boatswain 2/c",
                    "E-3" => "Boatswain 1/c",
                    "E-4" => "Boatswain's Mate 3/c",
                    "E-5" => "Boatswain's Mate 2/c",
                    "E-6" => "Boatswain's Mate 1/c",
                    "E-7" => "Chief Boatswain's Mate",
                    "E-8" => "Senior Chief Boatswain's Mate",
                    "E-9" => "Master Chief Boatswain's Mate",
                    "E-10" => "Senior Master Chief Boatswain's Mate"
                ]
            ],
            "SRN-31" => ["description" => "Master-at-Arms",
                "RMN" => [

                    "E-1" => "Master-at-Arms 3/c",
                    "E-2" => "Master-at-Arms 2/c",
                    "E-3" => "Master-at-Arms 1/c",
                    "E-4" => "Master-at-Arms Mate 3/c",
                    "E-5" => "Master-at-Arms Mate 2/c",
                    "E-6" => "Master-at-Arms Mate 1/c",
                    "E-7" => "Chief Master-at-Arms Mate",
                    "E-8" => "Senior Chief Master-at-Arms Mate",
                    "E-9" => "Master Chief Master-at-Arms Mate",
                    "E-10" => "Senior Master Chief Master-at-Arms Mate"
                ],
                "GSN" => [

                    "E-1" => "Master-at-Arms 3/c",
                    "E-2" => "Master-at-Arms 2/c",
                    "E-3" => "Master-at-Arms 1/c",
                    "E-4" => "Master-at-Arms Mate 3/c",
                    "E-5" => "Master-at-Arms Mate 2/c",
                    "E-6" => "Master-at-Arms Mate 1/c",
                    "E-7" => "Chief Master-at-Arms Mate",
                    "E-8" => "Senior Chief Master-at-Arms Mate",
                    "E-9" => "Master Chief Master-at-Arms Mate",
                    "E-10" => "Senior Master Chief Master-at-Arms Mate"
                ],
                "RHN" => [

                    "E-1" => "Master-at-Arms 3/c",
                    "E-2" => "Master-at-Arms 2/c",
                    "E-3" => "Master-at-Arms 1/c",
                    "E-4" => "Master-at-Arms Mate 3/c",
                    "E-5" => "Master-at-Arms Mate 2/c",
                    "E-6" => "Master-at-Arms Mate 1/c",
                    "E-7" => "Chief Master-at-Arms Mate",
                    "E-8" => "Senior Chief Master-at-Arms Mate",
                    "E-9" => "Master Chief Master-at-Arms Mate",
                    "E-10" => "Senior Master Chief Master-at-Arms Mate"
                ]
            ],
            "SRN-32" => ["description" => "Sensor Technician",
                "RMN" => [

                    "E-1" => "Sensor Technician 3/c",
                    "E-2" => "Sensor Technician 2/c",
                    "E-3" => "Sensor Technician 1/c",
                    "E-4" => "Sensor Mate 3/c",
                    "E-5" => "Sensor Mate 2/c",
                    "E-6" => "Sensor Mate 1/c",
                    "E-7" => "Chief Sensor Mate",
                    "E-8" => "Senior Chief Sensor Mate",
                    "E-9" => "Master Chief Sensor Mate",
                    "E-10" => "Senior Master Chief Sensor Mate"
                ],
                "GSN" => [

                    "E-1" => "Sensor Technician 3/c",
                    "E-2" => "Sensor Technician 2/c",
                    "E-3" => "Sensor Technician 1/c",
                    "E-4" => "Sensor Mate 3/c",
                    "E-5" => "Sensor Mate 2/c",
                    "E-6" => "Sensor Mate 1/c",
                    "E-7" => "Chief Sensor Mate",
                    "E-8" => "Senior Chief Sensor Mate",
                    "E-9" => "Master Chief Sensor Mate",
                    "E-10" => "Senior Master Chief Sensor Mate"
                ],
                "RHN" => [

                    "E-1" => "Sensor Technician 3/c",
                    "E-2" => "Sensor Technician 2/c",
                    "E-3" => "Sensor Technician 1/c",
                    "E-4" => "Sensor Mate 3/c",
                    "E-5" => "Sensor Mate 2/c",
                    "E-6" => "Sensor Mate 1/c",
                    "E-7" => "Chief Sensor Mate",
                    "E-8" => "Senior Chief Sensor Mate",
                    "E-9" => "Master Chief Sensor Mate",
                    "E-10" => "Senior Master Chief Sensor Mate"
                ]
            ],
            "SRMC-01" => ["description" => "Armorer",
                "RMMC" => [

                ],
            ],

            "SRMC-02" => ["description" => "Marine Police",
                "RMMC" => [

                ],
            ],

            "SRMC-03" => ["description" => "Missile Crew",
                "RMMC" => [

                ],
            ],

            "SRMC-04" => ["description" => "LASER/GRASER Crew",
                "RMMC" => [

                ],
            ],

            "SRMC-05" => ["description" => "Assault Marine",
                "RMMC" => [

                ],
            ],

            "SRMC-06" => ["description" => "Recon Marine",
                "RMMC" => [

                ],
            ],

            "SRMC-07" => ["description" => "Rifleman/Grenadier",
                "RMMC" => [

                ],
            ],

            "SRMC-08" => ["description" => "Heavy Weapons",
                "RMMC" => [

                ],
            ],

            "SRMC-09" => ["description" => "Admin Specialist",
                "RMMC" => [

                ],
            ],

            "SRMC-10" => ["description" => "Embassy Guard",
                "RMMC" => [

                ],
            ],

            "RMAT-09" => ["description" => "Skimmer Crewman",
                "RMA" => [

                ],
            ],

            "RMAT-03" => ["description" => "Tank Crewman",
                "RMA" => [

                ],
            ],

            "RMAT-05" => ["description" => "Stingship Pilot",
                "RMA" => [

                ],
            ],

            "RMAT-10" => ["description" => "Cargo Skimmer Pilot",
                "RMA" => [

                ],
            ],

            "RMAT-06" => ["description" => "Indirect Fire Specialist",
                "RMA" => [

                ],
            ],

            "RMAT-11" => ["description" => "Air Defense Specialist",
                "RMA" => [

                ],
            ],

            "RMAT-12" => ["description" => "Orbital Defense Specialist",
                "RMA" => [

                ],
            ],

            "RMAT-13" => ["description" => "Combat Engineer",
                "RMA" => [

                ],
            ],

            "RMAT-01" => ["description" => "Armorer",
                "RMA" => [

                ],
            ],

            "RMAT-08" => ["description" => "Infantryman",
                "RMA" => [

                ],
            ],

            "RMAT-14" => ["description" => "Assault Specialist (Battle Armor)",
                "RMA" => [

                ],
            ],

            "RMAT-04" => ["description" => "Reconnaissance Specialist",
                "RMA" => [

                ],
            ],

            "RMAT-15" => ["description" => "Military Criminal Investigator",
                "RMA" => [

                ],
            ],

            "RMAT-02" => ["description" => "Military Police",
                "RMA" => [

                ],
            ],

            "RMAT-16" => ["description" => "Military Law Specialist",
                "RMA" => [

                ],
            ],

            "RMAT-07" => ["description" => "Administrative Specialist",
                "RMA" => [

                ],
            ],

            "RMAT-17" => ["description" => "Logistics Specialist",
                "RMA" => [

                ],
            ],

            "RMAT-18" => ["description" => "Finance Specialist",
                "RMA" => [

                ],
            ]

        ];


        foreach ($ratings as $rating => $description) {

            $this->writeAuditTrail(
                'db:seed',
                'create',
                'ratings',
                null,
                json_encode(["rate_code" => $rating, "rate" => $description]),
                'rating'
            );

            Rating::create(["rate_code" => $rating, "rate" => $description]);
        }
    }
}
