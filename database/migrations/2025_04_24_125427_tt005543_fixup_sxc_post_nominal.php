<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Award;

class Tt005543FixupSxcPostNominal extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $award = Award::where('name', 'Sphinx Cross')->first();

        $award->post_nominal = 'SXC';

        $this->writeAuditTrail(
            'system user',
            'update',
            'award',
            $award->id,
            json_encode($award->toJson()),
            'fixup_sxc_post_nominal'
        );

        $award->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $award = Award::where('name', 'Sphinx Cross')->first();

        $award->post_nominal = '';

        $this->writeAuditTrail(
            'system user',
            'rollback',
            'award',
            $award->id,
            json_encode($award->toJson()),
            'fixup_sxc_post_nominal'
        );

        $award->save();
    }
}
