<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSenator extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     * @throws \Exception
     */
    public function up()
    {
        $title = 'Senator for Life';
        $code = 'L';
        $precedence = '2';

        try {
            App\Ptitles::create(["title" => $title, "code" => $code, "precedence" => $precedence]);

            $this->writeAuditTrail(
                'system user',
                'create',
                'ptitles',
                null,
                json_encode(["title" => $title, "code" => $code, "precedence" => $precedence]),
                'AddSenator'
            );
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws \Exception
     */
    public function down()
    {
        $title = 'Senator for Life';
        $code = 'L';

        try {
            App\Ptitles::where('title', $title)->where('code', $code)->delete();

            $this->writeAuditTrail(
                'system user',
                'delete',
                'ptitles',
                null,
                json_encode(["title" => $title, "code" => $code]),
                'AddSenator'
            );


        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
