<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewRibbons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $awards = json_decode('[{
		"display_order": 3,
		"name": "Adrienne Cross",
		"code": "AC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "RMA"
	},
	{
		"display_order": 2,
		"name": "Saint Austin\’s Cross",
		"code": "SAC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "GSN"
	},
	{
		"display_order": 64,
		"name": "Army Regimental Excellence Award",
		"code": "AREA",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "RMA"
	},
	{
		"display_order": 64,
		"name": "Army Regimental Excellence Award in Gold",
		"code": "AREAG",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "RMA"
	},
	{
		"display_order": 79,
		"name": "Army Space Duty Ribbon",
		"code": "ASDR",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": false,
		"branch": "RMA"
	},
	{
		"display_order": ,
		"name": "Armsman\'s Cross in Silver",
		"code": "ArCAg",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 31,
		"name": "Armsman\'s Cross in Gold",
		"code": "ArCAu",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 16,
		"name": "Armsman\'s Cross with Diamonds",
		"code": "ArCD",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 50,
		"name": "Armsman\'s Cross in Steel",
		"code": "ArCFe",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 31,
		"name": "Armsman\'s Cross with Crossed Swords",
		"code": "ArCX",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 26,
		"name": "Armsman\'s Cross with Laurel Wreath",
		"code": "ArCW",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 37,
		"name": "Armsman\'s Cross in Bronze",
		"code": "ArCCu",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 47,
		"name": "Cross of Courage in Silver",
		"code": "CCCAg",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 42,
		"name": "Cross of Courage in Gold",
		"code": "CCCAu",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 8,
		"name": "Cross of Courage with Diamonds",
		"code": "CCCD",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 56,
		"name": "Cross of Courage in Steel",
		"code": "CCCFe",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 41,
		"name": "Cross of Courage with Crossed Swords",
		"code": "CCCX",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 32,
		"name": "Cross of Courage with Laurel Wreath",
		"code": "CCCW",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 48,
		"name": "Cross of Courage in Bronze",
		"code": "CCCCu",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": ,
		"name": "Sword\'s Cross in Silver",
		"code": "SwCAg",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 43,
		"name": "Sword\'s Cross in Gold",
		"code": "SwCAu",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 15,
		"name": "Sword\'s Cross with Diamonds",
		"code": "SwCD",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 50,
		"name": "Sword\'s Cross in Steel",
		"code": "SwCFe",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 30,
		"name": "Sword\'s Cross with Crossed Swords",
		"code": "SwCX",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 24,
		"name": "Sword\'s Cross with Laurel Wreath",
		"code": "SwCW",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 37,
		"name": "Sword\'s Cross in Bronze",
		"code": "SwCCu",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 4,
		"name": "Protector\s Cross",
		"code": "PC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "GSN"
	},
	{
		"display_order": 66,
		"name": "Survivor\'s Cross",
		"code": "GSvC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "GSN"
	},
	{
		"display_order": 64,
		"name": "Fleet Excellence Award in Gold",
		"code": "FEAG",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "RMN"
	},
	{
		"display_order": 6,
		"name": "Knight Grand Cross of the Most Eminent Order of the Golden Lion",
		"code": "GCGL",
		"post_nominal": "GCGL",
		"replaces": "KDGL,KCGL,CGL,OGL,MGL,GLM",
		"location": "L",
		"multiple": false,
		"branch": "CIVIL"
	},
	{
		"display_order": 10,
		"name": "Knight Commander of the Most Eminent Order of the Golden Lion",
		"code": "KDGL",
		"post_nominal": "KDGL",
		"replaces": "GCGL,KCGL,CGL,OGL,MGL,GLM",
		"location": "L",
		"multiple": false,
		"branch": "CIVIL"
	},
	{
		"display_order": 13,
		"name": "Knight Companion of the Most Eminent Order of the Golden Lion",
		"code": "KCGL",
		"post_nominal": "KCGL",
		"replaces": "GCGL,KDGL,CGL,OGL,MGL,GLM",
		"location": "L",
		"multiple": false,
		"branch": "CIVIL"
	},
	{
		"display_order": 22,
		"name": "Companion of the Most Eminent Order of the Golden Lion",
		"code": "CGL",
		"post_nominal": "CGL",
		"replaces": "GCGL,KDGL,KCGL,OGL,MGL,GLM",
		"location": "L",
		"multiple": false,
		"branch": "CIVIL"
	},
	{
		"display_order": 28,
		"name": "Officer of the Most Eminent Order of the Golden Lion",
		"code": "OGL",
		"post_nominal": "OGL",
		"replaces": "GCGL,KDGL,KCGL,CLG,MGL,GLM",
		"location": "L",
		"multiple": false,
		"branch": "CIVIL"
	},
	{
		"display_order": 34,
		"name": "Member of the Most Eminent Order of the Golden Lion",
		"code": "MGL",
		"post_nominal": "MGL",
		"replaces": "GCGL,KDGL,KCGL,CGL,OGL,GLM",
		"location": "L",
		"multiple": false,
		"branch": "CIVIL"
	},
	{
		"display_order": 54,
		"name": "Medal, Most Eminent Order of the Golden Lion",
		"code": "GLM",
		"post_nominal": "GLM",
		"replaces": "GCGL,KDGL,KCGL,CGL,OGL,MGL",
		"location": "L",
		"multiple": false,
		"branch": "CIVIL"
	},
	{
		"display_order": 73,
		"name": "Grayson-Masada War Campaign Medal",
		"code": "GMC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": false,
		"branch": "GSN"
	},
	{
		"display_order": 69,
		"name": "GSN Havenite War Campaign Medal",
		"code": "GSNHWC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "GSN"
	},
	{
		"display_order": ,
		"name": "Personal List of Honor Citation",
		"code": "LOHP",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "RMN"
	},
	{
		"display_order": ,
		"name": "Grayson Space Navy Long Service and Good Conduct Medal",
		"code": "LSGC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "GSN"
	},
	{
		"display_order": 71,
		"name": "Manticore and Havenite 1905-1922 War Medal",
		"code": "MHWM",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "RMN"
	},
	{
		"display_order": 63,
		"name": "Meritorious Unit Award",
		"code": "MUA",
		"post_nominal": "",
		"replaces": "",
		"location": "R",
		"multiple": true,
		"branch": "GSN"
	},
	{
		"display_order": ,
		"name": "Naval Star of Gallantry",
		"code": "NSG",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "GSN"
	},
	{
		"display_order": 62,
		"name": "Protector\'s Unit Citation for Gallantry",
		"code": "PUC",
		"post_nominal": "",
		"replaces": "",
		"location": "R",
		"multiple": true,
		"branch": "GSN"
	},
	{
		"display_order": ,
		"name": "Grayson Space Navy Reserve Long Service and Good Conduct Medal",
		"code": "RSGC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 1,
		"name": "Star of Grayson",
		"code": "SG",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "GSN"
	},
	{
		"display_order": 74,
		"name": "Second Grayson-Masada War Campaign Medal",
		"code": "SGMC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "GSN"
	},
	{
		"display_order": 79,
		"name": "Space Service Ribbon",
		"code": "SSR",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": false,
		"branch": "GSN"
	},
	{
		"display_order": 48,
		"name": "Sphinx Cross",
		"code": "SXC",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": ,
		"branch": "RMN"
	},
	{
		"display_order": 44,
		"name": "Wound Medal",
		"code": "WM",
		"post_nominal": "",
		"replaces": "",
		"location": "L",
		"multiple": true,
		"branch": "GSN"
	}
]', true);
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
