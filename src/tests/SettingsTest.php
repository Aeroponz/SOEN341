<?php

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/pages/SettingsPage/Settings.php');

use Website;
use PHPUnit\Framework\TestCase;

final class RatingTest extends TestCase
{

    public function testChangeToLight()
    {
        $this->assertEquals('light', Website\Settings::ChangeToLight(15));
    }

    public function testGetMode()
    {
        $this->assertEquals(1, Website\Settings::GetMode(15,1 ,2));
    }

    public function testChangeToDark()
    {
        $this->assertEquals('dark', Website\Settings::ChangeToLight(15));
    }
}
