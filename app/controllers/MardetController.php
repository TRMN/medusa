<?php

class MardetController extends \BaseController {

    private $chapterTypes = ['shuttle', 'section', 'squad', 'platoon', 'company', 'battalion'];
    private $permissions = ['ADD' => 'ADD_MARDET', 'EDIT' => 'EDIT_MARDET', 'DELETE' => 'DELETE_MARDET'];
    private $auditName = 'MardetController';
    private $select = 'Select a MARDET Type';
    private $title = 'a MARDET';
    private $branch = 'RMMC';

    use Medusa\Echelons\MedusaEchelons;

    private function getCommands()
    {
        $chapters = Chapter::getChaptersByType('ship');

        asort($chapters);

        return $chapters;
    }

}