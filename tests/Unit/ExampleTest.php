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
            Log::debug('Unit/ExampleTest testBasicTest done');
        }
    }
