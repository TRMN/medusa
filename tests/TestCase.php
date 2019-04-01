<?php
    
    namespace Tests;
    
    use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
    use Illuminate\Support\Facades\Log;
    
    abstract class TestCase extends BaseTestCase
    {
        use CreatesApplication;
    }
