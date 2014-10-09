<?php

class RatingSeeder extends Seeder
{
    public function run()
    {
        DB::collection('ratings')->delete();

        $ratings = [
            "SRN-01" => [
                "RMN" => [
                    "description" => "Personnelman",
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
                    "description" => "Personnelman",
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
                    "description" => "Personnelman",
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
            "SRN-02" => [
                "RMN" => [
                    "description" => "Navy Counselor",
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
                    "description" => "Navy Counselor",
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
                    "description" => "Navy Counselor",
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
            "SRN-03" => [
                "RMN" => [
                    "description" => "Steward",
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
                    "description" => "Steward",
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
                    "description" => "Steward",
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
            "SRN-04" => [
                "RMN" => [
                    "description" => "Yeoman",
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
                    "description" => "Yeoman",
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
                    "description" => "Yeoman",
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
            "SRN-05" => [
                "RMN" => [
                    "description" => "Coxswain",
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
                    "description" => "Coxswain",
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
                    "description" => "Coxswain",
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
            "SRN-06" => [
                "RMN" => [
                    "description" => "Helmsman",
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
                    "description" => "Helmsman",
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
                    "description" => "Helmsman",
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
            "SRN-07" => [
                "RMN" => [
                    "description" => "Plotting Specialist",
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
                    "description" => "Plotting Specialist",
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
                    "description" => "Plotting Specialist",
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
            "SRN-08" => [
                "RMN" => [
                    "description" => "Fire Control Technician",
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
                    "description" => "Fire Control Technician",
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
                    "description" => "Fire Control Technician",
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
            "SRN-09" => [
                "RMN" => [
                    "description" => "Electronic Warfare Technician",
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
                    "description" => "Electronic Warfare Technician",
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
                    "description" => "Electronic Warfare Technician",
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
            "SRN-10" => [
                "RMN" => [
                    "description" => "Tracking Specialist",
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
                    "description" => "Tracking Specialist",
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
                    "description" => "Tracking Specialist",
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
            "SRN-11" => [
                "RMN" => [
                    "description" => "Data System Technician",
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
                    "description" => "Data System Technician",
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
                    "description" => "Data System Technician",
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
            "SRN-12" => [
                "RMN" => [
                    "description" => "Electronics Technician",
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
                    "description" => "Electronics Technician",
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
                    "description" => "Electronics Technician",
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
            "SRN-13" => [
                "RMN" => [
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
                ]
            ],
            "SRN-14" => [
                "RMN" => [
                    "description" => "Impeller Technician",
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
                    "description" => "Impeller Technician",
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
                    "description" => "Impeller Technician",
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
            "SRN-15" => [
                "RMN" => [
                    "description" => "Power Technician",
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
                    "description" => "Power Technician",
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
                    "description" => "Power Technician",
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
            "SRN-16" => [
                "RMN" => [
                    "description" => "Gravatics Technician",
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
                    "description" => "Gravatics Technician",
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
                    "description" => "Gravatics Technician",
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
            "SRN-17" => [
                "RMN" => [
                    "description" => "Environmental Technician",
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
                    "description" => "Environmental Technician",
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
                    "description" => "Environmental Technician",
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
            "SRN-18" => [
                "RMN" => [
                    "description" => "Hydroponics Technician",
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
                    "description" => "Hydroponics Technician",
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
                    "description" => "Hydroponics Technician",
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
            "SRN-19" => [
                "RMN" => [
                    "description" => "Damage Control Technician",
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
                    "description" => "Damage Control Technician",
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
                    "description" => "Damage Control Technician",
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
            "SRN-20" => [
                "RMN" => [
                    "description" => "Storekeeper",
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
                    "description" => "Storekeeper",
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
                    "description" => "Storekeeper",
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
            "SRN-21" => [
                "RMN" => [
                    "description" => "Disbursing Clerk",
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
                    "description" => "Disbursing Clerk",
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
                    "description" => "Disbursing Clerk",
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
            "SRN-22" => [
                "RMN" => [
                    "description" => "Ship's Serviceman",
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
                    "description" => "Ship's Serviceman",
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
                    "description" => "Ship's Serviceman",
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
            "SRN-23" => [
                "RMN" => [
                    "description" => "Corpsman",
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
                    "description" => "Corpsman",
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
                    "description" => "Corpsman",
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
            "SRN-24" => [
                "RMN" => [
                    "description" => "Sick Berth Attendant",
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
                    "description" => "Sick Berth Attendant",
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
                    "description" => "Sick Berth Attendant",
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
            "SRN-25" => [
                "RMN" => [
                    "description" => "Operations Specialist",
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
                    "description" => "Operations Specialist",
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
                    "description" => "Operations Specialist",
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
            "SRN-26" => [
                "RMN" => [
                    "description" => "Intelligence Specialist",
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
                    "description" => "Intelligence Specialist",
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
                    "description" => "Intelligence Specialist",
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
            "SRN-27" => [
                "RMN" => [
                    "description" => "Missile Technician",
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
                    "description" => "Missile Technician",
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
                    "description" => "Missile Technician",
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
            "SRN-28" => [
                "RMN" => [
                    "description" => "Beam Weapons Technician",
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
                    "description" => "Beam Weapons Technician",
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
                    "description" => "Beam Weapons Technician",
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
            "SRN-29" => [
                "RMN" => [
                    "description" => "Gunner",
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
                    "description" => "Gunner",
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
                    "description" => "Gunner",
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
            "SRN-30" => [
                "RMN" => [
                    "description" => "Boatswain",
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
                    "description" => "Boatswain",
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
                    "description" => "Boatswain",
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
            "SRN-31" => [
                "RMN" => [
                    "description" => "Master-at-Arms",
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
                    "description" => "Master-at-Arms",
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
                    "description" => "Master-at-Arms",
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
            "SRN-32" => [
                "RMN" => [
                    "description" => "Sensor Technician",
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
                    "description" => "Sensor Technician",
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
                    "description" => "Sensor Technician",
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
            "SRMC-01" => [
                "RMMC" => [
                    "description" => "Armorer"
                ],
            ],

            "SRMC-02" => [
                "RMMC" => [
                    "description" => "Marine Police"
                ],
            ],

            "SRMC-03" => [
                "RMMC" => [
                    "description" => "Missile Crew"
                ],
            ],

            "SRMC-04" => [
                "RMMC" => [
                    "description" => "LASER/GRASER Crew"
                ],
            ],

            "SRMC-05" => [
                "RMMC" => [
                    "description" => "Assault Marine"
                ],
            ],

            "SRMC-06" => [
                "RMMC" => [
                    "description" => "Recon Marine"
                ],
            ],

            "SRMC-07" => [
                "RMMC" => [
                    "description" => "Rifleman/Grenadier"
                ],
            ],

            "SRMC-08" => [
                "RMMC" => [
                    "description" => "Heavy Weapons"
                ],
            ],

            "SRMC-09" => [
                "RMMC" => [
                    "description" => "Admin Specialist"
                ],
            ],

            "SRMC-10" => [
                "RMMC" => [
                    "description" => "Embassy Guard"
                ],
            ],

            "RMAT-09" => [
                "RMA" => [
                    "description" => "Skimmer Crewman"
                ],
            ],

            "RMAT-03" => [
                "RMA" => [
                    "description" => "Tank Crewman"
                ],
            ],

            "RMAT-05" => [
                "RMA" => [
                    "description" => "Stingship Pilot"
                ],
            ],

            "RMAT-10" => [
                "RMA" => [
                    "description" => "Cargo Skimmer Pilot"
                ],
            ],

            "RMAT-06" => [
                "RMA" => [
                    "description" => "Indirect Fire Specialist"
                ],
            ],

            "RMAT-11" => [
                "RMA" => [
                    "description" => "Air Defense Specialist"
                ],
            ],

            "RMAT-12" => [
                "RMA" => [
                    "description" => "Orbital Defense Specialist"
                ],
            ],

            "RMAT-13" => [
                "RMA" => [
                    "description" => "Combat Engineer"
                ],
            ],

            "RMAT-01" => [
                "RMA" => [
                    "description" => "Armorer"
                ],
            ],

            "RMAT-08" => [
                "RMA" => [
                    "description" => "Infantryman"
                ],
            ],

            "RMAT-14" => [
                "RMA" => [
                    "description" => "Assault Specialist (Battle Armor)"
                ],
            ],

            "RMAT-04" => [
                "RMA" => [
                    "description" => "Reconnaissance Specialist"
                ],
            ],

            "RMAT-15" => [
                "RMA" => [
                    "description" => "Military Criminal Investigator"
                ],
            ],

            "RMAT-02" => [
                "RMA" => [
                    "description" => "Military Police"
                ],
            ],

            "RMAT-16" => [
                "RMA" => [
                    "description" => "Military Law Specialist"
                ],
            ],

            "RMAT-07" => [
                "RMA" => [
                    "description" => "Administrative Specialist"
                ],
            ],

            "RMAT-17" => [
                "RMA" => [
                    "description" => "Logistics Specialist"
                ],
            ],

            "RMAT-18" => [
                "RMA" => [
                    "description" => "Finance Specialist"
                ],
            ]

        ];


        foreach ($ratings as $rating => $description) {
            Rating::create(["rate_code" => $rating, "rate" => $description]);
        }
    }
} 
