<?php

use Illuminate\Database\Migrations\Migration;

class AddIndividualAwards extends Migration
{
    use App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $awards = json_decode('[
    {
        "display_order":  1,
        "name": "Parlimentary Medal of Valor",
        "code": "PMV",
        "post_nominal": "PMV",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  2,
        "name": "Queen\'s Cross of Bravery",
        "code": "QCB",
        "post_nominal": "QCB",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  3,
        "name": "Most Noble Order of the Star Kingdom",
        "code": "KSK",
        "post_nominal": "KSK",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order":  4,
        "name": "Knight Grand Cross of the Most Honorable Order of King Roger",
        "code": "GCR",
        "post_nominal": "GCR",
        "replaces": "KDR,KCR,KR,CR,OR,MR,RM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Honorable Order of King Roger"
    },
    {
        "display_order":  6,
        "name": "Knight Grand Cross of the Most Regal Order of Queen Elizabeth",
        "code": "GCE",
        "post_nominal": "GCE",
        "replaces": "KDE,KCE,KE,CE,OE,ME,EM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Regal Order of Queen Elizabeth"
    },
    {
        "display_order":  7,
        "name": "Most Distinguished Order of Merit",
        "code": "OM",
        "post_nominal": "OM",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order":  8,
        "name": "Knight Commander of the Most Honorable Order of King Roger",
        "code": "KDR",
        "post_nominal": "KDR",
        "replaces": "KCR,KR,CR,OR,MR,RM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Honorable Order of King Roger"
    },
    {
        "display_order":  10,
        "name": "Knight Commander of the Most Regal Order of Queen Elizabeth",
        "code": "KDE",
        "post_nominal": "KDE",
        "replaces": "KCE,KE,CE,OE,ME,EM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Regal Order of Queen Elizabeth"
    },
    {
        "display_order":  11,
        "name": "Knight Companion of the Most Honorable Order of King Roger",
        "code": "KCR",
        "post_nominal": "KCR",
        "replaces": "KR,CR,OR,MR,RM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Honorable Order of King Roger"
    },
    {
        "display_order":  13,
        "name": "Knight Companion of the Most Regal Order of Queen Elizabeth",
        "code": "KCE",
        "post_nominal": "KCE",
        "replaces": "KE,CE,OE,ME,EM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Regal Order of Queen Elizabeth"
    },
    {
        "display_order":  14,
        "name": "Manticore Cross",
        "code": "MC",
        "post_nominal": "MC",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  15,
        "name": "Osterman Cross",
        "code": "OC",
        "post_nominal": "OC",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  17,
        "name": "Knight of the Most Honorable Order of King Roger",
        "code": "KR",
        "post_nominal": "KR",
        "replaces": "CR,OR,MR,RM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Honorable Order of King Roger"
    },
    {
        "display_order":  19,
        "name": "Knight of the Most Regal Order of Queen Elizabeth",
        "code": "KE",
        "post_nominal": "KE",
        "replaces": "CE,OE,ME,EM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Regal Order of Queen Elizabeth"
    },
    {
        "display_order":  20,
        "name": "Companion of the Most Honorable Order of King Roger",
        "code": "CR",
        "post_nominal": "CR",
        "replaces": "OR,MR,RM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Honorable Order of King Roger"
    },
    {
        "display_order":  22,
        "name": "Companion of the Most Regal Order of Queen Elizabeth",
        "code": "CE",
        "post_nominal": "CE",
        "replaces": "OE,ME,EM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Regal Order of Queen Elizabeth"
    },
    {
        "display_order":  23,
        "name": "Saganami Cross",
        "code": "SC",
        "post_nominal": "SC",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  25,
        "name": "Distinguished Gallantry Cross",
        "code": "DGC",
        "post_nominal": "DGC",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  26,
        "name": "Officer of the Most Honorable Order of King Roger",
        "code": "OR",
        "post_nominal": "OR",
        "replaces": "MR,RM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Honorable Order of King Roger"
    },
    {
        "display_order":  28,
        "name": "Officer of the Order of Queen Elizabeth",
        "code": "OE",
        "post_nominal": "OE",
        "replaces": "ME,EM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Regal Order of Queen Elizabeth"
    },
    {
        "display_order":  29,
        "name": "Order of Gallantry",
        "code": "OG",
        "post_nominal": "OG",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  30,
        "name": "Navy Star",
        "code": "NS",
        "post_nominal": "NS",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  31,
        "name": "Distinguished Service Order",
        "code": "DSO",
        "post_nominal": "DSO",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  32,
        "name": "Member of the Most Honorable Order of King Roger",
        "code": "MR",
        "post_nominal": "MR",
        "replaces": "RM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Honorable Order of King Roger"
    },
    {
        "display_order":  36,
        "name": "Member of the Most Regal Order of Queen Elizabeth",
        "code": "ME",
        "post_nominal": "ME",
        "replaces": "EM",
        "location": "L",
        "multiple": false,
        "group_label": "Most Regal Order of Queen Elizabeth"
    },
    {
        "display_order":  37,
        "name": "Monarch\'s Thanks",
        "code": "MT",
        "post_nominal": "",
        "replaces": "",
        "location": "RS",
        "multiple": true
    },
    {
        "display_order":  40,
        "name": "Conspicuous Gallantry Medal",
        "code": "CGM",
        "post_nominal": "CGM",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  41,
        "name": "Gryphon Star",
        "code": "GS",
        "post_nominal": "GS",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  42,
        "name": "Order of the Crown for Naval Service",
        "code": "OCN",
        "post_nominal": "OCN",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order":  45,
        "name": "Wound Stripe",
        "code": "WS",
        "post_nominal": "",
        "replaces": "",
        "location": "RS",
        "multiple": true
    },
    {
        "display_order":  46,
        "name": "Queen\'s Bravery Medal",
        "code": "QBM",
        "post_nominal": "QBM",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  47,
        "name": "Sphinx Cross",
        "code": "SphC",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  48,
        "name": "Royal Household Distinguished Service Medal",
        "code": "RHDSM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order":  49,
        "name": "Mentioned in Dispatches",
        "code": "MID",
        "post_nominal": "",
        "replaces": "",
        "location": "RS",
        "multiple": true
    },
    {
        "display_order":  52,
        "name": "Medal,Most Honorable Order of King Roger",
        "code": "RM",
        "post_nominal": "RM",
        "replaces": "",
        "location": "L",
        "multiple": false,
        "group_label": "Most Honorable Order of King Roger"
    },
    {
        "display_order":  54,
        "name": "Medal,Most Regal Order of Queen Elizabeth",
        "code": "EM",
        "post_nominal": "EM",
        "replaces": "",
        "location": "L",
        "multiple": false,
        "group_label": "Most Regal Order of Queen Elizabeth"
    },
    {
        "display_order":  55,
        "name": "Conspicuous Bravery Medal",
        "code": "CBM",
        "post_nominal": "CBM",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  56,
        "name": "Conspicuous Service Medal",
        "code": "CSM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  57,
        "name": "Meritorious Service Medal",
        "code": "MSM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  58,
        "name": "Navy Commendation Decoration",
        "code": "NCD",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  59,
        "name": "Navy\/Marine Achievement Medal",
        "code": "NMAM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  60,
        "name": "List of Honor Citation",
        "code": "LHC",
        "post_nominal": "",
        "replaces": "",
        "location": "R",
        "multiple": true
    },
    {
        "display_order":  61,
        "name": "Royal Unit Citation for Gallantry",
        "code": "RUC",
        "post_nominal": "",
        "replaces": "",
        "location": "R",
        "multiple": true
    },
    {
        "display_order":  62,
        "name": "Royal Meritorious Unit Citation",
        "code": "RMU",
        "post_nominal": "",
        "replaces": "",
        "location": "R",
        "multiple": true
    },
    {
        "display_order":  63,
        "name": "Fleet Excellence Award",
        "code": "FEA",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  64,
        "name": "Prisoner Of War Medal",
        "code": "POW",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  65,
        "name": "Survivor\'s Cross",
        "code": "SvC",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  66,
        "name": "Silesian Anti-Piracy Campaign Medal",
        "code": "SAPC",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  67,
        "name": "Masadan Occupation Medal",
        "code": "MOM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  68,
        "name": "Havenite War Campaign Medal",
        "code": "HWC",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  69,
        "name": "Havenite Operation Service Medal",
        "code": "HOSM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  70,
        "name": "Manticore-Havenite 1905-1922 War Medal",
        "code": "MHW",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  71,
        "name": "Grand Alliance Campaign Medal",
        "code": "GACM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  72,
        "name": "King Roger III Coronation Medal",
        "code": "KR3CM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order":  73,
        "name": "Queen Elizabeth III Coronation Medal",
        "code": "QE3CM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order":  74,
        "name": "Manticoran Combat Action Medal",
        "code": "MCAM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": true
    },
    {
        "display_order":  75,
        "name": "Manticoran Service Medal",
        "code": "MtSM",
        "post_nominal": "",
        "replaces": "MRSM,GCM",
        "location": "L",
        "multiple": true,
        "group_label": "Length of Service Awards"
    },
    {
        "display_order":  76,
        "name": "Manticoran Reserve Service Medal",
        "code": "MRSM",
        "post_nominal": "",
        "replaces": "MtSM,GCM",
        "location": "L",
        "multiple": false,
        "group_label": "Length of Service Awards"
    },
    {
        "display_order":  77,
        "name": "Good Conduct Medal",
        "code": "GCM",
        "post_nominal": "",
        "replaces": "MtSM,MRSM",
        "location": "L",
        "multiple": true,
        "group_label": "Length of Service Awards"
    },
    {
        "display_order":  78,
        "name": "Space Service Deployment Ribbon",
        "code": "SSD",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order":  79,
        "name": "Navy Rifle High Expert Ribbon",
        "code": "NRHE",
        "post_nominal": "",
        "replaces": "NRE,NRS",
        "location": "L",
        "multiple": false,
        "group_label": "Rifle Marksmanship"
    },
    {
        "display_order":  80,
        "name": "Navy Pistol High Expert Ribbon",
        "code": "NPHE",
        "post_nominal": "",
        "replaces": "NPE,NPS",
        "location": "L",
        "multiple": false,
        "group_label": "Pistol Marksmanship"
    },
    {
        "display_order":  82,
        "name": "Navy Rifle Expert Ribbon",
        "code": "NRE",
        "post_nominal": "",
        "replaces": "NRS",
        "location": "L",
        "multiple": false,
        "group_label": "Rifle Marksmanship"
    },
    {
        "display_order":  83,
        "name": "Navy Pistol Expert Ribbon",
        "code": "NPE",
        "post_nominal": "",
        "replaces": "NPS",
        "location": "L",
        "multiple": false,
        "group_label": "Pistol Marksmanship"
    },
    {
        "display_order":  85,
        "name": "Navy Rifle Sharpshooter Ribbon",
        "code": "NRS",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": false,
        "group_label": "Rifle Marksmanship"
    },
    {
        "display_order":  86,
        "name": "Navy Pistol Sharpshooter Ribbon",
        "code": "NPS",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": false,
        "group_label": "Pistol Marksmanship"
    },
    {
        "display_order":  90,
        "name": "Recruit Training Ribbon",
        "code": "RTR",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order":  91,
        "name": "NCO Senior Course Ribbon",
        "code": "NCOSCR",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order":  92,
        "name": "Armed Forces Service Medal",
        "code": "AFSM",
        "post_nominal": "",
        "replaces": "",
        "location": "L",
        "multiple": false
    },
    {
        "display_order": 1000,
        "name": "Command Hyperstar",
        "code": "HS",
        "post_nominal": "",
        "replaces": "OSWP,ESWP",
        "location": "TL",
        "multiple": true,
        "group_label": "Qualification Badges"
    },
    {
        "display_order": 1001,
        "name": "Officer Space Warfare Pin",
        "code": "OSWP",
        "post_nominal": "",
        "replaces": "ESWP,HS",
        "location": "TL",
        "multiple": false,
        "group_label": "Qualification Badges"
    },
    {
        "display_order": 1002,
        "name": "Enlisted Space Warfare Pin",
        "code": "ESWP",
        "post_nominal": "",
        "replaces": "OSWP,HS",
        "location": "TL",
        "multiple": true,
        "group_label": "Qualification Badges"    
    }
]', true);

        foreach ($awards as $award) {
            \App\Models\Award::create($award);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //		\App\Models\Award::all()->destroy();
    }
}
