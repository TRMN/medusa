<?php

    namespace Tests\Unit;
    
    use Tests\TestCase;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Log;

    class MedusaConfigTest extends TestCase
    {
    public function testConfigSet()
    {
        Log::debug('Unit/MedusaConfigTest testConfigSet');
        $this->assertNotEmpty(\App\MedusaConfig::set(
            'test.config',
            'This is a test'
        ));
    }

    public function testConfigGet()
    {
        Log::debug('Unit/MedusaConfigTest testConfigGet');
        $this->assertEquals('This is a test', \App\MedusaConfig::get('test.config'));
    }

    public function testConfigUpdate()
    {
        Log::debug('Unit/MedusaConfigTest testConfigUpdate');
        \App\MedusaConfig::set('test.config', 'This is another test');
        $this->assertEquals(
            'This is another test',
            \App\MedusaConfig::get('test.config')
        );
    }

    public function testConfigGetSubKey()
    {
        Log::debug('Unit/MedusaConfigTest testestConfigGetSubKeytConfigSet');
        \App\MedusaConfig::set('test.config', json_decode('{
    "RMN" : {
        "regex": "/^SIA-RMN-.*/"
    },
    "RMN Speciality": {
        "regex": "/^SIA-SRN-.*/"
    }
    }'));

        $this->assertEquals(
            '/^SIA-RMN-.*/',
            \App\MedusaConfig::get('test.config', null, 'RMN')['regex']
        );
    }

    public function testConfigKeyNotExist()
    {
        Log::debug('Unit/MedusaConfigTest testConfigKeyNotExist');
        $this->assertNull(\App\MedusaConfig::get('config.text'));
    }

    public function testConfigKeyDefault()
    {
        Log::debug('Unit/MedusaConfigTest testConfigKeyDefault');
        $this->assertEquals(
            'This is a test',
            \App\MedusaConfig::get('config.test', 'This is a test')
        );
    }

    public function textConfigKeySubKey()
    {
        Log::debug('Unit/MedusaConfigTest textConfigKeySubKey');
        $default = json_decode('{
            "Commanding Officer": {
                "billet": "Commanding Officer",
                "display_order": 1
            },
            "Executive Officer": {
                "billet": "Executive Officer",
                "display_order": 2
            },
            "Bosun": {
                "billet": "Bosun",
                "display_order": 3
            }
        }', true);

        $this->assertArrayHasKey('Bosun', \App\MedusaConfig::get('test.config', $default, 'RMMC'));
    }

    public function testRemove()
    {
        Log::debug('Unit/MedusaConfigTest testRemove');
        $this->assertTrue(\App\MedusaConfig::remove('test.config'));
        $this->assertNull(\App\MedusaConfig::get('test.config'));
        \DB::table('config')->delete();                               
    }
}
