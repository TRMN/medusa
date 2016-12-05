<?php

namespace App\Http\Controllers;

use Smalldogs\Html5inputs\Html5InputsFacade;

class UnitController extends Controller
{

    private $chapterTypes = ['bivouac', 'barracks', 'outpost', 'fort', 'planetary', 'theater'];
    private $permissions = ['ADD' => 'ADD_UNIT', 'EDIT' => 'EDIT_UNIT', 'DELETE' => 'DELETE_UNIT'];
    private $auditName = 'UnitController';
    private $select = 'Select a Command/Unit Type';
    private $title = 'a Command or Unit';
    private $branch = 'RMA';
    private $routePrefix = 'unit';

    use Medusa\Echelons\MedusaEchelons;

    private function getCommands()
    {
        $chapters = [];

        foreach ($this->chapterTypes as $type) {
            $chapters = array_merge($chapters, \Chapter::getChaptersByType($type));
        }

        $hq = \Chapter::where('chapter_name', '=', "King William's Tower")->first();

        $chapters[$hq->id] = $hq->chapter_name . ' (' . $hq->branch . ')';

        asort($chapters);

        return $chapters;
    }

    private function getBranches()
    {
        return Form::hidden('branch', $this->branch);
    }
}
