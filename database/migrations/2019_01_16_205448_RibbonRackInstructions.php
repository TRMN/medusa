<?php

use Illuminate\Database\Migrations\Migration;

class RibbonRackInstructions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\MedusaConfig::set('rr.instructions', '<p>Currently, the Ribbon Rack Builder supports RMN/RMMC and a few RMA ribbons & badges. As the artwork becomes
            available, they will be added. You many notice that some ribbons or badges don\'t have any artwork
            shown. These items were added to allow the selection of them for promotion point calculations, they will be
            saved to your record, but currently won\'t show up in your ribbon rack. Once the artwork is available they
            willautomatically show up in your ribbon rack.
        </p>

        <p>Once you save your ribbon rack, it will be record in your MEDUSA record and displayed on your Service Record.
            There will be a link under your ribbon rack that will show you the HTML required to embed your ribbon rack
            in another website.</p>

        <p>Please select your awards from the list below, then click "Save". If an award can be awarded more than once,
            you will be able to select the number of times you have received the award.</p>');
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
