<?php

use Illuminate\Database\Migrations\Migration;

class Aerospacewings extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add the wings to the replaces for the rest of the qual badges

        $updates = Award::where("group_label", '=', 'Qualification Badges')->get();

        foreach ($updates as $row) {
            $row->replaces .= ',SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW';
            $row->save();
        }

        // Add the aerospace wings

        $awards = json_decode('[
        {
                "display_order": 1003,
                "name": "Solo Aerospace Wings",
                "code": "SAW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
        },
        {
                "display_order": 1004,
                "name": "Enlisted Aerospace Wings",
                "code": "EAW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
        {
                "display_order": 1005,
                "name": "Officer Aerospace Wings",
                "code": "OAW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
        {
                "display_order": 1006,
                "name": "Enlisted Senior Aerospace Wings",
                "code": "ESAW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1007,
                "name": "Officer Senior Aerospace Wings",
                "code": "OSAW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1008,
                "name": "Enlisted Master Aerospace Wings",
                "code": "EMAW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1009,
                "name": "Officer Master Aerospace Wings",
                "code": "OMAW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1010,
                "name": "Enlisted Navigator Wings",
                "code": "ENW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1011,
                "name": "Officer Navigator Wings",
                "code": "ONW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         }, 
         {
                "display_order": 1012,
                "name": "Enlisted Senior Navigator Wings",
                "code": "ESNW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         }, 
         {
                "display_order": 1013,
                "name": "Officer Senior Navigator Wings",
                "code": "OSNW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         }, 
         {
                "display_order": 1014,
                "name": "Enlisted Master Navigator Wings",
                "code": "EMNW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1015,
                "name": "Officer Master Navigator Wings",
                "code": "OMNW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1016,
                "name": "Enlisted Observer Wings",
                "code": "EOW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1017,
                "name": "Officer Observer Wings",
                "code": "OOW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1018,
                "name": "Enlisted Senior Observer Wings",
                "code": "ESOW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         }, 
         {
                "display_order": 1019,
                "name": "Officer Senior Observer Wings",
                "code": "OSOW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1020,
                "name": "Enlisted Master Observer Wings",
                "code": "EMOW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1021,
                "name": "Officer Master Observer Wings",
                "code": "OMOW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1022,
                "name": "Enlisted Simulator Wings",
                "code": "ESW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,OSW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1023,
                "name": "Officer Simulator Wings",
                "code": "OSW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,ESSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1024,
                "name": "Enlisted Senior Simulator Wings",
                "code": "ESSW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,OSSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1025,
                "name": "Officer Senior Simulator Wings",
                "code": "OSSW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,EMSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1026,
                "name": "Enlisted Master Simulator Wings",
                "code": "EMSW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,OMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         },
         {
                "display_order": 1027,
                "name": "Officer Master Simulator Wings",
                "code": "OMSW",
                "post_nominal": "",
                "replaces": "HS,OSWP,ESWP,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW",
                "location": "TL",
                "multiple": false,
                "group_label": "Qualification Badges"
         }                                                                                                                                                                                                            
        ]', true);

        foreach ($awards as $award) {
            Award::create($award);
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
