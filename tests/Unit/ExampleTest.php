<?php

    /**
     * Unit/ExampleTest
     */
    
    namespace Tests\Unit;
    
    use Tests\TestCase;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Log;
    
    class ExampleTest extends TestCase
    {
        /**
         * A basic test example.
         *
         * @return void
         */
        public function testBasicTest()
        {
            Log::debug('Unit/ExampleTest testBasicTest');
            $this->assertTrue(true);
            
            $billets = \App\Billet::getBillets();
            Log::debug('Unit/ExampleTest count($billets):' . count($billets));
            $this->assertTrue(count($billets) > 500);
            
            $branches = \App\Branch::getBranchList();
            Log::debug('Unit/ExampleTest count($branches):' . count($branches));
            $this->assertTrue(count($branches) > 10);

            $navalBranches = \App\Branch::getNavalBranchList();
            Log::debug('Unit/ExampleTest count($navalBranches):' . count($navalBranches));
            $this->assertTrue(count($branches) > 5);
            
            Log::debug('Unit/ExampleTest testBasicTest done');
        }
    }
