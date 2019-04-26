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
        public function testBasicTest()
        {
            Log::debug('Unit/MedusaUtilityTest');
            $this->assertTrue(true);
            
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
    }
