<?php
    
    namespace Test\Unit;
    
    use Tests\TestCase;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Log;
    use App\MedusaConfig;
    use App\Utility\MedusaUtility;
    use App\Promotions\MedusaPromotions;
    
    class MedusaPromotionsTest extends TestCase
    {
        use MedusaPromotions;
        
        public function setUp(): void
        {
            parent::setUp();
            Log::debug('Unit/UserTest setUp');
        }
        
        // trivial test - needs real data setup
        public function testIsPromotable1()
        {
            Log::debug('Unit/MedusaPromotionsTest testIsPromotable1');
            $testUserID = '5b786115a016bd1d8a34cb93'; // Timber
            $this->user = \App\User::find($testUserID);
            $this->assertFalse($this->user->isPromotable());
        }
        
        // trivial test of getPromotableInfo
        public function testGetPromotableInfo()
        {
            Log::debug('Unit/MedusaPromotionsTest testgetPromotableInfo');
            $testUserID = '5b786115a016bd1d8a34cb93'; // Timber
            $this->user = \App\User::find($testUserID);
            
            $flags = $this->user->getPromotableInfo(); // MedusaPromotions
            
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
            
            $this->assertFalse($flags['tig']);
            $this->assertFalse($flags['points']);
            $this->assertFalse($flags['exams']);
            $this->assertFalse($flags['early']);
            
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
            
        }
    }
