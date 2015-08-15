<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportGrades extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import:grades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import grades from SIA Spreadsheet';

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
        $mainLine =
            Excel::selectSheets('RMN Exam Grading Sheet')->load(
                app_path() . '/database/TRMN Exam grading spreadsheet.xlsx'
            )
                 ->formatDates(true, 'Y-m-d')
                 ->toArray();

        foreach ($mainLine as $userRecord) {

            if (empty($userRecord['last_name'])===true) {
                continue;
            }

            $examRecord = []; // start with a clean array

            $examRecord['member_id'] = $userRecord['member_number'];

            if ($this->validateMemberId($examRecord['member_id']) === false) {
                // Not a valid member id, attempt to find it by first and last name
                $users =
                    User::where('last_name', '=', $userRecord['last_name'])
                        ->where('first_name', '=', $userRecord['first_name'])
                        ->get();

                if (isset( $users[0] ) === true) {
                    $examRecord['member_id'] = $users[0]['member_id'];
                } else {
                    $this->error('Invalid MemberID for ' . $userRecord['first_name'] . ' ' . $userRecord['last_name'] . ' and I was unable to find a match in the User database.');
                    continue;
                }
            }

            $examRecord['exams'] = $this->importMainLineExams($userRecord);

            $this->updateExamGrades($examRecord);
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

    protected function parseScoreAndDate($value)
    {
        $value = strtoupper($value);

        $_date = strtoupper(date('d M Y', strtotime($value)));

        if (strpos($value, '%') === false && $_date !== '01 JAN 1970') {
            // Valid date and no score
            return ['score' => '100%', 'date' => $_date];
        }

        $scoreAndDate = preg_split('/[ -]+/', $value, 2);

        if (isset( $scoreAndDate[1] ) === true) {
            $date = strtoupper(date('d M Y', strtotime($scoreAndDate[1])));
        } else {
            $date = "UNKNOWN";
        }

        if (isset( $scoreAndDate[0] ) === true) {
            return ['score' => $scoreAndDate[0], 'date' => $date];
        } else {
            return ['score' => '', 'date' => ''];
        }
    }

    protected function importMainLineExams(array $record)
    {
        $mainLineExams =
            [
                'sia_rmn_0001_e_2e_3' => 'SIA-RMN-0001',
                'sia_rmn_0002_e_4e_5' => 'SIA-RMN-0002',
                'sia_rmn_0003_e_6e_7' => 'SIA-RMN-0003',
                'sia_rmn_0004_e_8'    => 'SIA-RMN-0004',
                'sia_rmn_0005_e_9'    => 'SIA-RMN-0005',
                'sia_rmn_0006_e_10'   => 'SIA-RMN-0006',
                'sia_rmn_0011_w_1w_2' => 'SIA-RMN-0011',
                'sia_rmn_0012_w_3w_4' => 'SIA-RMN-0012',
                'sia_rmn_0013_w_5'    => 'SIA-RMN-0013',
                'ensign_0101'         => 'SIA-RMN-0101',
                'lt_jg_0102'          => 'SIA-RMN-0102',
                'lt_sg_0103'          => 'SIA-RMN-0103',
                'intro_to_mgmt_0113'  => 'SIA-RMN-0113',
                'lt_cmd_0104'         => 'SIA-RMN-0104',
                'cdr_0105'            => 'SIA-RMN-0105',
                'intro_to_ldr_0115'   => 'SIA-RMN-0115',
                'capt_jg_0106'        => 'SIA-RMN-0106',
                'sia_rmn_1001'        => 'SIA-RMN-1001',
                'sia_rmn_1002'        => 'SIA-RMN-1002',
                'sia_rmn_1003'        => 'SIA-RMN-1003',
                'sia_rmn_1004'        => 'SIA-RMN-1004',
                'sia_rmn_1005'        => 'SIA-RMN-1005',
                'sia_rmn_1005_sits'   => 'SIA-RMN-1005-SITS'
            ];

        $exam = [];

        foreach ($mainLineExams as $field => $examId) {
            if (empty( $record[$field] ) === false) {
                $exam[$examId] = $this->parseScoreAndDate($record[$field]);
            }
        }

        return $exam;
    }

    protected function updateExamGrades(array $record)
    {
        $res = Exam::where('member_id', '=', $record['member_id'])->get();

        if (isset( $res[0] ) === true) {

            // Exam record exists, update it
            unset( $record['member_id'] );

            foreach ($record as $key => $value) {
                $res[0][$key] = $value;
            }

            $res[0]->save();
        } else {

            $newExamRecord = Exam::create($record);

            $examRecord = Exam::find($newExamRecord['_id']);

            foreach ($record as $key => $value) {
                $examRecord[$key] = $value;
            }

            $examRecord->save();
        }

        return true;
    }

    protected function validateMemberId($memberId)
    {
        if (preg_match('/^RMN\-\d{4}.*/', $memberId) === 1) {
            return true; // We have at least RMN-XXXX
        } else {
            return false;
        }
    }
}
