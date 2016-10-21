<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddChapterShowConfig extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        MedusaConfig::create([
          'key'   => 'chapter.show',
          'value' => json_decode('
                {
    "university_system": {
        "Regent": {
            "billet": "Regent",
            "display_order": 1
        },
        "Vice Regent": {
            "billet": "Vice Regent",
            "display_order": 2
        }
    },
    "university": {
        "Provost": {
            "billet": "Provost",
            "display_order": 1
        },
        "Deputy Provost": {
            "billet": "Vice Regent",
            "display_order": 2
        }
    },
    "college": {
        "Dean": {
            "billet": "Dean",
            "display_order": 1
        },
        "Assistant Dean": {
            "billet": "Vice Regent",
            "display_order": 2
        }
    },
    "academy": {
        "Commandant": {
            "billet": "Commandant",
            "display_order": 1
        },
        "Vice Commandant": {
            "billet": "Vice Commandant",
            "display_order": 2
        },
        "Chief of Staff": {
            "billet": "Chief of Staff",
            "display_order": 3
        },
        "Flag Lieutenant": {
            "billet": "Flag Lieutenant",
            "display_order": 4
        },
        "Senior Master Chief Petty Officer": {
            "billet": "Senior Master Chief",
            "display_order": 5
        },
        "Command Senior Master Chief": {
            "billet": "Command Senior Master Chief",
            "display_order": 5
        },
        "Command Sergeant Major": {
            "billet": "Command Sergeant Major",
            "display_order": 5
        }
    },
    "ship": {
        "Commanding Officer": {
            "billet": "Commanding Officer",
            "display_order": 1
        },
        "Executive Officer": {
            "billet": "Executive Officer",
            "display_order": 2
        },
        "Bosun": {
            "billet": "Bosun",
            "display_order": 3
        }
    },
    "bureau": {
        "%ordinal% Space Lord": {
            "billet": "%ordinal% Space Lord",
            "display_order": 1,
            "exact": false
        },
        "Deputy %ordinal% Space Lord": {
            "billet": "Deputy Space Lord",
            "display_order": 2
        },
        "Chief of Staff": {
            "billet": "Chief of Staff",
            "display_order": 3
        },
        "Flag Lieutenant": {
            "billet": "Flag Lieutenant",
            "display_order": 4
        },
        "Senior Master Chief Petty Officer": {
            "billet": "Senior Master Chief",
            "display_order": 5
        },
        "Command Senior Master Chief": {
            "billet": "Command Senior Master Chief",
            "display_order": 5
        }
    },
    "office": {
        "Director": {
            "billet": "Director",
            "display_order": 1
        },
        "Deputy Director": {
            "billet": "Deputy Director",
            "display_order": 2
        },
        "First Lord of the Admiralty": {
            "billet": "First Lord of the Admiralty",
            "display_order": 1,
            "exact": false
        },
        "Judge Advocate General": {
            "billet": "Judge Advocate General",
            "display_order": 1
        },
        "Deputy Judge Advocate General": {
            "billet": "Deputy Judge Advocate General",
            "display_order": 2
        },
        "Senior Master CPO of the Navy": {
            "billet": "Senior Master CPO of the Navy",
            "display_order": 1
        }
    },
    "fleet": {
        "Fleet Commander": {
            "billet": "Commanding Officer",
            "display_order": 1
        },
        "Deputy Fleet Commander": {
            "billet": "Deputy Fleet Commander",
            "display_order": 2
        },
        "Chief of Staff": {
            "billet": "Chief of Staff",
            "display_order": 3
        },
        "Flag Lieutenant": {
            "billet": "Flag Lieutenant",
            "display_order": 4
        },
        "Fleet Bosun": {
            "billet": "Bosun",
            "display_order": 5
        }
    },
    "platoon": {
        "Commanding Officer": {
            "billet": "Commanding Officer",
            "display_order": 1
        },
        "Gunny": {
            "billet": "Gunny",
            "display_order": 2
        }
    }
}
		')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        MedusaConfig::where('key', '=', 'chapter.show')->firstOrFail()->delete();
    }

}
