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
        $examRecord = []; // start with a clean array
        
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

            $validatedUserRecord = validateMemberId($userRecord);
            
            //if validatedUserRecord is null, continue to the next record
            if (is_null ($validatedUserRecord)){
                continue;
            }
            
            //if validatedUserRecord is not null, process this one
            $examRecord['member_id'] = $validatedUserRecord['member_number'];

            $examRecord['exams'] = array_merge($examRecord['exams'],$this->importMainLineExams($userRecord));

        }

        $gsnMainLine =
            Excel::selectSheets('IMNA Exam Grades')->load(
                app_path() . '/database/TRMN Exam grading spreadsheet.xlsx'
            )
                 ->formatDates(true, 'Y-m-d')
                 ->toArray();

        foreach ($gsnMainLine as $userRecord) {

            if (empty($userRecord['last_name'])===true) {
                continue;
            }

            $validatedUserRecord = validateMemberId($userRecord);
            
            //if validatedUserRecord is null, continue to the next record
            if (is_null ($validatedUserRecord)){
                continue;
            }
            
            //if validatedUserRecord is not null, process this one
            $examRecord['member_id'] = $validatedUserRecord['member_number'];

            $examRecord['exams'] = array_merge($examRecord['exams'],$this->importGsnMainLineExams($userRecord));
        
        }

        // RMMC Exam Grading Sheet
        $rmmcMainLine =
            Excel::selectSheets('RMMC Exam Grading Sheet')->load(
                app_path() . '/database/TRMN Exam grading spreadsheet.xlsx'
            )
                 ->formatDates(true, 'Y-m-d')
                 ->toArray();

        foreach ($rmmcMainLine as $userRecord) {

                        if (empty($userRecord['last_name'])===true) {
                continue;
            }

            $validatedUserRecord = validateMemberId($userRecord);
            
            //if validatedUserRecord is null, continue to the next record
            if (is_null ($validatedUserRecord)){
                continue;
            }
            
            //if validatedUserRecord is not null, process this one
            $examRecord['member_id'] = $validatedUserRecord['member_number'];

            $examRecord['exams'] = array_merge($examRecord['exams'],$this->importRmmcMainLineExams($userRecord));
        }
        
        $rmaMainLine = Excel::selectSheets('RMA Exam Grading Sheet')->load(
            app_path() . '/database/TRMN Exam grading spreadsheet.xlsx'
        )
            ->formatDates(true, 'Y-m-d')
            ->toArray();

        foreach ($rmaMainLine as $userRecord) {

            if (empty($userRecord['last_name'])===true) {
                continue;
            }

            $validatedUserRecord = validateMemberId($userRecord);
            
            //if validatedUserRecord is null, continue to the next record
            if (is_null ($validatedUserRecord)){
                continue;
            }
            
            //if validatedUserRecord is not null, process this one
            $examRecord['member_id'] = $validatedUserRecord['member_number'];

            $examRecord['exams'] = array_merge($examRecord['exams'],$this->importRmaMainLineExams($userRecord));
        }
        
        try {
            $this->updateExamGrades($examRecord);
        } catch (Exception $e) {
            $this->error('Error updating ' . $userRecord['member_number'] . ' ' . $userRecord['first_name'] . ' ' . $userRecord['last_name']);
            die();
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

        if (strpos($value, '%') === false &&
            strpos($value, 'BETA') === false &&
            strpos($value, 'CREA') === false &&
            strpos($value, 'PASS') === false &&
            $_date !== '01 JAN 1970') {
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

    protected function importRmaMainLineExams(array $record)
    {
        $mainLineExams = [
            '0001_exam_e_1' => 'KR1MA-RMA-0001',
            '0002_exam_e_2' => 'KR1MA-RMA-0002',
            '0003_exam_e_3' => 'KR1MA-RMA-0003',
            '0004_exam_e_4' => 'KR1MA-RMA-0004',
            '0005_exam_e_6' => 'KR1MA-RMA-0005',
            '0006_exam_e_7' => 'KR1MA-RMA-0006',
            '0007_exam_e_8' => 'KR1MA-RMA-0007',
            '0008_exam_e_9' => 'KR1MA-RMA-0008',
            'wo_0011_exam_wo1' => 'KR1MA-RMA-0011',
            'cwo_0012_exam_wo2' => 'KR1MA-RMA-0012',
            'scwo_0013_exam' => 'KR1MA-RMA-0013',
            'mcwo_0014_exam' => 'KR1MA-RMA-0014',
            '0101_o_1_exam_2nd_lt' => 'KR1MA-RMA-0101',
            '0102_o_2_exam_1st_lt' => 'KR1MA-RMA-0102',
            '0103_o_3_exam_cpt' => 'KR1MA-RMA-0103',
            'rma_2001_military_admin' => 'KR1MA-RMA-2001',
            '0104_o_4_exam_maj' => 'KR1MA-RMA-0104',
            'rma_2002_large_unit_tactics' => 'KR1MA-RMA-2002',
            '0105_o_5_ltcol' => 'KR1MA-RMA-0105',
            '0106_o_6_exam_col' => 'KR1MA-RMA-0106',
            'rma_2003_advanced_leadership' => 'KR1MA-RMA-2003',
            '1001_f_1_exam_briggen' => 'KR1MA-RMA-1001',
            '1002_f_2_exam_mg' => 'KR1MA-RMA-1002',
            '1003_f_3_exam_lg' => 'KR1MA-RMA-1003',
            '1004_f_4_exam_gen' => 'KR1MA-RMA-1004',
            '1005_f_5_exam_fm' => 'KR1MA-RMA-1005',
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
            'imna_gsn_0004_e_8' => 'IMNA-GSN-0004',
            'imna_gsn_0005_e_9' => 'IMNA-GSN-0005',
            'imna_gsn_0006_e_10' => 'IMNA-GSN-0006',
            'wo1wo2_imna_gsn_0011' => 'IMNA-GSN-0011',
            'wo3wo4_imna_gsn_0012' => 'IMNA-GSN-0012',
            'wo5_imna_gsn_0013' => 'IMNA-GSN-0013',
            'mid_imna_gsn_0100' => 'IMNA-GSN-0100',
            'ens_imna_gsn_0101' => 'IMNA-GSN-0101',
            'lt_jg_imna_gsn_0102' => 'IMNA-GSN-0102',
            'lt_sg_imna_gsn_0103' => 'IMNA-GSN-0103',
            'lcdr_imna_gsn_0104' => 'IMNA-GSN-0104',
            'cdr_imna_gsn_0105' => 'IMNA-GSN-0105',
            'cpt_imna_gsn_0106' => 'IMNA-GSN-0106',
            'com_imna_gsn_1001' => 'IMNA-GSN-1001',
            'radm_imna_gsn_1002' => 'IMNA-GSN-1002',
            'vadm_imna_gsn_1003' => 'IMNA-GSN-1003',
            'adm_imna_gsn_1004' => 'IMNA-GSN-1004',
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
            'e_1_exam' => 'SIA-RMMC-0001',
            'e_4_exam' => 'SIA-RMMC-0002',
            'e_6_exam' => 'SIA-RMMC-0003',
            'e_8_exam' => 'SIA-RMMC-0004',
            'e_9_exam' => 'SIA-RMMC-0005',
            'e_10_exam' => 'SIA-RMMC-0006',
            'wo_1_exam' => 'SIA-RMMC-0011',
            'cwo_exam' => 'SIA-RMMC-0012',
            'mcwo_exam' => 'SIA-RMMC-0013',
            'o_1_exam' => 'SIA-RMMC-0101',
            'o_2_exam' => 'SIA-RMMC-0102',
            'o_3_exam' => 'SIA-RMMC-0103',
//            'sia_rmn_0113'  => 'SIA-RMN-0113',
            'o_4_exam' => 'SIA-RMMC-0104',
            'o_5_exam' => 'SIA-RMMC-0105',
//            'sia_rmn-0115' => 'SIA-RMN-0115',
            'o_6_a_exam' => 'SIA-RMMC-0106',
            'o_6_b_exam' => 'SIA-RMMC-1001',
            'f_2_exam' => 'SIA-RMMC-1002',
            'f_3_exam' => 'SIA-RMMC-1003',
            'f_4_exam' => 'SIA-RMMC-1004',
            's_a_exam' => 'SIA-RMMC-S-A',
            's_b_exam' => 'SIA-RMMC-S-B',
            's_c_exam' => 'SIA-RMMC-S-C',
            'g_a_exam' => 'SIA-RMMC-G-A',
            'g_b_exam' => 'SIA-RMMC-G-B',
            'g_c_exam' => 'SIA-RMMC-G-C',
            'j_a_exam' => 'SIA-RMMC-J-A',
            'j_b_exam' => 'SIA-RMMC-J-B',
            'j_c_exam' => 'SIA-RMMC-J-C',
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

        $res = Exam::where('member_id', '=', $record['member_id'])->First();

        if (is_null($res) === false) {

            // Exam record exists, update it
            $res->exams = array_merge($res->exams, $record['exams']);

            $this->writeAuditTrail(
                'import',
                'update',
                'exam',
                (string)$res->_id,
                json_encode($res),
                'import.grades'
            );

            $res->save();
        } else {

            $this->writeAuditTrail(
                'import',
                'create',
                'exam',
                null,
                json_encode($record),
                'import.grades'
            );

            $newExamRecord = Exam::create($record);

            $examRecord = Exam::find($newExamRecord['_id']);

            $examRecord->exams = $record['exams'];
            $examRecord->member_id = $record['member_id'];

            $examRecord->save();
        }

        return true;
    }

    protected function validateMemberId(array $memberExamRecord)
    {
        
        if (preg_match('/^RMN\-\d{4}.*/', $memberExamRecord['member_id']) === 1) {
            
            
            $user =
                User::where('member_id', '=', $memberExamRecord['member_id'])
                    ->first();

            if ( is_null( $user ) === false) {
                if ($memberExamRecord['first_name'] == $user['first_name'] && $memberExamRecord['last_name'] == $user['last_name']) {
                    return $memberExamRecord;
                } 
            }
        }
        
        $users =
            User::where('last_name', '=', $memberExamRecordRecord['last_name'])
                ->where('first_name', '=', $memberExamRecordRecord['first_name'])
                ->get();
        
        if ( count($users) != 1 ) {
            // logError with error details
            
            $details = ['severity' => 'warning','msg' => 'Invalid MemberID for ' . $userRecord['first_name'] . ' ' . $userRecord['last_name'] . ' and I was unable to find a definitive match in the User database.'];
            
            logError ( $details );
            
            return null;
        } else {
            $memberExamRecord['member_id'] = $users[0]['member_id'];
            return $memberExamRecord;
        }
    }
    
    protected function logError (array $errorDetails) {
        // do stuff to report the error
        
        
        
        $this->error($errorDetails['msg']);
    }
}
