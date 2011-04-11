<?php

class ExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException App\Exception
     */
    public function testException()
    {
        throw new App\Exception('foo');
    }
}
