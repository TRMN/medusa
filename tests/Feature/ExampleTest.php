<?php

    /**
     * Feature/ExampleTest
     */

    namespace Tests\Feature;
    
    use Tests\TestCase;
    use Illuminate\Foundation\Testing\RefreshDatabase;

    class ExampleTest extends TestCase
    {
        /**
         * A basic test example.
         *
         * @return void
         */
        public function testBasicTest()
        {
            \Log::debug('Feature/ExampleTest testBasicTest');
            $response = $this->get('http://medusa.local:8080');
            
            // I'd like this to be a better http result code,
            // but for now this will do as a proof of concept
            $response->assertStatus(500);
            \Log::debug('Feature/ExampleTest testBasicTest done');
        }
    }
