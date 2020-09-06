<?php

use Illuminate\Database\Migrations\Migration;

class AddPeerageTitles extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $titles = [
            'Grand Duke' => '1:G',
            'Grand Duchess' => '1:G',
            'Duke' => '2:D',
            'Duchess' => '2:D',
            'Steadholder' => '2:S',
            'Earl' => '3:C',
            'Countess' => '3:C',
            'Baron' => '4:B',
            'Baroness' => '4:B',
            'Knight' => '5:K',
            'Dame' => '5:K',
        ];

        foreach ($titles as $title => $value) {
            [$precedence, $code] = explode(':', $value);

            $this->writeAuditTrail(
                'system user',
                'create',
                'permissions',
                null,
                json_encode(['title' => $title, 'code' => $code, 'precedence' => $precedence]),
                'add_peerage_titles'
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
        //
    }
}
