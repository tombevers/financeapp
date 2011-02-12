<?php

namespace App\Validate;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testUrls($url, $expectedResult)
    {      
        $validator = new Url();
        $this->assertEquals($expectedResult, $validator->isValid($url));
    }
    
    public static function urlProvider()
    {
        return array(
            array('http://www.google.com', TRUE),
            array('http://google.com', TRUE),
            array('www.google.com', FALSE),
        );
    }
}
