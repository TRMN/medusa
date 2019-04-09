<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Chapter;
use App\Echelons\MedusaEchelons;
use App\MedusaConfig;

class AnyUnitController extends Controller
{
    private $chapterTypes = [];
    private $permissions = ['ADD' => 'ALL_PERMS', 'EDIT' => 'ALL_PERMS', 'DELETE' => 'ALL_PERMS'];
    private $auditName = 'AnyUnitController';
    private $select = 'Select a Unit Type';
    private $title = 'a Unit';
    private $branch = 'RMMC';
    private $routePrefix = 'anyunit';

    use MedusaEchelons;

    public function __construct()
    {
        parent::__construct();

        $this->chapterTypes = Medusaconfig('anyunit.types', [
            'district',
            'fleet',
            'task_force',
            'task_group',
            'squadron',
            'division',
            'ship',
            'station',
            'headquarters',
            'bivouac',
            'barracks',
            'outpost',
            'fort',
            'planetary',
            'theater',
            'bureau',
            'office',
            'academy',
            'school',
            'corps',
            'exp_force',
            'regiment',
            'shuttle',
            'section',
            'squad',
            'platoon',
            'company',
            'battalion',
            'college',
            'institute',
            'center',
            'university',
            'university_system',
        ]);
    }

    private function getCommands()
    {
        $chapters = Chapter::getChapters('', 0, false);

        asort($chapters);

        return $chapters;
    }

    private function getBranches()
    {
        return '<div class="row">
    <div class="col-sm-6  ninety Incised901Light form-group">'.
        \Form::label('branch', 'Branch').' '.\Form::select('branch', Branch::getBranchList(), null, ['class' => 'selectize']).'
    </div>
</div>';
    }
}
