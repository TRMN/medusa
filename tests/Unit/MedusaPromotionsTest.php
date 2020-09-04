<?php
    
    namespace Test\Unit;
    
    use Tests\TestCase;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Log;
    use App\MedusaConfig;
    use App\User;
    use App\Utility\MedusaUtility;
    use App\Promotions\MedusaPromotions;
    
    class MedusaPromotionsTest extends TestCase
    {
        use MedusaPromotions;
        
        private $testUserID;
        private $testUser;
        private $examUserID = 'RMN-5405-18';//'5b786115a016bd1d8a34cb93'; // timber

        private function addTestResult($memberId, $exam_id, $date, $score, $entered_by, $date_entered): void
        {
            Log::debug('Unit/MedusaPromotionsTest addTestResult ('.$memberId.','.$exam_id.','.$date.','.$score.','.$entered_by.','.$date_entered.')');
            $record = ['score' => $score, 'date' => $date, 'date_entered' => $date_entered];
            Log::debug('Unit/MedusaPromotionsTest addTestResult $record '.implode(",", $record));
            $examRecord = ['member_id' => $memberId, 'exams' => $record];
            try {
                \App\Exam::create($examRecord);
            } catch (\Exception $e) {
                $details = ['severity' => 'warning',
                'msg' => 'Unable to add '.$res->first_name.' '.$res->last_name.'('.$memberId.')',];
                Log::debug('Unit/MedusaPromotionsTest addTestResult Exam::create failed '.$details);
            }
        }
        
        public function setUp(): void
        {
            parent::setUp();
            $this->testUserID = 'RMN'.\App\User::getNextAvailableMemberId();
            Log::debug('Unit/MedusaPromotionsTest setUp '.$this->testUserID.' -------------------');

            $createdDate =  date('Y-m-d', strtotime(date('Y-m-d'). ' - 62 days'));
            
            $user['member_id'] = $this->testUserID;
            $user['email_address'] = strval(microtime(true)).'@trmn.org';
            
            $user['branch'] = 'RMN';
            $user['rank']['grade'] = 'E-1'; // C-1
            $user['rank']['date_of_rank'] = $createdDate;
            $user['assignment'][] =
            ['chapter_id'   => '', //$this->getChapterByName('HMS Medusa')[0]['_id'], // protected function
            'billet'       => '', //$user['primary_billet'],
            'primary'      => true,
            'chapter_name' => 'HMS Medusa',
            ];
            $user['awards'] = [];
            $user['path'] = 'line';

            $user['permissions'] = [
            'LOGOUT',
            'CHANGE_PWD',
            'EDIT_SELF',
            'ROSTER',
            'TRANSFER',
            ];
            
            $user['registration_status'] = 'Active';
            $user['registration_date'] = $createdDate;
            $user['application_date'] = $createdDate;
            $user['country'] = 'USA';
            $user['state_province'] = 'CA';
            $user['postal_code'] = '94102';
            
            // from UserController.php:751
            $this->testUser = \App\User::create($user);
            $u = \App\User::find($this->testUser['_id']);
            foreach ($user as $key => $value) {
                $u[$key] = $value;
            }
            try {
                $u->save(); // UserController.php:504, 761
            } catch (\Exception $e) {
                Log::debug('Unit/MedusaPromotionsTest setUp $u->save() failed ');
            }
            $this->testUser = $u; // needed to get ID into the record
            Log::debug('Unit/MedusaPromotionsTest setUp testUser '.$this->testUser);
            Log::debug('Unit/MedusaPromotionsTest setUp DONE');
        }
        
        // pp.nextGrade is a required configuration for promotions to work. 
        public function testPromotionConfigs()
        {                        
            $config = json_decode('{ "E-1": {"next": [ "E-2" ]}}', true);
            $this->assertNotEmpty(MedusaConfig::set('pp.nextGrade', $config)); 
            
            $ppNextGrade = MedusaConfig::get('pp.nextGrade');
            $this->assertNotEmpty($ppNextGrade);
            
            $nextGrade = $this->testUser->getNextGrade("E-1");
            $this->assertNotEmpty($nextGrade);
            
        }
        
        // trivial test - needs real data setup
        public function testIsPromotable1()
        {
            Log::debug('Unit/MedusaPromotionsTest testIsPromotable1 testuserid');
            $result = $this->testUser->isPromotable();
            $this->assertTrue($result != null); // fails
            $this->assertFalse($result);
            Log::debug('Unit/MedusaPromotionsTest testIsPromotable1 PASS');
        }
        
        // trivial test - needs real data setup
        public function testIsPromotable2()
        {
            Log::debug('Unit/MedusaPromotionsTest testIsPromotable2 testuserid'.$this->testUser->member_id);
            
            // this needs to be set but apparently isn't. 
            $config = json_decode('{ "E-1": {"next": [ "E-2" ]}}', true);
            $this->assertNotEmpty(MedusaConfig::set('pp.nextGrade', $config));
            
            // Promotable depends on points, exams, next, early, tig
            // points: chapter meetings 3
            $this->testUser->setPromotionPointValue('cpm','3');
            $this->testUser->setPromotionPointValue('cpe','1');
            Log::debug('Unit/MedusaPromotionsTest testIsPromotable2 testuser points cpm '.$this->testUser->points['cpm']);
            Log::debug('Unit/MedusaPromotionsTest testIsPromotable2 testuser points cpe '.$this->testUser->points['cpe']);

            // exams: add the first exam
            $this->addTestResult($this->testUserID,
                          'SIA-RMN-0001', // User.php:1148
                          date('Y-m-d'), //date('Y-m-d', strtotime(date('Y-m-d').' - 2 days')),
                          '100', // >70  AwardQualification.php:324
                          $this->examUserID,
                          date('Y-m-d'));
            
            // next, no; early, no
            
            // tig: set up in user by having its created-date two months ago
            Log::debug('Unit/MedusaPromotionsTest testIsPromotable2 testuser getTimeInGrade '.
                       $this->testUser->getTimeInGrade('months')); // 2
            
            $result = $this->testUser->isPromotable();
            $this->assertTrue($result != null); // fails
            $this->assertTrue($result);
            // calls MedusaPromotions/getPromotableInfo which can return null.
            Log::debug('Unit/MedusaPromotionsTest testIsPromotable2 testuserid PASS');
        }
        
        // trivial test of getPromotableInfo
        public function testGetPromotableInfo()
        {
            Log::debug('Unit/MedusaPromotionsTest testgetPromotableInfo');
            $flags = $this->testUser->getPromotableInfo(); // MedusaPromotions
            
            $this->assertNotNull($flags);
            
            $this->assertTrue(isset($flags['tig']));
            $this->assertTrue(isset($flags['points']));
            $this->assertTrue(isset($flags['exams']));
            $this->assertTrue(isset($flags['early']));
            
            $tig = ($flags['tig'])? 'true' : 'false';
            $points = ($flags['points'])? 'true' : 'false';
            $exams = ($flags['exams'])? 'true' : 'false';
            $early = ($flags['early'])? 'true' : 'false';

            Log::debug('testgetPromotableInfo tig ' . $tig);
            Log::debug('testgetPromotableInfo points ' . $points);
            Log::debug('testgetPromotableInfo exams ' . $exams);
            Log::debug('testgetPromotableInfo early ' . $early);
            
            $this->assertTrue($flags['tig']); // Branch=RMN
            $this->assertTrue($flags['points']);
            $this->assertTrue($flags['exams']);
            $this->assertTrue($flags['early']);
            
            // These flags are set by logic in getPromotableInfo
            // based on the states of other data
            // 217 tig - time in grade and requirements
            // 227 early - time in grade and requirements
            // 235 points - this user's promotion points and requirements for path and points
            // 244 exams - function hasRequiredExams for path
            // 255 next - lookup for next grade
            
            // test strategy: set up a test user with some set of these parameters so the user is not eligible for promotion
            // one by one fix the requirements and check until the user is expected to be promotable.
            // inductively prove the simple sequential table-driven ones
            // special cases for any tricky code
            
            Log::debug('Unit/MedusaPromotionsTest testgetPromotableInfo PASS');
        }
    }
