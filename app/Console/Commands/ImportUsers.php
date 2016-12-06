<?php

namespace App\Console\Commands;

use App\Chapter;
use App\User;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Webpatser\Countries\Countries;

/*
 * Query to export member database

SELECT
    CONCAT('RMN-',LPAD(`user_id`,4,'0'),'-',IFNULL(DATE_FORMAT(`application_date`,'%y'),DATE_FORMAT(`registration_date`,'%y')),IF(`honorary`=1,'-H','')) AS member_id,
    first_name,
    middle_name,
    last_name,
    suffix,
    users.address1,
    users.address2,
    users.city,
    users.state AS state_province,
    users.zip AS postal_code,
    users.country,
    phone AS phone_number,
    email AS email_address,
    pass AS password,
    dob,
    IFNULL(
        rank_code,
        CASE branch
            WHEN 5 THEN 'C-1'
            ELSE 'E-1'
            END
    ) AS grade,
    CASE branch
        WHEN 1 THEN 'RMN'
        WHEN 2 THEN 'RMA'
        WHEN 3 THEN 'RMMC'
        WHEN 4 THEN 'GSN'
        WHEN 5 THEN 'CIVIL'
        WHEN 6 THEN 'RHN'
        WHEN 7 THEN 'IAN'
    END AS branch,
    ship_name,
    b1.name as primary_billet,
    b2.name as secondary_billet,
    registration_status,
    registration_date,
    application_date,
    active
FROM
    users
LEFT JOIN
    rank_map_all on (users.user_level = rank_map_all.user_level AND branch=branch_id)
LEFT JOIN
    ships using (ship_id)
LEFT JOIN
    billets AS b1 on billet_id1 = b1.id
LEFT JOIN
    billets AS b2 on billet_id2=b2.id
ORDER BY
    ship_name

 */


class ImportUsers extends Command
{
    use \App\Audit\MedusaAudit;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from the old system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        // Get the list of countries
        $results = Countries::getList();
        $countries = [];

        foreach ($results as $country) {
            $countries[$country['name']] = $country['iso_3166_3'];
        }

        // Get the users

        $this->comment('Reading user file');
        $users = Excel::load(app_path() . '/database/users.xlsx')->formatDates(true, 'Y-m-d')->toArray();
        $this->comment('User file loaded, started to process');

        foreach ($users as $user) {
            $user['rank']['grade'] = $user['grade'];
            $user['rank']['date_of_rank'] = '';
            unset($user['grade']);

            if ($user['ship_name'] != "NULL") {
                if ($user['ship_name'] === 'HMS Charon') {
                    $user['registration_status'] = 'Suspended';
                }

                if ($user['ship_name'] === 'HMS Tartarus') {
                    $user['registration_status'] = 'Expelled';
                }

                $user['assignment'][] =
                    ['chapter_id'   => $this->getChapterByName($user['ship_name'])[0]['_id'],
                     'billet'       => $user['primary_billet'],
                     'primary'      => true,
                     'chapter_name' => $user['ship_name']
                    ];

                if ($user['secondary_billet'] !== 'NULL') {
                    $user['assignment'][] =
                        ['chapter_id' => '', 'billet' => $user['secondary_billet'], 'primary' => false];
                }
            } else {
                $user['assignment'] = [];
            }

            // Default user permissions

            $user['permissions'] = [
                'LOGOUT',
                'CHANGE_PWD',
                'EDIT_SELF',
                'ROSTER',
                'TRANSFER'
            ];

            if ($user['primary_billet'] == "Commanding Officer") {
                $user['permissions'] = array_merge($user['permissions'], [
                    'DUTY_ROSTER',
                    'EXPORT_ROSTER',
                    'EDIT_WEBSITE',
                    'ASSIGN_NONCOMMAND_BILLET',
                    'PROMOTE_E601',
                    'REQUEST_PROMOTION',
                    'CHAPTER_REPORT'
                ]);

                $user['duty_roster'] = $user['assignment'][0]['chapter_id'];
            }

            if (( empty($user['secondary_billet']) === false ) &&
                  $user['secondary_billet'] == "Commanding Officer") {
                      $user['permissions'] = array_merge(
                          $user['permissions'],
                          [
                            'DUTY_ROSTER',
                            'EXPORT_ROSTER',
                            'EDIT_WEBSITE',
                            'ASSIGN_NONCOMMAND_BILLET',
                            'PROMOTE_E601',
                            'REQUEST_PROMOTION',
                            'CHAPTER_REPORT'
                          ]
                      );
            }

            $user['permissions'] = array_unique($user['permissions']);

            unset($user['ship_name'], $user['primary_billet'], $user['secondary_billet']);

            if ($user['registration_status'] === 'NULL') {
                $user['registration_status'] = 'Active';
            }

            if ($user['registration_date'] === 'NULL') {
                $user['registration_date'] = $user['application_date'];
            }

            if ($user['application_date'] === 'NULL') {
                $user['application_date'] = $user['registration_date'];
            }

            if ($user['rank']['grade'] == "E-1" ||
                $user['rank']['grade'] == "C-1") {
                    $user['rank']['date_of_rank'] = $user['application_date'];
            }

            if (isset($user['country'])) {
                if (array_key_exists($user['country'], $countries) === true) {
                    $user['country'] = $countries[$user['country']];
                }
            } else {
                $user['country'] = 'USA';
            }

            $user['state_province'] = User::normalizeStateProvince($user['state_province']);
            $user['awards'] = [];

            foreach ($user as $key => $value) {
                if (is_null($value) === true || $value === 'NULL') {
                    unset($user[$key]);
                }
            }

            if (isset($user['postal_code']) === true && empty($user['postal_code'])===false) {
                $user['postal_code'] = (string)$user['postal_code'];
            } else {
                $user['postal_code'] = '';
            }

            // Make sure this is not a duplicate user
            if (count(User::where('member_id', '=', $user['member_id'])->get()) === 0) {
                $this->writeAuditTrail('import', 'create', 'users', null, json_encode($user), 'import.user');

                $result = User::create($user);

                $u = User::find($result['_id']);

                foreach ($user as $key => $value) {
                    $u[$key] = $value;
                }

                $u->save();
            } else {
                $this->error("Duplicate user found! " . $user['member_id'] . " already exists in the database!");
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    protected function getChapterByName($name)
    {

        foreach (['-One' => '01', '-Two' => '02', ' One' => '01', ' Two' => '02'] as $pnum => $pid) {
            $name = $this->normalizePinnaceName($name, $pnum, $pid);
        }

        $results = Chapter::where('chapter_name', '=', $name)->get();
        if (count($results) > 0) {
            return $results;
        } else {
            $this->info("Chapter " . $name . " not found, creating...");
            $branch = '';
            $type = 'ship';

            $tmp = substr($name, 0, 3);

            switch ($tmp) {
                case 'GNS':
                    $branch = 'GSN';
                    break;
                case 'SMS':
                    $branch = 'IAN';
                    break;
                case 'Biv':
                    $branch = "RMA";
                    $type='bivouac';
                    break;
                case 'For':
                    $branch = "RMA";
                    $type = 'fort';
                    break;
                case 'HG ':
                    $branch = "RMA";
                    $type = 'outpost';
                    break;
                default:
                    $branch = 'RMN';
                    $type = 'ship';
            }

            $this->writeAuditTrail('import', 'create', 'chapters', null, json_encode(
                ['chapter_name' => $name, 'chapter_type' => $type, 'branch' => $branch]
            ), 'import.user');
            Chapter::create(['chapter_name' => $name, 'chapter_type' => $type, 'branch' => $branch]);
            return Chapter::where('chapter_name', '=', $name)->get();
        }
    }

    protected function normalizePinnaceName($name, $pnum, $pid)
    {
        // Normalize Pinnace names
        if (( $pos = strpos($name, $pnum) ) > 0) {
            if (substr($name, 0, 3) == 'Pin') {
                $name = substr($name, 0, $pos) . ' ' . $pid;
            } else {
                $name = 'Pinnace ' . substr($name, 0, $pos) . ' ' . $pid;
            }
        }
        return $name;
    }
}
