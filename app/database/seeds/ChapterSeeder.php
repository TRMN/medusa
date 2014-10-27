<?php

class ChapterSeeder extends Seeder
{

    public function run()
    {
        DB::collection( 'chapters' )->delete();

        $district = Chapter::create( [ 'chapter_name' => "Third Naval District", "chapter_type" => 'district' ] );

        $fleet = Chapter::create( [ 'chapter_name' => 'Third Fleet (San Martino)', 'chapter_type' => 'fleet', 'assigned_to' => $district->_id ] );

        $desron31 = Chapter::create( [ "chapter_name" => "DesRon 31", "chapter_type" => 'squadron', 'assigned_to' => $fleet->_id ] );

        $desdiv311 = Chapter::create( [ "chapter_name" => "DesDiv 311", 'chapter_type' => "division", 'assigned_to' => $desron31->_id ] );

        $desdiv312 = Chapter::create( [ "chapter_name" => "DesDiv 312", 'chapter_type' => "division", 'assigned_to' => $desron31->_id ] );

        $desdiv313 = Chapter::create( [ "chapter_name" => "DesDiv 313", 'chapter_type' => "division", 'assigned_to' => $desron31->_id ] );

        // Let's create some Tin cans!

        Chapter::create( [ "chapter_name" => 'HMS Gaheris', 'chapter_type' => 'ship', 'hull_number' => 'DD-482', 'assigned_to' => $desdiv311->_id ] );
        Chapter::create( [ "chapter_name" => 'HMS Chaos', 'chapter_type' => 'ship', 'hull_number' => 'DD-57', 'assigned_to' => $desdiv311->_id ] );
        Chapter::create( [ "chapter_name" => 'HMS Devastation', 'chapter_type' => 'ship', 'hull_number' => 'DD-44', 'assigned_to' => $desdiv312->_id ] );
        Chapter::create( [ "chapter_name" => 'HMS Saladin', 'chapter_type' => 'ship', 'hull_number' => 'DD-515', 'assigned_to' => $desdiv312->_id ] );
        Chapter::create( [ "chapter_name" => 'HMS Ivanhoe', 'chapter_type' => 'ship', 'hull_number' => 'DD-480', 'assigned_to' => $desdiv313->_id ] );
        Chapter::create( [ "chapter_name" => 'HMS Vengeance', 'chapter_type' => 'ship', 'hull_number' => 'DD-11', 'assigned_to' => $desdiv313->_id ] );



    }
} 
