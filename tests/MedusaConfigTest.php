<?php

class MedusaConfigTest extends TestCase
{
    public function testConfigSet()
    {
        $this->assertNotEmpty(MedusaConfig::set(
            'test.config',
            'This is a test'
        ));
    }

    public function testConfigGet()
    {
        $this->assertEquals('This is a test', MedusaConfig::get('test.config'));
    }

    public function testConfigUpdate()
    {
        MedusaConfig::set('test.config', 'This is another test');
        $this->assertEquals(
            'This is another test',
            MedusaConfig::get('test.config')
        );
    }

    public function testConfigGetSubKey()
    {
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
        $this->assertNull(MedusaConfig::get('config.text'));
    }

    public function testConfigKeyDefault()
    {
        $this->assertEquals(
            'This is a test',
            MedusaConfig::get('config.test', 'This is a test')
        );
    }

    public function textConfigKeySubKey()
    {
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

        $this->assertArrayHasKey('Bosun', MedusaConfig::get('test.config', $default, 'RMMC'));
    }

    public function testRemove()
    {
        $this->assertTrue(MedusaConfig::remove('test.config'));
        $this->assertNull(MedusaConfig::get('test.config'));
        DB::table('config')->delete();
    }
}
