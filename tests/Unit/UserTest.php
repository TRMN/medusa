<?php
    
    namespace Test\Unit;
    
    use Tests\TestCase;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Log;
    use App\MedusaConfig;
    use App\Utility\MedusaUtility;
    
    class UserTest extends TestCase
    {
        
        public function setUp(): void
        {
            parent::setUp();
            Log::debug('Unit/UserTest setUp');
            $timberId = '5b786115a016bd1d8a34cb93';
            $testUser = \App\User::find($timberId);
            $this->user = $testUser;
        }
        
        public function testgetNextAvailableMemberId()
        {
            Log::debug('Unit/UserTest testgetNextAvailableMemberId');
            $namID = \App\User::getNextAvailableMemberId(); // -0000-19
            Log::debug($namID);
            $this->assertEquals('-', substr($namID, 0, 1));
            $this->assertEquals('-', substr($namID, 5, 1));
            $this->assertTrue(is_numeric(substr($namID,1,4)));
            $this->assertTrue(is_numeric(substr($namID,6,2)));
        }
        
        public function testgetFirstAvailableMemberId()
        {
            Log::debug('Unit/UserTest testgetFirstAvailableMemberId');
            $namID = \App\User::getFirstAvailableMemberId(); // -0000-19
            Log::debug($namID);
            $this->assertEquals('-', substr($namID, 0, 1));
            $this->assertEquals('-', substr($namID, 5, 1));
            $this->assertTrue(is_numeric(substr($namID,1,4)));
            $this->assertTrue(is_numeric(substr($namID,6,2)));
        }
        
        public function testgetLastLogin()
        {
            Log::debug('Unit/UserTest testgetLastLogin');

            $llogin = $this->user->getLastLogin(); // 2019-01-22
            Log::debug($llogin);
            $this->assertEquals('-', substr($llogin, 4, 1));
            $this->assertEquals('-', substr($llogin, 7, 1));
            $this->assertTrue(is_numeric(substr($llogin,0,4)));
            $this->assertTrue(is_numeric(substr($llogin,5,2)));
            $this->assertTrue(is_numeric(substr($llogin,8,2)));
        }
    }
