<?php
namespace ntentan\config\tests\cases;

use ntentan\config\tests\classes\ConfigOne;
use ntentan\config\tests\classes\ConfigTwo;

class MultiConfigTest extends \PHPUnit_Framework_TestCase
{ 
    public function testMultiConfig() {
        ConfigOne::init(__DIR__ . '/../fixtures/config/config_one.php');
        ConfigTwo::init(__DIR__ . '/../fixtures/config/config_two.php');
        $this->assertEquals('one', ConfigOne::get('config'));
        $this->assertEquals('two', ConfigTwo::get('config'));
    }
}
