<?php

use Illuminate\Database\Migrations\Migration;

class StarNationConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $starNations = [
            'manticore' => 'Star Empire of Manticore',
            'grayson' => 'Protectorate of Grayson',
            'andermani' => 'Andermani Empire',
            'haven' => 'Republic of Haven',
        ];

        \App\MedusaConfig::set('starnations', $starNations);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\MedusaConfig::remove('starnations');
    }
}
