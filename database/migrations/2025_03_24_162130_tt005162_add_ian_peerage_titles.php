<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tt005162AddIanPeerageTitles extends Migration
{
    use \App\Audit\MedusaAudit;

    protected $titles = [
        'Fürst' => '1:Fu',
        'Fürstin' => '1:Fu',
        'Herzog' => '2:He',
        'Herzogin' => '2:He',
        'Graf' => '3:Gr',
        'Gräfin' => '3:Gr',
        'Freiherr' => '4:Fr',
        'Freifrau' => '4:Fr',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->titles as $title => $value) {
            [$precedence, $code] = explode(':', $value);

            $this->writeAuditTrail(
                'system user',
                'create',
                'permissions',
                null,
                json_encode(['title' => $title, 'code' => $code, 'precedence' => $precedence]),
                'add_ian_peerage_titles'
            );

            App\Ptitles::create(['title' => $title, 'code' => $code, 'precedence' => $precedence]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->titles as $title => $value) {
            [$precedence, $code] = explode(':', $value);

            $this->writeAuditTrail(
                'system user',
                'delete',
                'permissions',
                null,
                json_encode(['title' => $title, 'code' => $code, 'precedence' => $precedence]),
                'remove_ian_peerage_titles'
            );

            App\Ptitles::where('title', $title)->first()->delete();
	}
    }
}
