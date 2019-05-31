<?php

use Illuminate\Database\Migrations\Migration;

class AddSenator extends Migration
{
    use App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function up()
    {
        $title = 'Senator for Life';
        $code = 'L';
        $precedence = '2';

        try {
            App\Models\Ptitles::create(['title' => $title, 'code' => $code, 'precedence' => $precedence]);

            $this->writeAuditTrail(
                'system user',
                'create',
                'ptitles',
                null,
                json_encode(['title' => $title, 'code' => $code, 'precedence' => $precedence]),
                'AddSenator'
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function down()
    {
        $title = 'Senator for Life';
        $code = 'L';

        try {
            App\Models\Ptitles::where('title', $title)->where('code', $code)->delete();

            $this->writeAuditTrail(
                'system user',
                'delete',
                'ptitles',
                null,
                json_encode(['title' => $title, 'code' => $code]),
                'AddSenator'
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
