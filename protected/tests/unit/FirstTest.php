<?php
require_once('/../../../yii/framework/test/CTestCase.php');

class FirstTest extends CTestCase
{
    public function testTrueAssertsToTrue(){
        $this->asserttrue(true);
    }
    
}