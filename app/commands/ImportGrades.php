<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportGrades extends Command
{
    use \Medusa\Audit\MedusaAudit;

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
        // Get the current setting

        $timeLimit = ini_get('max_execution_time');

        // Allow for enough time

        set_time_limit(0);

        $examRecords = []; // start with a clean array

        foreach ([
                     'RMN Exam Grading Sheet'     => 'importMainLineExams',
                     'RMN Specialist Exam Grades' => 'importRmnSpecialityExams',
                     'IMNA Exam Grades'           => 'importGsnMainLineExams',
                     'RMMC Exam Grading Sheet'    => 'importRmmcMainLineExams',
                     'RMA Exam Grading Sheet'     => 'importRmaMainLineExams'
                 ] as $sheet => $importRoutine) {

            $examRecords = $this->processExams($examRecords, $sheet, $importRoutine);
        }

        $this->updateExamGrades($examRecords);

        // Set it back to what it was

        if (empty( $timeLimit ) === true) {
            set_time_limit(30);
        } else {
            set_time_limit($timeLimit);
        }
    }

    protected function updateExamGrades(array $records)
    {

        foreach ($records as $memberId => $record) {

            $res = Exam::where('member_id', '=', $memberId)->First();

            if (is_null($res) === false) {

                // Exam record exists, replace it
                $res->exams = $record;

                $this->writeAuditTrail(
                    'import',
                    'update',
                    'exam',
                    $res->id,
                    json_encode($res),
                    'import.grades'
                );

                try {
                    $res->save();
                } catch ( Exception $e ) {
                    $details =
                        [
                            'severity' => 'warning',
                            'msg'      => 'Unable to update ' . $res->first_name . ' ' . $res->last_name . '(' . $memberId . ')'
                        ];

                    $this->logMsg($details);
                }
            } else {

                $examRecord = ['member_id' => $memberId, 'exams' => $record];
                $this->writeAuditTrail(
                    'import',
                    'create',
                    'exam',
                    null,
                    json_encode($examRecord),
                    'import.grades'
                );

                try {
                    Exam::create($examRecord);
                } catch ( Exception $e ) {
                    $details =
                        [
                            'severity' => 'warning',
                            'msg'      => 'Unable to add ' . $res->first_name . ' ' . $res->last_name . '(' . $memberId . ')'
                        ];

                    $this->logMsg($details);
                }
            }
        }

        return true;
    }

    protected function processExams($examRecords, $sheet, $importRoutine)
    {
        $details =
            [
                'severity' => 'info',
                'msg'      => $sheet
            ];

        $this->logMsg($details);

        $mainlineExams = Excel::selectSheets($sheet)->load(
            app_path() . '/database/TRMN Exam grading spreadsheet.xlsx'
        )
                              ->formatDates(true, 'Y-m-d')
                              ->toArray();

        foreach ($mainlineExams as $userRecord) {

            if (empty( $userRecord['last_name'] ) === true) {
                continue;
            }

            $validatedUserRecord = $this->validateMemberId($userRecord);

            //if validatedUserRecord is null, continue to the next record
            if (is_null($validatedUserRecord)) {
                continue;
            }

            //if validatedUserRecord is not null, process this one

            if (empty( $examRecords[$validatedUserRecord['member_number']] ) === true) {
                // We have no exam record for this member
                $examRecords[$validatedUserRecord['member_number']] = $this->$importRoutine($validatedUserRecord);
            } else {
                // We have an exam record for this member
                $examRecords[$validatedUserRecord['member_number']] =
                    array_merge(
                        $examRecords[$validatedUserRecord['member_number']],
                        $this->$importRoutine($validatedUserRecord)
                    );
            }
        }

        return $examRecords;
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

    protected function parseScoreAndDate($value, $debug = false)
    {
        $value = strtoupper($value);

        if (preg_match('/^(\w+)$/', $value) === 1) {
            return ['score' => $value, 'date' => 'UNKNOWN'];
        }

        if (substr_count($value, '/') === 1) {
            // One and only 1 slash, let's make it parseable
            $value = str_replace('/', '-', $value);
        }

        // Grrrr!!!! Some instructor keeps using $ instead of %

        $value = str_replace('$', '%', $value);

        // SIGH!  Virtually every other instructor is doing DDMONYY but noooo, you have to be special and do DD MON YY
        if (substr_count($value, ' ') >= 3) {
            $scoreAndDate = preg_split('/[-]+/', $value, 2);
        } else {
            $scoreAndDate = preg_split('/[ -]+/', $value, 2);
        }

        if (count($scoreAndDate) == 1) {
            // No spaces or dashes to split on, so we have yet another format!
            $scoreAndDate = preg_split('/[%]+/', $value, 2);
        }
        if ($debug) {
            $this->info(print_r($scoreAndDate, true));
        }
        if (isset( $scoreAndDate[1] ) === true) {
            $scoreAndDate[0] = trim($scoreAndDate[0]);
            $scoreAndDate[1] = trim($scoreAndDate[1]);

            if (substr($scoreAndDate[1], -1) == '%' || substr($scoreAndDate[1], 0, 4) == 'PASS') {
                // This is a score
                $score = $scoreAndDate[1];
                $date = strtoupper(date('d M Y', strtotime($scoreAndDate[0])));
            } else {
                // This is a date
                if ($debug) {
                    $this->info('2nd Element is a date');
                }
                if (preg_match('/^(\d+)$/', $scoreAndDate[1]) === 1) {
                    if ($debug) {
                        $this->info('Hit all digits');
                    }
                    // The date is all numbers, it's probably not in a valid format.  Assume MMDDYY or MMDDYYYY
                    $date =
                        strtoupper(
                            date(
                                'd M Y',
                                strtotime(
                                    substr($scoreAndDate[1], 0, 2) . '/' .
                                    substr($scoreAndDate[1], 2, 2) . '/' .
                                    substr($scoreAndDate[1], 4)
                                )
                            )
                        );
                } else {
                    $date = strtoupper(date('d M Y', strtotime(trim($scoreAndDate[1]))));
                    if ($debug) {
                        $this->info(var_dump($scoreAndDate[1]));
                        $this->info($date);
                    }
                }

                $score = $scoreAndDate[0];
                if ($debug) {
                    $this->info($score);
                }
            }
        } else {
            $date = "UNKNOWN";
            $score = $scoreAndDate[0];
        }

        if (isset( $scoreAndDate[1] ) === true) {
            // Make sure we have a % at the end of the score
            if (substr($score, -1) != '%' && $score != 'PASS' && $score != 'BETA') {
                $score .= '%';
            }
            return ['score' => $score, 'date' => $date];
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

    protected function importRmaMainLineExams(array $record)
    {
        $mainLineExams = [
            '0001_exam_e_1'                => 'KR1MA-RMA-0001',
            '0002_exam_e_2'                => 'KR1MA-RMA-0002',
            '0003_exam_e_3'                => 'KR1MA-RMA-0003',
            '0004_exam_e_4'                => 'KR1MA-RMA-0004',
            '0005_exam_e_6'                => 'KR1MA-RMA-0005',
            '0006_exam_e_7'                => 'KR1MA-RMA-0006',
            '0007_exam_e_8'                => 'KR1MA-RMA-0007',
            '0008_exam_e_9'                => 'KR1MA-RMA-0008',
            'wo_0011_exam_wo1'             => 'KR1MA-RMA-0011',
            'cwo_0012_exam_wo2'            => 'KR1MA-RMA-0012',
            'scwo_0013_exam'               => 'KR1MA-RMA-0013',
            'mcwo_0014_exam'               => 'KR1MA-RMA-0014',
            '0101_o_1_exam_2nd_lt'         => 'KR1MA-RMA-0101',
            '0102_o_2_exam_1st_lt'         => 'KR1MA-RMA-0102',
            '0103_o_3_exam_cpt'            => 'KR1MA-RMA-0103',
            'rma_2001_military_admin'      => 'KR1MA-RMA-2001',
            '0104_o_4_exam_maj'            => 'KR1MA-RMA-0104',
            'rma_2002_large_unit_tactics'  => 'KR1MA-RMA-2002',
            '0105_o_5_ltcol'               => 'KR1MA-RMA-0105',
            '0106_o_6_exam_col'            => 'KR1MA-RMA-0106',
            'rma_2003_advanced_leadership' => 'KR1MA-RMA-2003',
            '1001_f_1_exam_briggen'        => 'KR1MA-RMA-1001',
            '1002_f_2_exam_mg'             => 'KR1MA-RMA-1002',
            '1003_f_3_exam_lg'             => 'KR1MA-RMA-1003',
            '1004_f_4_exam_gen'            => 'KR1MA-RMA-1004',
            '1005_f_5_exam_fm'             => 'KR1MA-RMA-1005',
        ];

        $exam = [];

        foreach ($mainLineExams as $field => $examId) {
            if (empty( $record[$field] ) === false) {
                $exam[$examId] = $this->parseScoreAndDate($record[$field]);
            }
        }

        return $exam;
    }

    protected function importGsnMainLineExams(array $record)
    {
        $mainLineExams = [
            'imna_gsn_0001_e_2e_3' => 'IMNA-GSN-0001',
            'imna_gsn_0002_e_4e_5' => 'IMNA-GSN-0002',
            'imna_gsn_0003_e_6e_7' => 'IMNA-GSN-0003',
            'imna_gsn_0004_e_8'    => 'IMNA-GSN-0004',
            'imna_gsn_0005_e_9'    => 'IMNA-GSN-0005',
            'imna_gsn_0006_e_10'   => 'IMNA-GSN-0006',
            'wo1wo2_imna_gsn_0011' => 'IMNA-GSN-0011',
            'wo3wo4_imna_gsn_0012' => 'IMNA-GSN-0012',
            'wo5_imna_gsn_0013'    => 'IMNA-GSN-0013',
            'mid_imna_gsn_0100'    => 'IMNA-GSN-0100',
            'ens_imna_gsn_0101'    => 'IMNA-GSN-0101',
            'lt_jg_imna_gsn_0102'  => 'IMNA-GSN-0102',
            'lt_sg_imna_gsn_0103'  => 'IMNA-GSN-0103',
            'lcdr_imna_gsn_0104'   => 'IMNA-GSN-0104',
            'cdr_imna_gsn_0105'    => 'IMNA-GSN-0105',
            'cpt_imna_gsn_0106'    => 'IMNA-GSN-0106',
            'com_imna_gsn_1001'    => 'IMNA-GSN-1001',
            'radm_imna_gsn_1002'   => 'IMNA-GSN-1002',
            'vadm_imna_gsn_1003'   => 'IMNA-GSN-1003',
            'adm_imna_gsn_1004'    => 'IMNA-GSN-1004',
        ];

        $exam = [];

        foreach ($mainLineExams as $field => $examId) {
            if (empty( $record[$field] ) === false) {
                $exam[$examId] = $this->parseScoreAndDate($record[$field]);
            }
        }

        return $exam;
    }

    protected function importRmmcMainLineExams(array $record)
    {
        $mainLineExams = [
            'e_1_exam'   => 'SIA-RMMC-0001',
            'e_4_exam'   => 'SIA-RMMC-0002',
            'e_6_exam'   => 'SIA-RMMC-0003',
            'e_8_exam'   => 'SIA-RMMC-0004',
            'e_9_exam'   => 'SIA-RMMC-0005',
            'e_10_exam'  => 'SIA-RMMC-0006',
            'wo_1_exam'  => 'SIA-RMMC-0011',
            'cwo_exam'   => 'SIA-RMMC-0012',
            'mcwo_exam'  => 'SIA-RMMC-0013',
            'o_1_exam'   => 'SIA-RMMC-0101',
            'o_2_exam'   => 'SIA-RMMC-0102',
            'o_3_exam'   => 'SIA-RMMC-0103',
            //            'sia_rmn_0113'  => 'SIA-RMN-0113',
            'o_4_exam'   => 'SIA-RMMC-0104',
            'o_5_exam'   => 'SIA-RMMC-0105',
            //            'sia_rmn-0115' => 'SIA-RMN-0115',
            'o_6_a_exam' => 'SIA-RMMC-0106',
            'o_6_b_exam' => 'SIA-RMMC-1001',
            'f_2_exam'   => 'SIA-RMMC-1002',
            'f_3_exam'   => 'SIA-RMMC-1003',
            'f_4_exam'   => 'SIA-RMMC-1004',
            's_a_exam'   => 'SIA-RMMC-S-A',
            's_b_exam'   => 'SIA-RMMC-S-B',
            's_c_exam'   => 'SIA-RMMC-S-C',
            'g_a_exam'   => 'SIA-RMMC-G-A',
            'g_b_exam'   => 'SIA-RMMC-G-B',
            'g_c_exam'   => 'SIA-RMMC-G-C',
            'j_a_exam'   => 'SIA-RMMC-J-A',
            'j_b_exam'   => 'SIA-RMMC-J-B',
            'j_c_exam'   => 'SIA-RMMC-J-C',
        ];

        $exam = [];

        foreach ($mainLineExams as $field => $examId) {
            if (empty( $record[$field] ) === false) {
                $debug = false;
                if ($record['member_number'] == 'RMN-0011-08' && $examId == 'SIA-RMMC-0103') {
                    $this->info($record[$field]);
                    $debug = true;
                }
                $exam[$examId] = $this->parseScoreAndDate($record[$field], $debug);
                if ($record['member_number'] == 'RMN-0011-08' && $examId == 'SIA-RMMC-0103') {
                    $this->info(print_r($exam[$examId], true));
                }
            }
        }

        return $exam;
    }

    protected function importRmnSpecialityExams(array $record)
    {
        // Build the array of field name to exam number translation
        $rmnSpecialityExams = [];

        for ($exam = 1; $exam < 33; $exam++) {
            $examNumber = str_pad($exam, 2, '0', STR_PAD_LEFT);

            foreach (['A', 'C', 'W', 'D'] as $examLevel) {
                $rmnSpecialityExams['srn_' . $examNumber . strtolower($examLevel)] =
                    'SIA-SRN-' . $examNumber . $examLevel;
            }
        }

        $exam = [];

        foreach ($rmnSpecialityExams as $field => $examId) {
            if (empty( $record[$field] ) === false) {
                if (strtoupper($record[$field]) !== 'SKIPPED') {
                    $exam[$examId] = $this->parseScoreAndDate($record[$field]);
                }
            }
        }

        return $exam;
    }

    protected function validateMemberId(array $memberExamRecord)
    {
        $firstName = explode(' ', preg_replace('/\W+/', ' ', $memberExamRecord['first_name']));
        $lastName = explode(' ', preg_replace('/\W+/', ' ', $memberExamRecord['last_name']));

        if (preg_match('/^RMN\-\d{4}.*/', $memberExamRecord['member_number']) === 1) {

            $user =
                User::where('member_id', '=', $memberExamRecord['member_number'])
                    ->first();

            if (is_null($user) === false) {
                if (stripos(trim($user['first_name']), trim($firstName[0])) === 0 && stripos(
                        trim($user['last_name']),
                        trim($lastName[0])
                    ) === 0
                ) {
                    return $memberExamRecord;
                }
            }
        }

        $users =
            User::where('first_name', '=', trim($firstName[0]))
                ->where('last_name', '=', trim($memberExamRecord['last_name']))
                ->get();

        if (count($users) != 1) {
            // logMsg with error details

            $details =
                [
                    'severity' => 'warning',
                    'msg'      => 'Invalid MemberID(' . $memberExamRecord['member_number'] . ') for ' . $memberExamRecord['first_name'] . ' ' . $memberExamRecord['last_name'] . ' and I was unable to find a definitive match in the User database.'
                ];

            $this->logMsg($details);

            return null;
        } else {
            $memberExamRecord['member_number'] = $users[0]['member_id'];
            return $memberExamRecord;
        }
    }

    protected function logMsg(array $msgDetails)
    {
        // do stuff to report the error
        switch ($msgDetails['severity']) {
            case 'info':
                $this->info($msgDetails['msg']);
                break;
            default:
                $this->error($msgDetails['msg']);
        }

        $msgDetails['source'] = 'import_grades';
        Message::create($msgDetails);
    }
}
