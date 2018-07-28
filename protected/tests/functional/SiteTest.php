<?php
require_once('/../WebTestCase.php');
require_once('/../../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/Selenium2TestCase/URL.php');
require_once('/../../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/Selenium2TestCase/Driver.php');
require_once('/../../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/Selenium2TestCase/NoSeleniumException.php');
require_once('/../../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/Selenium2TestCase/WebDriverException.php');

class SiteTest extends WebTestCase
{
	function testFirst()
    {
        $this->assertEquals('2',$this->process(1)); //p
        $this->assertEquals('3',$this->process(1)); // f
        $this->assertEquals('2',$this->process(7)); //f
        $this->assertEquals('3',$this->process(2)); //p
        
    }
	
}
