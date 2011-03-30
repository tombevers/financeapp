<?php

namespace App\View\Helper;

class IsActiveTest extends \PHPUnit_Framework_TestCase
{
    protected $_view;

    public function setUp()
    {
        global $application;
        $application->bootstrap();

        $front = \Zend_Controller_Front::getInstance();
        $request = new \Zend_Controller_Request_Http();
        $front->setRequest($request->setControllerName('foo'));

        $this->_view = \Zend_Registry::get('view');
    }

    public function testActiveController()
    {
        $this->assertTrue($this->_view->isActive('foo'));
    }

    public function testNotActiveController()
    {
        $this->assertFalse($this->_view->isActive('bar'));
    }
}
