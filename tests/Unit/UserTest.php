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
            $testUserID = '5b786115a016bd1d8a34cb93';
            $this->user = \App\User::find($testUserID);
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
            Log::debug('Unit/UserTest testgetNextAvailableMemberId '.$namID);
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
            Log::debug('Unit/UserTest testgetFirstAvailableMemberId '.$namID);
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
        
        public function testgetNumExams()
        {
            Log::debug('Unit/UserTest testgetNumExams');
            $numExams = $this->user->getNumExams();
            Log::debug($numExams);
            $this->assertTrue($numExams > 10);
        }

        public function testrouteNotificationForMail()
        {
            Log::debug('Unit/UserTest testrouteNotificationForMail');
            $emailAddy = $this->user->routeNotificationForMail();
            Log::debug($emailAddy); //me@timberwoof.com
            $this->assertTrue(strpos($emailAddy, '@') > 0);
            $this->assertTrue(strpos($emailAddy, '.') > strpos($emailAddy, '@'));
        }

        public function testgetEmailForPasswordReset()
        {
            Log::debug('Unit/UserTest getEmailForPasswordReset');
            $emailAddy = $this->user->getEmailForPasswordReset();
            Log::debug($emailAddy); //me@timberwoof.com
            $this->assertTrue(strpos($emailAddy, '@') > 0);
            $this->assertTrue(strpos($emailAddy, '.') > strpos($emailAddy, '@'));
        }

        public function testgetGreetingAndName()
        {
            Log::debug('Unit/UserTest getGreetingAndName');
            $greeting = $this->user->getGreetingAndName();
            Log::debug($greeting); //Spacer 2nd Class Timber Lupindo
            $this->assertTrue(strpos($greeting, 'Spacer') == 0);
            $this->assertTrue(strpos($greeting, 'Class') > 0);
            $this->assertTrue(strpos($greeting, 'Timber') > 0);
            $this->assertTrue(strpos($greeting, 'Lupindo') > 0);
        }
        
        public function testgetFullName()
        {
            Log::debug('Unit/UserTest getFullName');
            $fullName = $this->user->getFullName(true);
            Log::debug($fullName); // Lupindo, Timber
            $this->assertTrue(strpos($fullName, 'Timber') > 0);
            $this->assertTrue(strpos($fullName, 'Lupindo') == 0);
            $fullName = $this->user->getFullName(false);
            Log::debug($fullName); // Timber Lupindo
            $this->assertTrue(strpos($fullName, 'Timber') == 0);
            $this->assertTrue(strpos($fullName, 'Lupindo') > 0);
        }

        public function testgetGreeting()
        {
            Log::debug('Unit/UserTest getGreeting');
            $greeting = $this->user->getGreeting();
            Log::debug($greeting); //Spacer 2nd Class
            $this->assertTrue(strpos($greeting, 'Spacer') == 0);
            $this->assertTrue(strpos($greeting, 'Class') > 0);
        }
        
        // getGreetingArray
    }
