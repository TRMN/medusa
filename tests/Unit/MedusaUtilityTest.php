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
         * A basic test example.
         *
         * @return void
         */
        public function testBasicTest()
        {
            Log::debug('Unit/MedusaUtilityTest');
            $this->assertTrue(true);
            
            $testInt = 10;
            $ordinalOne = \App\Utility\MedusaUtility::ordinal($testInt);
            Log::debug('Unit/MedusaUtilityTest ordinal('.$testInt.'):' . $ordinalOne);
            
            Log::debug('Unit/MedusaUtilityTest done');
        }
    }
