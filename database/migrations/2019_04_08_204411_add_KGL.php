<?php

use App\Award;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

class AddKGL extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $output = new ConsoleOutput();
        // Add Knight, GL
        Award::create(
            [
                'display_order' => 19,
                'name'          => 'Knight of the Most Eminent Order of the Golden Lion',
                'code'          => 'KGL',
                'post_nominal'  => 'KGL',
                'replaces'      => 'GCGL,KDGL,KCGL,CGL,OGL,MGL,GLM',
                'location'      => 'L',
                'multiple'      => false,
                'group_label'   => 'Most Eminent Order of the Golden Lion',
                'points'        => 2.5,
                'star_nation'   => 'manticore',
            ]
        );

        /**
         * Grand Cross : GCGL
         * Knight Commander: KDGL
         * Knight Companion: KCGL
         * Knight: KGL
         * Companion: CGL
         * Officer: OGL
         * Member: MGL
         * Medal: GLM.
         */

        // Make sure that the rest of the GL have the right replaces
        $gl = [
          'GCGL' => 'KDGL,KCGL,KGL,CGL,OGL,MGL,GLM',
          'KDGL' => 'GCGL,KCGL,KGL,CGL,OGL,MGL,GLM',
          'KCGL' => 'GCGL,KDGL,KGL,CGL,OGL,MGL,GLM',
          'CGL'  => 'GCGL,KDGL,KCGL,KGL,OGL,MGL,GLM',
          'OGL'  => 'GCGL,KDGL,KCGL,KGL,CGL,MGL,GLM',
          'MGL'  => 'GCGL,KDGL,KCGL,KGL,CGL,OGL,GLM',
          'GLM'  => 'GCGL,KDGL,KCGL,KGL,CGL,OGL,MGL',
        ];

        foreach ($gl as $code => $replaces) {
            try {
                $award = Award::where('code', $code)->firstOrFail();
                $award->replaces = $replaces;
                $award->save();
            } catch (Exception $e) {
                break;
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Award::where('code', 'KGL')->delete();
    }
}
