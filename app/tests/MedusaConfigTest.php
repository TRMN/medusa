<?php

class MedusaConfigTest extends TestCase
{

    public function testConfigSet()
    {
        $this->assertNotEmpty(MedusaConfig::set('test.config', 'This is a test'));
    }

    public function testConfigGet()
    {
        $this->assertEquals('This is a test', MedusaConfig::get('test.config'));
    }

    public function testConfigUpdate()
    {
        MedusaConfig::set('test.config', 'This is another test');
        $this->assertEquals('This is another test', MedusaConfig::get('test.config'));
    }

    public function testRemove()
    {
        $this->assertTrue(MedusaConfig::remove('test.config'));
        $this->assertFalse(MedusaConfig::get('test.config'));
        DB::table('config')->delete();
    }
}
