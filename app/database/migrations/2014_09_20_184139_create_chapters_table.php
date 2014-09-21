<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChaptersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'chapters', function( Blueprint $table )
        {
            $table->increments( 'id' )->unsigned();
            $table->string( 'title' );
            $table->string( 'crest' );
            $table->integer( 'co' )->unsigned();
            $table->integer( 'chapterable_id' )->unsigned();
            $table->string( 'chapterable_type' );
            $table->timestamps();
        });

        Schema::create( 'chapter_user', function( Blueprint $table )
        {
            $table->integer( 'chapter_id' )->unsigned();
            $table->integer( 'user_id' )->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'chapters' );
        Schema::drop( 'chapter_to_user' );
    }
}
