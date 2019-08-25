<?php

    namespace Tests\Unit;
    
    use Tests\TestCase;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Log;
    use App\MedusaConfig;

    class MedusaConfigTLTest extends TestCase
    {

    public function testConfigSet()
    {
        Log::debug('Unit/MedusaConfigTest testConfigSet');
        $this->assertNotEmpty(MedusaConfig::set(
            'test.config',
            'This is a test'
        ));
    }

    public function testConfigGet()
    {
        Log::debug('Unit/MedusaConfigTest testConfigGet');
        $this->assertEquals(
            'This is a test',
            MedusaConfig::get('test.config')
            );
    }

    public function testConfigUpdate()
    {
        Log::debug('Unit/MedusaConfigTest testConfigUpdate');
        MedusaConfig::set(
            'test.config',
            'This is another test');
        $this->assertEquals(
            'This is another test',
            MedusaConfig::get('test.config'));
    }

    public function testConfigGetSubKey()
    {
        Log::debug('Unit/MedusaConfigTest testestConfigGetSubKeytConfigSet');
        MedusaConfig::set('test.config', json_decode('{
        "RMN" : {
            "regex": "/^SIA-RMN-.*/"
        },
        "RMN Speciality": {
            "regex": "/^SIA-SRN-.*/"
        }
        }'));

        $this->assertEquals(
            '/^SIA-RMN-.*/',
            MedusaConfig::get('test.config', null, 'RMN')['regex']
        );
    }

    public function testConfigKeyNotExist()
    {
        Log::debug('Unit/MedusaConfigTest testConfigKeyNotExist');
        $this->assertNull(MedusaConfig::get('config.text'));
    }

    public function testConfigKeyDefault()
    {
        Log::debug('Unit/MedusaConfigTest testConfigKeyDefault');
        $this->assertEquals(
            'This is a test',
            MedusaConfig::get('config.test', 'This is a test')
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

        $this->assertArrayHasKey('Bosun',
            MedusaConfig::get('test.config', $default, 'RMMC'));
    }

    public function testRemove()
    {
        Log::debug('Unit/MedusaConfigTest testRemove');
        $this->assertTrue(MedusaConfig::remove('test.config'));
        $this->assertNull(MedusaConfig::get('test.config'));
        \DB::table('config')->delete();
    }
}
