<?php

use Illuminate\Database\Migrations\Migration;

class NewRibbons extends Migration
{
    private $awards = '[{
		"display_order": 3,
		"name": "Adrienne Cross",
		"code": "AC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true
	},
	{
		"display_order": 6,
		"name": "Knight Grand Cross of the Most Eminent Order of the Golden Lion",
		"code": "GCGL",
		"post_nominal": "GCGL",
		"replaces": "KDGL,KCGL,CGL,OGL,MGL,GLM",
		"location": "L",
		"multiple": false,
		"group_label": "Most Eminent Order of the Golden Lion"
	},
	{
		"display_order": 10,
		"name": "Knight Commander of the Most Eminent Order of the Golden Lion",
		"code": "KDGL",
		"post_nominal": "KDGL",
		"replaces": "GCGL,KCGL,CGL,OGL,MGL,GLM",
		"location": "L",
		"multiple": false,
		"group_label": "Most Eminent Order of the Golden Lion"
	},
	{
		"display_order": 13,
		"name": "Knight Companion of the Most Eminent Order of the Golden Lion",
		"code": "KCGL",
		"post_nominal": "KCGL",
		"replaces": "GCGL,KDGL,CGL,OGL,MGL,GLM",
		"location": "L",
		"multiple": false,
		"group_label": "Most Eminent Order of the Golden Lion"
	},
	{
		"display_order": 22,
		"name": "Companion of the Most Eminent Order of the Golden Lion",
		"code": "CGL",
		"post_nominal": "CGL",
		"replaces": "GCGL,KDGL,KCGL,OGL,MGL,GLM",
		"location": "L",
		"multiple": false,
		"group_label": "Most Eminent Order of the Golden Lion"
	},
	{
		"display_order": 28,
		"name": "Officer of the Most Eminent Order of the Golden Lion",
		"code": "OGL",
		"post_nominal": "OGL",
		"replaces": "GCGL,KDGL,KCGL,CLG,MGL,GLM",
		"location": "L",
		"multiple": false,
		"group_label": "Most Eminent Order of the Golden Lion"
	},
	{
		"display_order": 34,
		"name": "Member of the Most Eminent Order of the Golden Lion",
		"code": "MGL",
		"post_nominal": "MGL",
		"replaces": "GCGL,KDGL,KCGL,CGL,OGL,GLM",
		"location": "L",
		"multiple": false,
		"group_label": "Most Eminent Order of the Golden Lion"
	},
	{
		"display_order": 54,
		"name": "Medal, Most Eminent Order of the Golden Lion",
		"code": "GLM",
		"post_nominal": "GLM",
		"replaces": "GCGL,KDGL,KCGL,CGL,OGL,MGL",
		"location": "L",
		"multiple": false,
		"group_label": "Most Eminent Order of the Golden Lion"
	},
	{
        "display_order" : 88,
        "name" : "Navy Rifle Marksmanship Certificate",
        "code" : "NRMC",
        "post_nominal" : "",
        "replaces" : "",
        "location" : "NA",
        "multiple" : false,
        "group_label" : "Rifle Marksmanship"
	},
	{
        "display_order" : 89,
        "name" : "Navy Pistol Marksmanship Certificate",
        "code" : "NPMC",
        "post_nominal" : "",
        "replaces" : "",
        "location" : "NA",
        "multiple" : false,
        "group_label" : "Pistol Marksmanship"
	}
]';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (json_decode($this->awards, true) as $award) {
            App\Award::create($award);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (json_decode($this->awards, true) as $award) {
            App\Award::where('code', $award['code'])->delete();
        }
    }
}
