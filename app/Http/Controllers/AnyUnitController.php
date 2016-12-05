<?php

class AnyUnitController extends \BaseController
{

    private $chapterTypes = [
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
        'university_system'
    ];
    private $permissions = ['ADD' => 'ALL_PERMS', 'EDIT' => 'ALL_PERMS', 'DELETE' => 'ALL_PERMS'];
    private $auditName = 'AnyUnitController';
    private $select = 'Select a Unit Type';
    private $title = 'a Unit';
    private $branch = 'RMMC';
    private $routePrefix = 'anyunit';

    use Medusa\Echelons\MedusaEchelons;

    private function getCommands()
    {
        $chapters = Chapter::getChapters('', 0, false);

        asort($chapters);

        return $chapters;
    }

    private function getBranches()
    {
        return '<div class="row">
    <div class="end small-6 columns ninety Incised901Light end">' .
        Form::label('branch', "Branch") . ' ' . Form::select('branch', Branch::getBranchList()) . '
    </div>
</div>';
    }

}