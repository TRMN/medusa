<?php

    /**
     * Unit/ExampleTest
     */
    
    namespace Tests\Unit;
    
    use Tests\TestCase;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Log;
    
    class MedusaUtilityTest extends TestCase
    {
        /**
         * Test the Ordinal function
         *
         * @return void
         */
        public function testOrdinal()
        {
            Log::debug('Unit/MedusaUtilityTest/testOrdinal');
            
            // dead-simple one-value test
            $testInt = 10;
            $ordinalOne = \App\Utility\MedusaUtility::ordinal($testInt);
            Log::debug('Unit/MedusaUtilityTest ordinal('.$testInt.'):' . $ordinalOne);
            $this->assertTrue($ordinalOne == 'Tenth');
            
            // smarter test of 21 values
            $ordinals = array('Zeroth', 'First', 'Second', 'Third', 'Fourth', 'Fifth',
                              'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth',
                              'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth',
                              'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth', 'Twentieth');
            for ($i = 0; $i < 21; $i++) {
                $ordinal = \App\Utility\MedusaUtility::ordinal($i);
                Log::debug('Unit/MedusaUtilityTest ordinal('.$i.'):' . $ordinal);
                $this->assertTrue($ordinal == $ordinals[$i]);
            }
            
            // sample test of arbitrary numbers
            $ordinals2 = array('Fifty-fourth', 'One hundred eighty-seventh',
                               'Five thousand two hundred eighty-sixth');
            $values2 = array(54, 187, 5286);
            for ($i = 0; $i < count($values2); $i++) {
                $ordinal = \App\Utility\MedusaUtility::ordinal($values2[$i]);
                Log::debug('Unit/MedusaUtilityTest ordinal('.$i.'):' . $ordinal);
                $this->assertTrue($ordinal == $ordinals2[$i]);
            }
            
            Log::debug('Unit/MedusaUtilityTest done');
        }
        
        /**
         * Test the getWelcomeLetter funciton.
         */
        public function testGetWelcomeLetter()
        {
            Log::debug('Unit/MedusaUtilityTest/testGetWelcomeLetter');
            
            // Get the test user and validate it's who we want.
            // This will have to replaced with references to a standard test user once the DB is mocked.
            $timberId = '5b786115a016bd1d8a34cb93';
            $testUser = \App\User::find($timberId);
            Log::debug('Unit/MedusaUtilityTest/testGetWelcomeLetter found ' . $testUser->first_name . ' ' . $testUser->last_name);
            $this->assertTrue($testUser->first_name == 'Timber');
            $this->assertTrue($testUser->last_name == 'Lupindo');

            // Create a test template; add it to the config.
            $testTemplate = 'Hello, there. Welcome the %CHAPTER%. Your CO is %CO%';
            \App\MedusaConfig::set('bupers.welcome', $testTemplate);

            // Run the function under test and log the results
            $testLetter = \App\Utility\MedusaUtility::getWelcomeLetter($testUser);
            Log::debug('Unit/MedusaUtilityTest/testGetWelcomeLetter letter:' . $testLetter);
            
            // test for some expected values in the letter. 
            $this->assertTrue(strpos($testLetter, 'Welcome') > 0);
            $this->assertTrue(strpos($testLetter, 'HMS Medusa') > 0);
            $this->assertTrue(strpos($testLetter, 'Your CO') > 0);
            $this->assertTrue(strpos($testLetter, 'Captain (JG)') > 0);
            $this->assertTrue(strpos($testLetter, 'Erik Roberts') > 0);
            
        }

    }
