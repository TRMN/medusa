<?php

use Illuminate\Database\Migrations\Migration;

class BupersPromotionRequirements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = json_decode('{
  "E-2": {
    "tig": 2,
    "line": {
      "points": 3,
      "exam": [ "0001" ]
    },
    "staff": {
      "points": 3,
      "exam": []
    },
    "service": {
      "points": 3,
      "exam": []
    }
  },
  "E-3": {
    "tig": 4,
    "line": {
      "points": 6,
      "exam": [ "0001" ]
    },
    "staff": {
      "points": 6,
      "exam": []
    },
    "service": {
      "points": 6,
      "exam": []
    }
  },
  "E-4": {
    "tig": 5,
    "line": {
      "points": 9,
      "exam": [ "0002" ]
    },
    "staff": {
      "points": 9,
      "exam": [ "0001" ]
    },
    "service": {
      "points": 9,
      "exam": [ "0001" ]
    }
  },
  "E-5": {
    "tig": 6,
    "line": {
      "points": 18,
      "exam": [ "0002" ]
    },
    "staff": {
      "points": 14,
      "exam": [ "0002" ]
    },
    "service": {
      "points": 12,
      "exam": [ "0001" ]
    }
  },
  "E-6": {
    "tig": 7,
    "line": {
      "points": 36,
      "exam": [ "0003" ]
    },
    "staff": {
      "points": 26,
      "exam": [ "0003" ]
    },
    "service": {
      "points": 18,
      "exam": [ "0002" ]
    }
  },
  "E-7": {
    "tig": 9,
    "line": {
      "points": 45,
      "exam": [ "0003" ]
    },
    "staff": {
      "points": 35,
      "exam": [ "0003" ]
    },
    "service": {
      "points": 21,
      "exam": [ "0002" ]
    }
  },
  "E-8": {
    "tig": 12,
    "line": {
      "points": 54,
      "exam": [ "0004" ]
    },
    "staff": {
      "points": 42,
      "exam": [ "0004" ]
    }
  },
  "E-9": {
    "tig": 15,
    "line": {
      "points": 63,
      "exam": [ "0005" ]
    },
    "staff": {
      "points": 52,
      "exam": [ "0004" ]
    }
  },
  "E-10": {
    "tig": 18,
    "line": {
      "points": 72,
      "exam": [ "0006" ]
    }
  },
  "C-2": {
    "tig": 2,
    "line": {
      "points": 3,
      "exam": [ "0001" ]
    },
    "staff": {
      "points": 3,
      "exam": []
    },
    "service": {
      "points": 3,
      "exam": []
    }
  },
  "C-3": {
    "tig": 4,
    "line": {
      "points": 6,
      "exam": [ "0001" ]
    },
    "staff": {
      "points": 6,
      "exam": []
    },
    "service": {
      "points": 6,
      "exam": []
    }
  },
  "C-4": {
    "tig": 5,
    "line": {
      "points": 9,
      "exam": [ "0002" ]
    },
    "staff": {
      "points": 9,
      "exam": [ "0001" ]
    },
    "service": {
      "points": 9,
      "exam": [ "0001" ]
    }
  },
  "C-5": {
    "tig": 6,
    "line": {
      "points": 18,
      "exam": [ "0002" ]
    },
    "staff": {
      "points": 14,
      "exam": [ "0002" ]
    },
    "service": {
      "points": 12,
      "exam": [ "0001" ]
    }
  },
  "C-6": {
    "tig": 7,
    "line": {
      "points": 36,
      "exam": [ "0003" ]
    },
    "staff": {
      "points": 26,
      "exam": [ "0003" ]
    },
    "service": {
      "points": 18,
      "exam": [ "0002" ]
    }
  },
  "C-7": {
    "tig": 9,
    "line": {
      "points": 45,
      "exam": [ "0003" ]
    },
    "staff": {
      "points": 35,
      "exam": [ "0003" ]
    },
    "service": {
      "points": 21,
      "exam": [ "0002" ]
    }
  },
  "C-8": {
    "tig": 12,
    "line": {
      "points": 54,
      "exam": [ "0004" ]
    },
    "staff": {
      "points": 42,
      "exam": [ "0004" ]
    }
  },
  "C-9": {
    "tig": 15,
    "line": {
      "points": 63,
      "exam": [ "0005" ]
    },
    "staff": {
      "points": 52,
      "exam": [ "0004" ]
    }
  },
  "C-10": {
    "tig": 18,
    "line": {
      "points": 72,
      "exam": [ "0006" ]
    }
  },
  "WO-1": {
    "tig": 4,
    "as": ["E-4", "E-5", "E-6", "E-7", "E-8", "E-9", "E-10"],
    "line": {
      "points": 18,
      "exam": [ "0011" ]
    },
    "staff": {
      "points": 18,
      "exam": [ "0011" ]
    },
    "service": {
      "points": 18,
      "exam": []
    }
  },
  "WO-2": {
    "tig": 6,
    "line": {
      "points": 36,
      "exam": [ "0011" ]
    },
    "staff": {
      "points": 26,
      "exam": [ "0011" ]
    },
    "service": {
      "points": 24,
      "exam": [ "0011" ]
    }
  },
  "WO-3": {
    "tig": 9,
    "line": {
      "points": 45,
      "exam": [ "0012" ]
    },
    "staff": {
      "points": 35,
      "exam": [ "0012" ]
    }
  },
  "C-11": {
    "tig": 9,
    "line": {
      "points": 45,
      "exam": [ "0012" ]
    },
    "staff": {
      "points": 35,
      "exam": [ "0012" ]
    }
  },
  "WO-4": {
    "tig": 12,
    "line": {
      "points": 60,
      "exam": [ "0012" ]
    }
  },
  "WO-5": {
    "tig": 15,
    "line": {
      "points": 72,
      "exam": [ "0013" ]
    }
  },
  "O-1": {
    "tig": 4,
    "as": ["E-4", "E-5", "E-6", "E-7", "E-8", "E-9", "E-10"],
    "line": {
      "points": 18,
      "exam": [ "0101" ]
    },
    "staff": {
      "points": 18,
      "exam": [ "0101" ]
    },
    "service": {
      "points": 18,
      "exam": [ "0101" ]
    }
  },
  "C-12": {
    "tig": 4,
    "as": ["C-4", "C-5", "C-6", "C-7", "C-8", "C-9", "C-10"],
    "line": {
      "points": 18,
      "exam": [ "0101" ]
    },
    "staff": {
      "points": 18,
      "exam": [ "0101" ]
    },
    "service": {
      "points": 18,
      "exam": [ "0101" ]
    }
  },
  "O-2": {
    "tig": 6,
    "line": {
      "points": 24,
      "exam": [ "0102" ]
    },
    "staff": {
      "points": 24,
      "exam": [ "0102" ]
    },
    "service": {
      "points": 24,
      "exam": [ "0101" ]
    }
  },
  "O-3": {
    "tig": 9,
    "line": {
      "points": 32,
      "exam": [ "0103" ]
    },
    "staff": {
      "points": 30,
      "exam": [ "0102" ]
    },
    "service": {
      "points": 27,
      "exam": [ "0101" ]
    }
  },
  "O-4": {
    "tig": 12,
    "line": {
      "points": 40,
      "exam": [ "0104", "0113" ]
    },
    "staff": {
      "points": 36,
      "exam": [ "0102" ]
    },
    "service": {
      "points": 32,
      "exam": [ "0101" ]
    }
  },
  "O-5": {
    "tig": 15,
    "line": {
      "points": 48,
      "exam": [ "0105" ]
    },
    "staff": {
      "points": 44,
      "exam": [ "0103" ]
    }
  },
  "O-6": {
    "tig": 18,
    "line": {
      "points": 56,
      "exam": [ "0106", "0113" ]
    },
    "staff": {
      "points": 52,
      "exam": [ "0103" ]
    }
  },
  "C-13": {
    "tig": 6,
    "line": {
      "points": 24,
      "exam": [ "0102" ]
    },
    "staff": {
      "points": 24,
      "exam": [ "0102" ]
    },
    "service": {
      "points": 24,
      "exam": [ "0101" ]
    }
  },
  "C-14": {
    "tig": 9,
    "line": {
      "points": 32,
      "exam": [ "0103" ]
    },
    "staff": {
      "points": 30,
      "exam": [ "0102" ]
    },
    "service": {
      "points": 27,
      "exam": [ "0101" ]
    }
  },
  "C-15": {
    "tig": 12,
    "line": {
      "points": 40,
      "exam": [ "0104", "0113" ]
    },
    "staff": {
      "points": 36,
      "exam": [ "0102" ]
    },
    "service": {
      "points": 32,
      "exam": [ "0101" ]
    }
  },
  "C-16": {
    "tig": 15,
    "line": {
      "points": 48,
      "exam": [ "0105" ]
    },
    "staff": {
      "points": 44,
      "exam": [ "0103" ]
    }
  },
  "C-17": {
    "tig": 18,
    "line": {
      "points": 56,
      "exam": [ "0106", "0113" ]
    },
    "staff": {
      "points": 52,
      "exam": [ "0103" ]
    }
  },
  "O-6-A": {
    "tig": 18,
    "line": {
      "points": 56,
      "exam": [ "0106", "0113" ]
    },
    "staff": {
      "points": 52,
      "exam": [ "0103" ]
    }
  },
  "O-6-B": {
    "line": {
      "points": 63,
      "exam": [ "1001" ]
    },
    "staff": {
      "points": 63,
      "exam": [ "0104", "0113" ]
    }
  },
  "F-1": {
    "line": {
      "points": 73,
      "exam": [ "1001" ]
    },
    "staff": {
      "points": 73,
      "exam": [ "0105" ]
    }
  },
  "C-18": {
    "line": {
      "points": 73,
      "exam": [ "1001" ]
    },
    "staff": {
      "points": 73,
      "exam": [ "0105" ]
    }
  },
  "F-2": {
    "line": {
      "points": 83,
      "exam": [ "1002" ]
    },
    "staff": {
      "points": 83,
      "exam": [ "0106", "0115" ]
    }
  },
  "C-19": {
    "line": {
      "points": 83,
      "exam": [ "1002" ]
    },
    "staff": {
      "points": 83,
      "exam": [ "0106", "0115" ]
    }
  },
  "F-2-A": {
    "line": {
      "points": 83,
      "exam": [ "1002" ]
    },
    "staff": {
      "points": 83,
      "exam": [ "0106", "0115" ]
    }
  },
  "F-2-B": {
    "line": {
      "points": 93,
      "exam": [ "1002" ]
    },
    "staff": {
      "points": 93,
      "exam": [ "1001" ]
    }
  },
  "F-3": {
    "line": {
      "points": 103,
      "exam": [ "1003" ]
    }
  },
  "C-20": {
    "line": {
      "points": 103,
      "exam": [ "1003" ]
    }
  },
  "F-3-A": {
    "line": {
      "points": 103,
      "exam": [ "1003" ]
    }
  },
  "F-3-B": {
    "line": {
      "points": 113,
      "exam": [ "1003" ]
    }
  },
  "F-4": {
    "line": {
      "points": 113,
      "exam": [ "1004" ]
    }
  },
  "C-21": {
    "line": {
      "points": 113,
      "exam": [ "1004" ]
    }
  },
  "F-4-A": {
    "line": {
      "points": 113,
      "exam": [ "1004" ]
    }
  },
  "F-4-B": {
    "line": {
      "points": 123,
      "exam": [ "1004" ]
    }
  },
  "F-5": {
    "line": {
      "points": 143,
      "exam": [ "1005" ]
    }
  },
  "C-22": {
    "line": {
      "points": 143,
      "exam": [ "1005" ]
    }
  },
  "F-5-A": {
    "line": {
      "points": 143,
      "exam": [ "1005" ]
    }
  },
  "F-5-B": {
    "line": {
      "points": 153,
      "exam": [ "1005" ]
    }
  },
  "F-6": {
    "line": {
      "exam": [ "1005" ]
    }
  },
  "C-23": {
    "line": {
      "exam": [ "1005" ]
    }
  }
}', true);

        \App\Models\MedusaConfig::set('pp.requirements', $config);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\MedusaConfig::remove('pp.requirements');
    }
}
