<?php

class RatingSeeder extends Seeder
{
    public function run()
    {
        DB::collection('ratings')->delete();

        $ratings = [
            "SRN-01" => ["description" => "Personnelman",
                "RMN" => [

                    "E1" => "Personnelman 3/c",
                    "E2" => "Personnelman 2/c",
                    "E3" => "Personnelman 1/c",
                    "E4" => "Personnelman Petty Officer 3/c",
                    "E5" => "Personnelman Petty Officer 2/c",
                    "E6" => "Personnelman Petty Officer 1/c",
                    "E7" => "Chief Personnelman",
                    "E8" => "Senior Chief Personnelman",
                    "E9" => "Master Chief Personnelman",
                    "E10" => "Senior Master Chief Personnelman"
                ],
                "GSN" => [

                    "E1" => "Personnelman 3/c",
                    "E2" => "Personnelman 2/c",
                    "E3" => "Personnelman 1/c",
                    "E4" => "Personnelman Petty Officer 3/c",
                    "E5" => "Personnelman Petty Officer 2/c",
                    "E6" => "Personnelman Petty Officer 1/c",
                    "E7" => "Chief Personnelman",
                    "E8" => "Senior Chief Personnelman",
                    "E9" => "Master Chief Personnelman",
                    "E10" => "Senior Master Chief Personnelman"
                ],
                "RHN" => [

                    "E1" => "Personnelman 3/c",
                    "E2" => "Personnelman 2/c",
                    "E3" => "Personnelman 1/c",
                    "E4" => "Personnelman Petty Officer 3/c",
                    "E5" => "Personnelman Petty Officer 2/c",
                    "E6" => "Personnelman Petty Officer 1/c",
                    "E7" => "Chief Personnelman",
                    "E8" => "Senior Chief Personnelman",
                    "E9" => "Master Chief Personnelman",
                    "E10" => "Senior Master Chief Personnelman"
                ]
            ],
            "SRN-02" => ["description" => "Navy Counselor",
                "RMN" => [

                    "E1" => "Navy Counselor 3/c",
                    "E2" => "Navy Counselor 2/c",
                    "E3" => "Navy Counselor 1/c",
                    "E4" => "Navy Counselor Petty Officer 3/c",
                    "E5" => "Navy Counselor Petty Officer 2/c",
                    "E6" => "Navy Counselor Petty Officer 1/c",
                    "E7" => "Chief Navy Counselor",
                    "E8" => "Senior Chief Navy Counselor",
                    "E9" => "Master Chief Navy Counselor",
                    "E10" => "Senior Master Chief Navy Counselor"
                ],
                "GSN" => [

                    "E1" => "Navy Counselor 3/c",
                    "E2" => "Navy Counselor 2/c",
                    "E3" => "Navy Counselor 1/c",
                    "E4" => "Navy Counselor Petty Officer 3/c",
                    "E5" => "Navy Counselor Petty Officer 2/c",
                    "E6" => "Navy Counselor Petty Officer 1/c",
                    "E7" => "Chief Navy Counselor",
                    "E8" => "Senior Chief Navy Counselor",
                    "E9" => "Master Chief Navy Counselor",
                    "E10" => "Senior Master Chief Navy Counselor"
                ],
                "RHN" => [

                    "E1" => "Navy Counselor 3/c",
                    "E2" => "Navy Counselor 2/c",
                    "E3" => "Navy Counselor 1/c",
                    "E4" => "Navy Counselor Petty Officer 3/c",
                    "E5" => "Navy Counselor Petty Officer 2/c",
                    "E6" => "Navy Counselor Petty Officer 1/c",
                    "E7" => "Chief Navy Counselor",
                    "E8" => "Senior Chief Navy Counselor",
                    "E9" => "Master Chief Navy Counselor",
                    "E10" => "Senior Master Chief Navy Counselor"
                ],
            ],
            "SRN-03" => ["description" => "Steward",
                "RMN" => [

                    "E1" => "Steward 3/c",
                    "E2" => "Steward 2/c",
                    "E3" => "Steward 1/c",
                    "E4" => "Steward Petty Officer 3/c",
                    "E5" => "Steward Petty Officer 2/c",
                    "E6" => "Steward Petty Officer 1/c",
                    "E7" => "Chief Steward",
                    "E8" => "Senior Chief Steward",
                    "E9" => "Master Chief Steward",
                    "E10" => "Senior Master Chief Steward"
                ],
                "GSN" => [

                    "E1" => "Steward 3/c",
                    "E2" => "Steward 2/c",
                    "E3" => "Steward 1/c",
                    "E4" => "Steward Petty Officer 3/c",
                    "E5" => "Steward Petty Officer 2/c",
                    "E6" => "Steward Petty Officer 1/c",
                    "E7" => "Chief Steward",
                    "E8" => "Senior Chief Steward",
                    "E9" => "Master Chief Steward",
                    "E10" => "Senior Master Chief Steward"
                ],
                "RHN" => [

                    "E1" => "Steward 3/c",
                    "E2" => "Steward 2/c",
                    "E3" => "Steward 1/c",
                    "E4" => "Steward Petty Officer 3/c",
                    "E5" => "Steward Petty Officer 2/c",
                    "E6" => "Steward Petty Officer 1/c",
                    "E7" => "Chief Steward",
                    "E8" => "Senior Chief Steward",
                    "E9" => "Master Chief Steward",
                    "E10" => "Senior Master Chief Steward"
                ],
            ],
            "SRN-04" => ["description" => "Yeoman",
                "RMN" => [

                    "E1" => "Yeoman 3/c",
                    "E2" => "Yeoman 2/c",
                    "E3" => "Yeoman 1/c",
                    "E4" => "Yeoman Petty Officer 3/c",
                    "E5" => "Yeoman Petty Officer 2/c",
                    "E6" => "Yeoman Petty Officer 1/c",
                    "E7" => "Chief Yeoman",
                    "E8" => "Senior Chief Yeoman",
                    "E9" => "Master Chief Yeoman",
                    "E10" => "Senior Master Chief Yeoman"
                ],
                "GSN" => [

                    "E1" => "Yeoman 3/c",
                    "E2" => "Yeoman 2/c",
                    "E3" => "Yeoman 1/c",
                    "E4" => "Yeoman Petty Officer 3/c",
                    "E5" => "Yeoman Petty Officer 2/c",
                    "E6" => "Yeoman Petty Officer 1/c",
                    "E7" => "Chief Yeoman",
                    "E8" => "Senior Chief Yeoman",
                    "E9" => "Master Chief Yeoman",
                    "E10" => "Senior Master Chief Yeoman"
                ],
                "RHN" => [

                    "E1" => "Yeoman 3/c",
                    "E2" => "Yeoman 2/c",
                    "E3" => "Yeoman 1/c",
                    "E4" => "Yeoman Petty Officer 3/c",
                    "E5" => "Yeoman Petty Officer 2/c",
                    "E6" => "Yeoman Petty Officer 1/c",
                    "E7" => "Chief Yeoman",
                    "E8" => "Senior Chief Yeoman",
                    "E9" => "Master Chief Yeoman",
                    "E10" => "Senior Master Chief Yeoman"
                ],
            ],
            "SRN-05" => ["description" => "Coxswain",
                "RMN" => [

                    "E1" => "Coxswain 3/c",
                    "E2" => "Coxswain 2/c",
                    "E3" => "Coxswain 1/c",
                    "E4" => "Coxswain Petty Officer 3/c",
                    "E5" => "Coxswain Petty Officer 2/c",
                    "E6" => "Coxswain Petty Officer 1/c",
                    "E7" => "Chief Coxswain",
                    "E8" => "Senior Chief Coxswain",
                    "E9" => "Master Chief Coxswain",
                    "E10" => "Senior Master Chief Coxswain"
                ],
                "GSN" => [

                    "E1" => "Coxswain 3/c",
                    "E2" => "Coxswain 2/c",
                    "E3" => "Coxswain 1/c",
                    "E4" => "Coxswain Petty Officer 3/c",
                    "E5" => "Coxswain Petty Officer 2/c",
                    "E6" => "Coxswain Petty Officer 1/c",
                    "E7" => "Chief Coxswain",
                    "E8" => "Senior Chief Coxswain",
                    "E9" => "Master Chief Coxswain",
                    "E10" => "Senior Master Chief Coxswain"
                ],
                "RHN" => [

                    "E1" => "Coxswain 3/c",
                    "E2" => "Coxswain 2/c",
                    "E3" => "Coxswain 1/c",
                    "E4" => "Coxswain Petty Officer 3/c",
                    "E5" => "Coxswain Petty Officer 2/c",
                    "E6" => "Coxswain Petty Officer 1/c",
                    "E7" => "Chief Coxswain",
                    "E8" => "Senior Chief Coxswain",
                    "E9" => "Master Chief Coxswain",
                    "E10" => "Senior Master Chief Coxswain"
                ],
            ],
            "SRN-06" => ["description" => "Helmsman",
                "RMN" => [

                    "E1" => "Helmsman 3/c",
                    "E2" => "Helmsman 2/c",
                    "E3" => "Helmsman 1/c",
                    "E4" => "Helmsman Petty Officer 3/c",
                    "E5" => "Helmsman Petty Officer 2/c",
                    "E6" => "Helmsman Petty Officer 1/c",
                    "E7" => "Chief Helmsman",
                    "E8" => "Senior Chief Helmsman",
                    "E9" => "Master Chief Helmsman",
                    "E10" => "Senior Master Chief Helmsman"
                ],
                "GSN" => [

                    "E1" => "Helmsman 3/c",
                    "E2" => "Helmsman 2/c",
                    "E3" => "Helmsman 1/c",
                    "E4" => "Helmsman Petty Officer 3/c",
                    "E5" => "Helmsman Petty Officer 2/c",
                    "E6" => "Helmsman Petty Officer 1/c",
                    "E7" => "Chief Helmsman",
                    "E8" => "Senior Chief Helmsman",
                    "E9" => "Master Chief Helmsman",
                    "E10" => "Senior Master Chief Helmsman"
                ],
                "RHN" => [

                    "E1" => "Helmsman 3/c",
                    "E2" => "Helmsman 2/c",
                    "E3" => "Helmsman 1/c",
                    "E4" => "Helmsman Petty Officer 3/c",
                    "E5" => "Helmsman Petty Officer 2/c",
                    "E6" => "Helmsman Petty Officer 1/c",
                    "E7" => "Chief Helmsman",
                    "E8" => "Senior Chief Helmsman",
                    "E9" => "Master Chief Helmsman",
                    "E10" => "Senior Master Chief Helmsman"
                ],
            ],
            "SRN-07" => ["description" => "Plotting Specialist",
                "RMN" => [

                    "E1" => "Plotting Specialist 3/c",
                    "E2" => "Plotting Specialist 2/c",
                    "E3" => "Plotting Specialist 1/c",
                    "E4" => "Plotting Mate 3/c",
                    "E5" => "Plotting Mate 2/c",
                    "E6" => "Plotting Mate 1/c",
                    "E7" => "Chief Plotting Mate",
                    "E8" => "Senior Chief Plotting Mate",
                    "E9" => "Master Chief Plotting Mate",
                    "E10" => "Senior Master Chief Plotting Mate"
                ],
                "GSN" => [

                    "E1" => "Plotting Specialist 3/c",
                    "E2" => "Plotting Specialist 2/c",
                    "E3" => "Plotting Specialist 1/c",
                    "E4" => "Plotting Mate 3/c",
                    "E5" => "Plotting Mate 2/c",
                    "E6" => "Plotting Mate 1/c",
                    "E7" => "Chief Plotting Mate",
                    "E8" => "Senior Chief Plotting Mate",
                    "E9" => "Master Chief Plotting Mate",
                    "E10" => "Senior Master Chief Plotting Mate"
                ],
                "RHN" => [

                    "E1" => "Plotting Specialist 3/c",
                    "E2" => "Plotting Specialist 2/c",
                    "E3" => "Plotting Specialist 1/c",
                    "E4" => "Plotting Mate 3/c",
                    "E5" => "Plotting Mate 2/c",
                    "E6" => "Plotting Mate 1/c",
                    "E7" => "Chief Plotting Mate",
                    "E8" => "Senior Chief Plotting Mate",
                    "E9" => "Master Chief Plotting Mate",
                    "E10" => "Senior Master Chief Plotting Mate"
                ],
            ],
            "SRN-08" => ["description" => "Fire Control Technician",
                "RMN" => [

                    "E1" => "Fire Control Technician 3/c",
                    "E2" => "Fire Control Technician 2/c",
                    "E3" => "Fire Control Technician 1/c",
                    "E4" => "Fire Control Mate 3/c",
                    "E5" => "Fire Control Mate 2/c",
                    "E6" => "Fire Control Mate 1/c",
                    "E7" => "Chief Fire Control Mate",
                    "E8" => "Senior Chief Fire Control Mate",
                    "E9" => "Master Chief Fire Control Mate",
                    "E10" => "Senior Master Chief Fire Control Mate"
                ],
                "GSN" => [

                    "E1" => "Fire Control Technician 3/c",
                    "E2" => "Fire Control Technician 2/c",
                    "E3" => "Fire Control Technician 1/c",
                    "E4" => "Fire Control Mate 3/c",
                    "E5" => "Fire Control Mate 2/c",
                    "E6" => "Fire Control Mate 1/c",
                    "E7" => "Chief Fire Control Mate",
                    "E8" => "Senior Chief Fire Control Mate",
                    "E9" => "Master Chief Fire Control Mate",
                    "E10" => "Senior Master Chief Fire Control Mate"
                ],
                "RHN" => [

                    "E1" => "Fire Control Technician 3/c",
                    "E2" => "Fire Control Technician 2/c",
                    "E3" => "Fire Control Technician 1/c",
                    "E4" => "Fire Control Mate 3/c",
                    "E5" => "Fire Control Mate 2/c",
                    "E6" => "Fire Control Mate 1/c",
                    "E7" => "Chief Fire Control Mate",
                    "E8" => "Senior Chief Fire Control Mate",
                    "E9" => "Master Chief Fire Control Mate",
                    "E10" => "Senior Master Chief Fire Control Mate"
                ],
            ],
            "SRN-09" => ["description" => "Electronic Warfare Technician",
                "RMN" => [

                    "E1" => "Electronic Warfare Technician 3/c",
                    "E2" => "Electronic Warfare Technician 2/c",
                    "E3" => "Electronic Warfare Technician 1/c",
                    "E4" => "Electronic Warfare Mate 3/c",
                    "E5" => "Electronic Warfare Mate 2/c",
                    "E6" => "Electronic Warfare Mate 1/c",
                    "E7" => "Chief Electronic Warfare Mate",
                    "E8" => "Senior Chief Electronic Warfare Mate",
                    "E9" => "Master Chief Electronic Warfare Mate",
                    "E10" => "Senior Master Chief Electronic Warfare Mate"
                ],
                "GSN" => [

                    "E1" => "Electronic Warfare Technician 3/c",
                    "E2" => "Electronic Warfare Technician 2/c",
                    "E3" => "Electronic Warfare Technician 1/c",
                    "E4" => "Electronic Warfare Mate 3/c",
                    "E5" => "Electronic Warfare Mate 2/c",
                    "E6" => "Electronic Warfare Mate 1/c",
                    "E7" => "Chief Electronic Warfare Mate",
                    "E8" => "Senior Chief Electronic Warfare Mate",
                    "E9" => "Master Chief Electronic Warfare Mate",
                    "E10" => "Senior Master Chief Electronic Warfare Mate"
                ],
                "RHN" => [

                    "E1" => "Electronic Warfare Technician 3/c",
                    "E2" => "Electronic Warfare Technician 2/c",
                    "E3" => "Electronic Warfare Technician 1/c",
                    "E4" => "Electronic Warfare Mate 3/c",
                    "E5" => "Electronic Warfare Mate 2/c",
                    "E6" => "Electronic Warfare Mate 1/c",
                    "E7" => "Chief Electronic Warfare Mate",
                    "E8" => "Senior Chief Electronic Warfare Mate",
                    "E9" => "Master Chief Electronic Warfare Mate",
                    "E10" => "Senior Master Chief Electronic Warfare Mate"
                ],
            ],
            "SRN-10" => ["description" => "Tracking Specialist",
                "RMN" => [

                    "E1" => "Tracking Specialist 3/c",
                    "E2" => "Tracking Specialist 2/c",
                    "E3" => "Tracking Specialist 1/c",
                    "E4" => "Tracking Mate 3/c",
                    "E5" => "Tracking Mate 2/c",
                    "E6" => "Tracking Mate 1/c",
                    "E7" => "Chief Tracking Mate",
                    "E8" => "Senior Chief Tracking Mate",
                    "E9" => "Master Chief Tracking Mate",
                    "E10" => "Senior Master Chief Tracking Mate"
                ],
                "GSN" => [

                    "E1" => "Tracking Specialist 3/c",
                    "E2" => "Tracking Specialist 2/c",
                    "E3" => "Tracking Specialist 1/c",
                    "E4" => "Tracking Mate 3/c",
                    "E5" => "Tracking Mate 2/c",
                    "E6" => "Tracking Mate 1/c",
                    "E7" => "Chief Tracking Mate",
                    "E8" => "Senior Chief Tracking Mate",
                    "E9" => "Master Chief Tracking Mate",
                    "E10" => "Senior Master Chief Tracking Mate"
                ],
                "RHN" => [

                    "E1" => "Tracking Specialist 3/c",
                    "E2" => "Tracking Specialist 2/c",
                    "E3" => "Tracking Specialist 1/c",
                    "E4" => "Tracking Mate 3/c",
                    "E5" => "Tracking Mate 2/c",
                    "E6" => "Tracking Mate 1/c",
                    "E7" => "Chief Tracking Mate",
                    "E8" => "Senior Chief Tracking Mate",
                    "E9" => "Master Chief Tracking Mate",
                    "E10" => "Senior Master Chief Tracking Mate"
                ]
            ],
            "SRN-11" => ["description" => "Data System Technician",
                "RMN" => [

                    "E1" => "Data Systems Technician 3/c",
                    "E2" => "Data Systems Technician 2/c",
                    "E3" => "Data Systems Technician 1/c",
                    "E4" => "Data Systems Mate 3/c",
                    "E5" => "Data Systems Mate 2/c",
                    "E6" => "Data Systems Mate 1/c",
                    "E7" => "Chief Data Systems Mate",
                    "E8" => "Senior Chief Data Systems Mate",
                    "E9" => "Master Chief Data Systems Mate",
                    "E10" => "Senior Master Chief Data Systems Mate"
                ],
                "GSN" => [

                    "E1" => "Data Systems Technician 3/c",
                    "E2" => "Data Systems Technician 2/c",
                    "E3" => "Data Systems Technician 1/c",
                    "E4" => "Data Systems Mate 3/c",
                    "E5" => "Data Systems Mate 2/c",
                    "E6" => "Data Systems Mate 1/c",
                    "E7" => "Chief Data Systems Mate",
                    "E8" => "Senior Chief Data Systems Mate",
                    "E9" => "Master Chief Data Systems Mate",
                    "E10" => "Senior Master Chief Data Systems Mate"
                ],
                "RHN" => [

                    "E1" => "Data Systems Technician 3/c",
                    "E2" => "Data Systems Technician 2/c",
                    "E3" => "Data Systems Technician 1/c",
                    "E4" => "Data Systems Mate 3/c",
                    "E5" => "Data Systems Mate 2/c",
                    "E6" => "Data Systems Mate 1/c",
                    "E7" => "Chief Data Systems Mate",
                    "E8" => "Senior Chief Data Systems Mate",
                    "E9" => "Master Chief Data Systems Mate",
                    "E10" => "Senior Master Chief Data Systems Mate"
                ]
            ],
            "SRN-12" => ["description" => "Electronics Technician",
                "RMN" => [

                    "E1" => "Electronics Technician 3/c",
                    "E2" => "Electronics Technician 2/c",
                    "E3" => "Electronics Technician 1/c",
                    "E4" => "Electronics Mate 3/c",
                    "E5" => "Electronics Mate 2/c",
                    "E6" => "Electronics Mate 1/c",
                    "E7" => "Chief Electronics Mate",
                    "E8" => "Senior Chief Electronics Mate",
                    "E9" => "Master Chief Electronics Mate",
                    "E10" => "Senior Master Chief Electronics Mate"
                ],
                "GSN" => [

                    "E1" => "Electronics Technician 3/c",
                    "E2" => "Electronics Technician 2/c",
                    "E3" => "Electronics Technician 1/c",
                    "E4" => "Electronics Mate 3/c",
                    "E5" => "Electronics Mate 2/c",
                    "E6" => "Electronics Mate 1/c",
                    "E7" => "Chief Electronics Mate",
                    "E8" => "Senior Chief Electronics Mate",
                    "E9" => "Master Chief Electronics Mate",
                    "E10" => "Senior Master Chief Electronics Mate"
                ],
                "RHN" => [

                    "E1" => "Electronics Technician 3/c",
                    "E2" => "Electronics Technician 2/c",
                    "E3" => "Electronics Technician 1/c",
                    "E4" => "Electronics Mate 3/c",
                    "E5" => "Electronics Mate 2/c",
                    "E6" => "Electronics Mate 1/c",
                    "E7" => "Chief Electronics Mate",
                    "E8" => "Senior Chief Electronics Mate",
                    "E9" => "Master Chief Electronics Mate",
                    "E10" => "Senior Master Chief Electronics Mate"
                ]
            ],
            "SRN-13" => ["description" => "Communications Technician",
                "RMN" => [

                    "E1" => "Communications Technician 3/c",
                    "E2" => "Communications Technician 2/c",
                    "E3" => "Communications Technician 1/c",
                    "E4" => "Communications Mate 3/c",
                    "E5" => "Communications Mate 2/c",
                    "E6" => "Communications Mate 1/c",
                    "E7" => "Chief Communications Mate",
                    "E8" => "Senior Chief Communications Mate",
                    "E9" => "Master Chief Communications Mate",
                    "E10" => "Senior Master Chief Communications Mate"
                ],
                "GSN" => [
                    "description" => "Communications Technician",
                    "E1" => "Communications Technician 3/c",
                    "E2" => "Communications Technician 2/c",
                    "E3" => "Communications Technician 1/c",
                    "E4" => "Communications Mate 3/c",
                    "E5" => "Communications Mate 2/c",
                    "E6" => "Communications Mate 1/c",
                    "E7" => "Chief Communications Mate",
                    "E8" => "Senior Chief Communications Mate",
                    "E9" => "Master Chief Communications Mate",
                    "E10" => "Senior Master Chief Communications Mate"
                ],
                "RHN" => [

                    "E1" => "Communications Technician 3/c",
                    "E2" => "Communications Technician 2/c",
                    "E3" => "Communications Technician 1/c",
                    "E4" => "Communications Mate 3/c",
                    "E5" => "Communications Mate 2/c",
                    "E6" => "Communications Mate 1/c",
                    "E7" => "Chief Communications Mate",
                    "E8" => "Senior Chief Communications Mate",
                    "E9" => "Master Chief Communications Mate",
                    "E10" => "Senior Master Chief Communications Mate"
                ]
            ],
            "SRN-14" => ["description" => "Impeller Technician",
                "RMN" => [

                    "E1" => "Impeller Technician 3/c",
                    "E2" => "Impeller Technician 2/c",
                    "E3" => "Impeller Technician 1/c",
                    "E4" => "Impeller Mate 3/c",
                    "E5" => "Impeller Mate 2/c",
                    "E6" => "Impeller Mate 1/c",
                    "E7" => "Chief Impeller Mate",
                    "E8" => "Senior Chief Impeller Mate",
                    "E9" => "Master Chief Impeller Mate",
                    "E10" => "Senior Master Chief Impeller Mate"
                ],
                "GSN" => [

                    "E1" => "Impeller Technician 3/c",
                    "E2" => "Impeller Technician 2/c",
                    "E3" => "Impeller Technician 1/c",
                    "E4" => "Impeller Mate 3/c",
                    "E5" => "Impeller Mate 2/c",
                    "E6" => "Impeller Mate 1/c",
                    "E7" => "Chief Impeller Mate",
                    "E8" => "Senior Chief Impeller Mate",
                    "E9" => "Master Chief Impeller Mate",
                    "E10" => "Senior Master Chief Impeller Mate"
                ],
                "RHN" => [

                    "E1" => "Impeller Technician 3/c",
                    "E2" => "Impeller Technician 2/c",
                    "E3" => "Impeller Technician 1/c",
                    "E4" => "Impeller Mate 3/c",
                    "E5" => "Impeller Mate 2/c",
                    "E6" => "Impeller Mate 1/c",
                    "E7" => "Chief Impeller Mate",
                    "E8" => "Senior Chief Impeller Mate",
                    "E9" => "Master Chief Impeller Mate",
                    "E10" => "Senior Master Chief Impeller Mate"
                ]
            ],
            "SRN-15" => ["description" => "Power Technician",
                "RMN" => [

                    "E1" => "Power Technician 3/c",
                    "E2" => "Power Technician 2/c",
                    "E3" => "Power Technician 1/c",
                    "E4" => "Power Mate 3/c",
                    "E5" => "Power Mate 2/c",
                    "E6" => "Power Mate 1/c",
                    "E7" => "Chief Power Mate",
                    "E8" => "Senior Chief Power Mate",
                    "E9" => "Master Chief Power Mate",
                    "E10" => "Senior Master Chief Power Mate"
                ],
                "GSN" => [

                    "E1" => "Power Technician 3/c",
                    "E2" => "Power Technician 2/c",
                    "E3" => "Power Technician 1/c",
                    "E4" => "Power Mate 3/c",
                    "E5" => "Power Mate 2/c",
                    "E6" => "Power Mate 1/c",
                    "E7" => "Chief Power Mate",
                    "E8" => "Senior Chief Power Mate",
                    "E9" => "Master Chief Power Mate",
                    "E10" => "Senior Master Chief Power Mate"
                ],
                "RHN" => [

                    "E1" => "Power Technician 3/c",
                    "E2" => "Power Technician 2/c",
                    "E3" => "Power Technician 1/c",
                    "E4" => "Power Mate 3/c",
                    "E5" => "Power Mate 2/c",
                    "E6" => "Power Mate 1/c",
                    "E7" => "Chief Power Mate",
                    "E8" => "Senior Chief Power Mate",
                    "E9" => "Master Chief Power Mate",
                    "E10" => "Senior Master Chief Power Mate"
                ]
            ],
            "SRN-16" => ["description" => "Gravatics Technician",
                "RMN" => [

                    "E1" => "Gravatics Technician 3/c",
                    "E2" => "Gravatics Technician 2/c",
                    "E3" => "Gravatics Technician 1/c",
                    "E4" => "Gravatics Mate 3/c",
                    "E5" => "Gravatics Mate 2/c",
                    "E6" => "Gravatics Mate 1/c",
                    "E7" => "Chief Gravatics Mate",
                    "E8" => "Senior Chief Gravatics Mate",
                    "E9" => "Master Chief Gravatics Mate",
                    "E10" => "Senior Master Chief Gravatics Mate"
                ],
                "GSN" => [

                    "E1" => "Gravatics Technician 3/c",
                    "E2" => "Gravatics Technician 2/c",
                    "E3" => "Gravatics Technician 1/c",
                    "E4" => "Gravatics Mate 3/c",
                    "E5" => "Gravatics Mate 2/c",
                    "E6" => "Gravatics Mate 1/c",
                    "E7" => "Chief Gravatics Mate",
                    "E8" => "Senior Chief Gravatics Mate",
                    "E9" => "Master Chief Gravatics Mate",
                    "E10" => "Senior Master Chief Gravatics Mate"
                ],
                "RHN" => [

                    "E1" => "Gravatics Technician 3/c",
                    "E2" => "Gravatics Technician 2/c",
                    "E3" => "Gravatics Technician 1/c",
                    "E4" => "Gravatics Mate 3/c",
                    "E5" => "Gravatics Mate 2/c",
                    "E6" => "Gravatics Mate 1/c",
                    "E7" => "Chief Gravatics Mate",
                    "E8" => "Senior Chief Gravatics Mate",
                    "E9" => "Master Chief Gravatics Mate",
                    "E10" => "Senior Master Chief Gravatics Mate"
                ]
            ],
            "SRN-17" => ["description" => "Environmental Technician",
                "RMN" => [

                    "E1" => "Environmental Technician 3/c",
                    "E2" => "Environmental Technician 2/c",
                    "E3" => "Environmental Technician 1/c",
                    "E4" => "Environmental Mate 3/c",
                    "E5" => "Environmental Mate 2/c",
                    "E6" => "Environmental Mate 1/c",
                    "E7" => "Chief Environmental Mate",
                    "E8" => "Senior Chief Environmental Mate",
                    "E9" => "Master Chief Environmental Mate",
                    "E10" => "Senior Master Chief Environmental Mate"
                ],
                "GSN" => [

                    "E1" => "Environmental Technician 3/c",
                    "E2" => "Environmental Technician 2/c",
                    "E3" => "Environmental Technician 1/c",
                    "E4" => "Environmental Mate 3/c",
                    "E5" => "Environmental Mate 2/c",
                    "E6" => "Environmental Mate 1/c",
                    "E7" => "Chief Environmental Mate",
                    "E8" => "Senior Chief Environmental Mate",
                    "E9" => "Master Chief Environmental Mate",
                    "E10" => "Senior Master Chief Environmental Mate"
                ],
                "RHN" => [

                    "E1" => "Environmental Technician 3/c",
                    "E2" => "Environmental Technician 2/c",
                    "E3" => "Environmental Technician 1/c",
                    "E4" => "Environmental Mate 3/c",
                    "E5" => "Environmental Mate 2/c",
                    "E6" => "Environmental Mate 1/c",
                    "E7" => "Chief Environmental Mate",
                    "E8" => "Senior Chief Environmental Mate",
                    "E9" => "Master Chief Environmental Mate",
                    "E10" => "Senior Master Chief Environmental Mate"
                ]
            ],
            "SRN-18" => ["description" => "Hydroponics Technician",
                "RMN" => [

                    "E1" => "Hydroponics Technician 3/c",
                    "E2" => "Hydroponics Technician 2/c",
                    "E3" => "Hydroponics Technician 1/c",
                    "E4" => "Hydroponics Mate 3/c",
                    "E5" => "Hydroponics Mate 2/c",
                    "E6" => "Hydroponics Mate 1/c",
                    "E7" => "Chief Hydroponics Mate",
                    "E8" => "Senior Chief Hydroponics Mate",
                    "E9" => "Master Chief Hydroponics Mate",
                    "E10" => "Senior Master Chief Hydroponics Mate"
                ],
                "GSN" => [

                    "E1" => "Hydroponics Technician 3/c",
                    "E2" => "Hydroponics Technician 2/c",
                    "E3" => "Hydroponics Technician 1/c",
                    "E4" => "Hydroponics Mate 3/c",
                    "E5" => "Hydroponics Mate 2/c",
                    "E6" => "Hydroponics Mate 1/c",
                    "E7" => "Chief Hydroponics Mate",
                    "E8" => "Senior Chief Hydroponics Mate",
                    "E9" => "Master Chief Hydroponics Mate",
                    "E10" => "Senior Master Chief Hydroponics Mate"
                ],
                "RHN" => [

                    "E1" => "Hydroponics Technician 3/c",
                    "E2" => "Hydroponics Technician 2/c",
                    "E3" => "Hydroponics Technician 1/c",
                    "E4" => "Hydroponics Mate 3/c",
                    "E5" => "Hydroponics Mate 2/c",
                    "E6" => "Hydroponics Mate 1/c",
                    "E7" => "Chief Hydroponics Mate",
                    "E8" => "Senior Chief Hydroponics Mate",
                    "E9" => "Master Chief Hydroponics Mate",
                    "E10" => "Senior Master Chief Hydroponics Mate"
                ]
            ],
            "SRN-19" => ["description" => "Damage Control Technician",
                "RMN" => [

                    "E1" => "Damage Control Technician 3/c",
                    "E2" => "Damage Control Technician 2/c",
                    "E3" => "Damage Control Technician 1/c",
                    "E4" => "Damage Control Mate 3/c",
                    "E5" => "Damage Control Mate 2/c",
                    "E6" => "Damage Control Mate 1/c",
                    "E7" => "Chief Damage Control Mate",
                    "E8" => "Senior Chief Damage Control Mate",
                    "E9" => "Master Chief Damage Control Mate",
                    "E10" => "Senior Master Chief Damage Control Mate"
                ],
                "GSN" => [

                    "E1" => "Damage Control Technician 3/c",
                    "E2" => "Damage Control Technician 2/c",
                    "E3" => "Damage Control Technician 1/c",
                    "E4" => "Damage Control Mate 3/c",
                    "E5" => "Damage Control Mate 2/c",
                    "E6" => "Damage Control Mate 1/c",
                    "E7" => "Chief Damage Control Mate",
                    "E8" => "Senior Chief Damage Control Mate",
                    "E9" => "Master Chief Damage Control Mate",
                    "E10" => "Senior Master Chief Damage Control Mate"
                ],
                "RHN" => [

                    "E1" => "Damage Control Technician 3/c",
                    "E2" => "Damage Control Technician 2/c",
                    "E3" => "Damage Control Technician 1/c",
                    "E4" => "Damage Control Mate 3/c",
                    "E5" => "Damage Control Mate 2/c",
                    "E6" => "Damage Control Mate 1/c",
                    "E7" => "Chief Damage Control Mate",
                    "E8" => "Senior Chief Damage Control Mate",
                    "E9" => "Master Chief Damage Control Mate",
                    "E10" => "Senior Master Chief Damage Control Mate"
                ]
            ],
            "SRN-20" => ["description" => "Storekeeper",
                "RMN" => [

                    "E1" => "Storekeeper 3/c",
                    "E2" => "Storekeeper 2/c",
                    "E3" => "Storekeeper 1/c",
                    "E4" => "Storekeeper Petty Officer 3/c",
                    "E5" => "Storekeeper Petty Officer 2/c",
                    "E6" => "Storekeeper Petty Officer 1/c",
                    "E7" => "Chief Storekeeper",
                    "E8" => "Senior Chief Storekeeper",
                    "E9" => "Master Chief Storekeeper",
                    "E10" => "Senior Master Chief Storekeeper"
                ],
                "GSN" => [

                    "E1" => "Storekeeper 3/c",
                    "E2" => "Storekeeper 2/c",
                    "E3" => "Storekeeper 1/c",
                    "E4" => "Storekeeper Petty Officer 3/c",
                    "E5" => "Storekeeper Petty Officer 2/c",
                    "E6" => "Storekeeper Petty Officer 1/c",
                    "E7" => "Chief Storekeeper",
                    "E8" => "Senior Chief Storekeeper",
                    "E9" => "Master Chief Storekeeper",
                    "E10" => "Senior Master Chief Storekeeper"
                ],
                "RHN" => [

                    "E1" => "Storekeeper 3/c",
                    "E2" => "Storekeeper 2/c",
                    "E3" => "Storekeeper 1/c",
                    "E4" => "Storekeeper Petty Officer 3/c",
                    "E5" => "Storekeeper Petty Officer 2/c",
                    "E6" => "Storekeeper Petty Officer 1/c",
                    "E7" => "Chief Storekeeper",
                    "E8" => "Senior Chief Storekeeper",
                    "E9" => "Master Chief Storekeeper",
                    "E10" => "Senior Master Chief Storekeeper"
                ]
            ],
            "SRN-21" => ["description" => "Disbursing Clerk",
                "RMN" => [

                    "E1" => "Disbursing Clerk 3/c",
                    "E2" => "Disbursing Clerk 2/c",
                    "E3" => "Disbursing Clerk 1/c",
                    "E4" => "Disbursing Clerk Petty Officer 3/c",
                    "E5" => "Disbursing Clerk Petty Officer 2/c",
                    "E6" => "Disbursing Clerk Petty Officer 1/c",
                    "E7" => "Chief Disbursing Clerk",
                    "E8" => "Senior Chief Disbursing Clerk",
                    "E9" => "Master Chief Disbursing Clerk",
                    "E10" => "Senior Master Chief Disbursing Clerk"
                ],
                "GSN" => [

                    "E1" => "Disbursing Clerk 3/c",
                    "E2" => "Disbursing Clerk 2/c",
                    "E3" => "Disbursing Clerk 1/c",
                    "E4" => "Disbursing Clerk Petty Officer 3/c",
                    "E5" => "Disbursing Clerk Petty Officer 2/c",
                    "E6" => "Disbursing Clerk Petty Officer 1/c",
                    "E7" => "Chief Disbursing Clerk",
                    "E8" => "Senior Chief Disbursing Clerk",
                    "E9" => "Master Chief Disbursing Clerk",
                    "E10" => "Senior Master Chief Disbursing Clerk"
                ],
                "RHN" => [

                    "E1" => "Disbursing Clerk 3/c",
                    "E2" => "Disbursing Clerk 2/c",
                    "E3" => "Disbursing Clerk 1/c",
                    "E4" => "Disbursing Clerk Petty Officer 3/c",
                    "E5" => "Disbursing Clerk Petty Officer 2/c",
                    "E6" => "Disbursing Clerk Petty Officer 1/c",
                    "E7" => "Chief Disbursing Clerk",
                    "E8" => "Senior Chief Disbursing Clerk",
                    "E9" => "Master Chief Disbursing Clerk",
                    "E10" => "Senior Master Chief Disbursing Clerk"
                ]
            ],
            "SRN-22" => ["description" => "Ship's Serviceman",
                "RMN" => [

                    "E1" => "Ship's Serviceman 3/c",
                    "E2" => "Ship's Serviceman 2/c",
                    "E3" => "Ship's Serviceman 1/c",
                    "E4" => "Ship's Serviceman Petty Officer 3/c",
                    "E5" => "Ship's Serviceman Petty Officer 2/c",
                    "E6" => "Ship's Serviceman Petty Officer 1/c",
                    "E7" => "Chief Ship's Serviceman",
                    "E8" => "Senior Chief Ship's Serviceman",
                    "E9" => "Master Chief Ship's Serviceman",
                    "E10" => "Senior Master Chief Ship's Serviceman"
                ],
                "GSN" => [

                    "E1" => "Ship's Serviceman 3/c",
                    "E2" => "Ship's Serviceman 2/c",
                    "E3" => "Ship's Serviceman 1/c",
                    "E4" => "Ship's Serviceman Petty Officer 3/c",
                    "E5" => "Ship's Serviceman Petty Officer 2/c",
                    "E6" => "Ship's Serviceman Petty Officer 1/c",
                    "E7" => "Chief Ship's Serviceman",
                    "E8" => "Senior Chief Ship's Serviceman",
                    "E9" => "Master Chief Ship's Serviceman",
                    "E10" => "Senior Master Chief Ship's Serviceman"
                ],
                "RHN" => [

                    "E1" => "Ship's Serviceman 3/c",
                    "E2" => "Ship's Serviceman 2/c",
                    "E3" => "Ship's Serviceman 1/c",
                    "E4" => "Ship's Serviceman Petty Officer 3/c",
                    "E5" => "Ship's Serviceman Petty Officer 2/c",
                    "E6" => "Ship's Serviceman Petty Officer 1/c",
                    "E7" => "Chief Ship's Serviceman",
                    "E8" => "Senior Chief Ship's Serviceman",
                    "E9" => "Master Chief Ship's Serviceman",
                    "E10" => "Senior Master Chief Ship's Serviceman"
                ]
            ],
            "SRN-23" => ["description" => "Corpsman",
                "RMN" => [

                    "E1" => "Corpsman 3/c",
                    "E2" => "Corpsman 2/c",
                    "E3" => "Corpsman 1/c",
                    "E4" => "Corpsman Petty Officer 3/c",
                    "E5" => "Corpsman Petty Officer 2/c",
                    "E6" => "Corpsman Petty Officer 1/c",
                    "E7" => "Chief Corpsman",
                    "E8" => "Senior Chief Corpsman",
                    "E9" => "Master Chief Corpsman",
                    "E10" => "Senior Master Chief Corpsman"
                ],
                "GSN" => [

                    "E1" => "Corpsman 3/c",
                    "E2" => "Corpsman 2/c",
                    "E3" => "Corpsman 1/c",
                    "E4" => "Corpsman Petty Officer 3/c",
                    "E5" => "Corpsman Petty Officer 2/c",
                    "E6" => "Corpsman Petty Officer 1/c",
                    "E7" => "Chief Corpsman",
                    "E8" => "Senior Chief Corpsman",
                    "E9" => "Master Chief Corpsman",
                    "E10" => "Senior Master Chief Corpsman"
                ],
                "RHN" => [

                    "E1" => "Corpsman 3/c",
                    "E2" => "Corpsman 2/c",
                    "E3" => "Corpsman 1/c",
                    "E4" => "Corpsman Petty Officer 3/c",
                    "E5" => "Corpsman Petty Officer 2/c",
                    "E6" => "Corpsman Petty Officer 1/c",
                    "E7" => "Chief Corpsman",
                    "E8" => "Senior Chief Corpsman",
                    "E9" => "Master Chief Corpsman",
                    "E10" => "Senior Master Chief Corpsman"
                ]
            ],
            "SRN-24" => ["description" => "Sick Berth Attendant",
                "RMN" => [

                    "E1" => "Sick Berth Attendant 3/c",
                    "E2" => "Sick Berth Attendant 2/c",
                    "E3" => "Sick Berth Attendant 1/c",
                    "E4" => "Sick Berth Attendant Petty Officer 3/c",
                    "E5" => "Sick Berth Attendant Petty Officer 2/c",
                    "E6" => "Sick Berth Attendant Petty Officer 1/c",
                    "E7" => "Chief Sick Berth Attendant",
                    "E8" => "Senior Chief Sick Berth Attendant",
                    "E9" => "Master Chief Sick Berth Attendant",
                    "E10" => "Senior Master Chief Sick Berth Attendant"
                ],
                "GSN" => [

                    "E1" => "Sick Berth Attendant 3/c",
                    "E2" => "Sick Berth Attendant 2/c",
                    "E3" => "Sick Berth Attendant 1/c",
                    "E4" => "Sick Berth Attendant Petty Officer 3/c",
                    "E5" => "Sick Berth Attendant Petty Officer 2/c",
                    "E6" => "Sick Berth Attendant Petty Officer 1/c",
                    "E7" => "Chief Sick Berth Attendant",
                    "E8" => "Senior Chief Sick Berth Attendant",
                    "E9" => "Master Chief Sick Berth Attendant",
                    "E10" => "Senior Master Chief Sick Berth Attendant"
                ],
                "RHN" => [

                    "E1" => "Sick Berth Attendant 3/c",
                    "E2" => "Sick Berth Attendant 2/c",
                    "E3" => "Sick Berth Attendant 1/c",
                    "E4" => "Sick Berth Attendant Petty Officer 3/c",
                    "E5" => "Sick Berth Attendant Petty Officer 2/c",
                    "E6" => "Sick Berth Attendant Petty Officer 1/c",
                    "E7" => "Chief Sick Berth Attendant",
                    "E8" => "Senior Chief Sick Berth Attendant",
                    "E9" => "Master Chief Sick Berth Attendant",
                    "E10" => "Senior Master Chief Sick Berth Attendant"
                ]
            ],
            "SRN-25" => ["description" => "Operations Specialist",
                "RMN" => [

                    "E1" => "Operations Specialist 3/c",
                    "E2" => "Operations Specialist 2/c",
                    "E3" => "Operations Specialist 1/c",
                    "E4" => "Operations Mate 3/c",
                    "E5" => "Operations Mate 2/c",
                    "E6" => "Operations Mate 1/c",
                    "E7" => "Chief Operations Mate",
                    "E8" => "Senior Chief Operations Mate",
                    "E9" => "Master Chief Operations Mate",
                    "E10" => "Senior Master Chief Operations Mate"
                ],
                "GSN" => [

                    "E1" => "Operations Specialist 3/c",
                    "E2" => "Operations Specialist 2/c",
                    "E3" => "Operations Specialist 1/c",
                    "E4" => "Operations Mate 3/c",
                    "E5" => "Operations Mate 2/c",
                    "E6" => "Operations Mate 1/c",
                    "E7" => "Chief Operations Mate",
                    "E8" => "Senior Chief Operations Mate",
                    "E9" => "Master Chief Operations Mate",
                    "E10" => "Senior Master Chief Operations Mate"
                ],
                "RHN" => [

                    "E1" => "Operations Specialist 3/c",
                    "E2" => "Operations Specialist 2/c",
                    "E3" => "Operations Specialist 1/c",
                    "E4" => "Operations Mate 3/c",
                    "E5" => "Operations Mate 2/c",
                    "E6" => "Operations Mate 1/c",
                    "E7" => "Chief Operations Mate",
                    "E8" => "Senior Chief Operations Mate",
                    "E9" => "Master Chief Operations Mate",
                    "E10" => "Senior Master Chief Operations Mate"
                ]
            ],
            "SRN-26" => ["description" => "Intelligence Specialist",
                "RMN" => [

                    "E1" => "Intelligence Specialist 3/c",
                    "E2" => "Intelligence Specialist 2/c",
                    "E3" => "Intelligence Specialist 1/c",
                    "E4" => "Intelligence Mate 3/c",
                    "E5" => "Intelligence Mate 2/c",
                    "E6" => "Intelligence Mate 1/c",
                    "E7" => "Chief Intelligence Mate",
                    "E8" => "Senior Chief Intelligence Mate",
                    "E9" => "Master Chief Intelligence Mate",
                    "E10" => "Senior Master Chief Intelligence Mate"
                ],
                "GSN" => [

                    "E1" => "Intelligence Specialist 3/c",
                    "E2" => "Intelligence Specialist 2/c",
                    "E3" => "Intelligence Specialist 1/c",
                    "E4" => "Intelligence Mate 3/c",
                    "E5" => "Intelligence Mate 2/c",
                    "E6" => "Intelligence Mate 1/c",
                    "E7" => "Chief Intelligence Mate",
                    "E8" => "Senior Chief Intelligence Mate",
                    "E9" => "Master Chief Intelligence Mate",
                    "E10" => "Senior Master Chief Intelligence Mate"
                ],
                "RHN" => [

                    "E1" => "Intelligence Specialist 3/c",
                    "E2" => "Intelligence Specialist 2/c",
                    "E3" => "Intelligence Specialist 1/c",
                    "E4" => "Intelligence Mate 3/c",
                    "E5" => "Intelligence Mate 2/c",
                    "E6" => "Intelligence Mate 1/c",
                    "E7" => "Chief Intelligence Mate",
                    "E8" => "Senior Chief Intelligence Mate",
                    "E9" => "Master Chief Intelligence Mate",
                    "E10" => "Senior Master Chief Intelligence Mate"
                ]
            ],
            "SRN-27" => ["description" => "Missile Technician",
                "RMN" => [

                    "E1" => "Missile Technician 3/c",
                    "E2" => "Missile Technician 2/c",
                    "E3" => "Missile Technician 1/c",
                    "E4" => "Missile Mate 3/c",
                    "E5" => "Missile Mate 2/c",
                    "E6" => "Missile Mate 1/c",
                    "E7" => "Chief Missile Mate",
                    "E8" => "Senior Chief Missile Mate",
                    "E9" => "Master Chief Missile Mate",
                    "E10" => "Senior Master Chief Missile Mate"
                ],
                "GSN" => [

                    "E1" => "Missile Technician 3/c",
                    "E2" => "Missile Technician 2/c",
                    "E3" => "Missile Technician 1/c",
                    "E4" => "Missile Mate 3/c",
                    "E5" => "Missile Mate 2/c",
                    "E6" => "Missile Mate 1/c",
                    "E7" => "Chief Missile Mate",
                    "E8" => "Senior Chief Missile Mate",
                    "E9" => "Master Chief Missile Mate",
                    "E10" => "Senior Master Chief Missile Mate"
                ],
                "RHN" => [

                    "E1" => "Missile Technician 3/c",
                    "E2" => "Missile Technician 2/c",
                    "E3" => "Missile Technician 1/c",
                    "E4" => "Missile Mate 3/c",
                    "E5" => "Missile Mate 2/c",
                    "E6" => "Missile Mate 1/c",
                    "E7" => "Chief Missile Mate",
                    "E8" => "Senior Chief Missile Mate",
                    "E9" => "Master Chief Missile Mate",
                    "E10" => "Senior Master Chief Missile Mate"
                ]
            ],
            "SRN-28" => ["description" => "Beam Weapons Technician",
                "RMN" => [

                    "E1" => "Beam Weapons Technician 3/c",
                    "E2" => "Beam Weapons Technician 2/c",
                    "E3" => "Beam Weapons Technician 1/c",
                    "E4" => "Beam Weapons Mate 3/c",
                    "E5" => "Beam Weapons Mate 2/c",
                    "E6" => "Beam Weapons Mate 1/c",
                    "E7" => "Chief Beam Weapons Mate",
                    "E8" => "Senior Chief Beam Weapons Mate",
                    "E9" => "Master Chief Beam Weapons Mate",
                    "E10" => "Senior Master Chief Beam Weapons Mate"
                ],
                "GSN" => [

                    "E1" => "Beam Weapons Technician 3/c",
                    "E2" => "Beam Weapons Technician 2/c",
                    "E3" => "Beam Weapons Technician 1/c",
                    "E4" => "Beam Weapons Mate 3/c",
                    "E5" => "Beam Weapons Mate 2/c",
                    "E6" => "Beam Weapons Mate 1/c",
                    "E7" => "Chief Beam Weapons Mate",
                    "E8" => "Senior Chief Beam Weapons Mate",
                    "E9" => "Master Chief Beam Weapons Mate",
                    "E10" => "Senior Master Chief Beam Weapons Mate"
                ],
                "RHN" => [

                    "E1" => "Beam Weapons Technician 3/c",
                    "E2" => "Beam Weapons Technician 2/c",
                    "E3" => "Beam Weapons Technician 1/c",
                    "E4" => "Beam Weapons Mate 3/c",
                    "E5" => "Beam Weapons Mate 2/c",
                    "E6" => "Beam Weapons Mate 1/c",
                    "E7" => "Chief Beam Weapons Mate",
                    "E8" => "Senior Chief Beam Weapons Mate",
                    "E9" => "Master Chief Beam Weapons Mate",
                    "E10" => "Senior Master Chief Beam Weapons Mate"
                ]
            ],
            "SRN-29" => ["description" => "Gunner",
                "RMN" => [

                    "E1" => "Gunner 3/c",
                    "E2" => "Gunner 2/c",
                    "E3" => "Gunner 1/c",
                    "E4" => "Gunner's Mate 3/c",
                    "E5" => "Gunner's Mate 2/c",
                    "E6" => "Gunner's Mate 1/c",
                    "E7" => "Chief Gunner's Mate",
                    "E8" => "Senior Chief Gunner's Mate",
                    "E9" => "Master Chief Gunner's Mate",
                    "E10" => "Senior Master Chief Gunner's Mate"
                ],
                "GSN" => [

                    "E1" => "Gunner 3/c",
                    "E2" => "Gunner 2/c",
                    "E3" => "Gunner 1/c",
                    "E4" => "Gunner's Mate 3/c",
                    "E5" => "Gunner's Mate 2/c",
                    "E6" => "Gunner's Mate 1/c",
                    "E7" => "Chief Gunner's Mate",
                    "E8" => "Senior Chief Gunner's Mate",
                    "E9" => "Master Chief Gunner's Mate",
                    "E10" => "Senior Master Chief Gunner's Mate"
                ],
                "RHN" => [

                    "E1" => "Gunner 3/c",
                    "E2" => "Gunner 2/c",
                    "E3" => "Gunner 1/c",
                    "E4" => "Gunner's Mate 3/c",
                    "E5" => "Gunner's Mate 2/c",
                    "E6" => "Gunner's Mate 1/c",
                    "E7" => "Chief Gunner's Mate",
                    "E8" => "Senior Chief Gunner's Mate",
                    "E9" => "Master Chief Gunner's Mate",
                    "E10" => "Senior Master Chief Gunner's Mate"
                ]
            ],
            "SRN-30" => ["description" => "Boatswain",
                "RMN" => [

                    "E1" => "Boatswain 3/c",
                    "E2" => "Boatswain 2/c",
                    "E3" => "Boatswain 1/c",
                    "E4" => "Boatswain's Mate 3/c",
                    "E5" => "Boatswain's Mate 2/c",
                    "E6" => "Boatswain's Mate 1/c",
                    "E7" => "Chief Boatswain's Mate",
                    "E8" => "Senior Chief Boatswain's Mate",
                    "E9" => "Master Chief Boatswain's Mate",
                    "E10" => "Senior Master Chief Boatswain's Mate"
                ],
                "GSN" => [

                    "E1" => "Boatswain 3/c",
                    "E2" => "Boatswain 2/c",
                    "E3" => "Boatswain 1/c",
                    "E4" => "Boatswain's Mate 3/c",
                    "E5" => "Boatswain's Mate 2/c",
                    "E6" => "Boatswain's Mate 1/c",
                    "E7" => "Chief Boatswain's Mate",
                    "E8" => "Senior Chief Boatswain's Mate",
                    "E9" => "Master Chief Boatswain's Mate",
                    "E10" => "Senior Master Chief Boatswain's Mate"
                ],
                "RHN" => [

                    "E1" => "Boatswain 3/c",
                    "E2" => "Boatswain 2/c",
                    "E3" => "Boatswain 1/c",
                    "E4" => "Boatswain's Mate 3/c",
                    "E5" => "Boatswain's Mate 2/c",
                    "E6" => "Boatswain's Mate 1/c",
                    "E7" => "Chief Boatswain's Mate",
                    "E8" => "Senior Chief Boatswain's Mate",
                    "E9" => "Master Chief Boatswain's Mate",
                    "E10" => "Senior Master Chief Boatswain's Mate"
                ]
            ],
            "SRN-31" => ["description" => "Master-at-Arms",
                "RMN" => [

                    "E1" => "Master-at-Arms 3/c",
                    "E2" => "Master-at-Arms 2/c",
                    "E3" => "Master-at-Arms 1/c",
                    "E4" => "Master-at-Arms Mate 3/c",
                    "E5" => "Master-at-Arms Mate 2/c",
                    "E6" => "Master-at-Arms Mate 1/c",
                    "E7" => "Chief Master-at-Arms Mate",
                    "E8" => "Senior Chief Master-at-Arms Mate",
                    "E9" => "Master Chief Master-at-Arms Mate",
                    "E10" => "Senior Master Chief Master-at-Arms Mate"
                ],
                "GSN" => [

                    "E1" => "Master-at-Arms 3/c",
                    "E2" => "Master-at-Arms 2/c",
                    "E3" => "Master-at-Arms 1/c",
                    "E4" => "Master-at-Arms Mate 3/c",
                    "E5" => "Master-at-Arms Mate 2/c",
                    "E6" => "Master-at-Arms Mate 1/c",
                    "E7" => "Chief Master-at-Arms Mate",
                    "E8" => "Senior Chief Master-at-Arms Mate",
                    "E9" => "Master Chief Master-at-Arms Mate",
                    "E10" => "Senior Master Chief Master-at-Arms Mate"
                ],
                "RHN" => [

                    "E1" => "Master-at-Arms 3/c",
                    "E2" => "Master-at-Arms 2/c",
                    "E3" => "Master-at-Arms 1/c",
                    "E4" => "Master-at-Arms Mate 3/c",
                    "E5" => "Master-at-Arms Mate 2/c",
                    "E6" => "Master-at-Arms Mate 1/c",
                    "E7" => "Chief Master-at-Arms Mate",
                    "E8" => "Senior Chief Master-at-Arms Mate",
                    "E9" => "Master Chief Master-at-Arms Mate",
                    "E10" => "Senior Master Chief Master-at-Arms Mate"
                ]
            ],
            "SRN-32" => ["description" => "Sensor Technician",
                "RMN" => [

                    "E1" => "Sensor Technician 3/c",
                    "E2" => "Sensor Technician 2/c",
                    "E3" => "Sensor Technician 1/c",
                    "E4" => "Sensor Mate 3/c",
                    "E5" => "Sensor Mate 2/c",
                    "E6" => "Sensor Mate 1/c",
                    "E7" => "Chief Sensor Mate",
                    "E8" => "Senior Chief Sensor Mate",
                    "E9" => "Master Chief Sensor Mate",
                    "E10" => "Senior Master Chief Sensor Mate"
                ],
                "GSN" => [

                    "E1" => "Sensor Technician 3/c",
                    "E2" => "Sensor Technician 2/c",
                    "E3" => "Sensor Technician 1/c",
                    "E4" => "Sensor Mate 3/c",
                    "E5" => "Sensor Mate 2/c",
                    "E6" => "Sensor Mate 1/c",
                    "E7" => "Chief Sensor Mate",
                    "E8" => "Senior Chief Sensor Mate",
                    "E9" => "Master Chief Sensor Mate",
                    "E10" => "Senior Master Chief Sensor Mate"
                ],
                "RHN" => [

                    "E1" => "Sensor Technician 3/c",
                    "E2" => "Sensor Technician 2/c",
                    "E3" => "Sensor Technician 1/c",
                    "E4" => "Sensor Mate 3/c",
                    "E5" => "Sensor Mate 2/c",
                    "E6" => "Sensor Mate 1/c",
                    "E7" => "Chief Sensor Mate",
                    "E8" => "Senior Chief Sensor Mate",
                    "E9" => "Master Chief Sensor Mate",
                    "E10" => "Senior Master Chief Sensor Mate"
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
            Rating::create(["rate_code" => $rating, "rate" => $description]);
        }
    }
} 
