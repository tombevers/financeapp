<?php

class Application_Service_ScheduledTransactionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        global $application;
        $application->bootstrap();

        Zend_Session::$_unitTestEnabled = true;

        /**
         * Fix for ZF-8193
         * http://framework.zend.com/issues/browse/ZF-8193
         * Zend_Controller_Action->getInvokeArg('bootstrap') doesn't work
         * under the unit testing environment.
         */
        $front = Zend_Controller_Front::getInstance();
        if($front->getParam('bootstrap') === null) {
            $front->setParam('bootstrap', $application->getBootstrap());
        }
    }
    
    /**
     * @dataProvider nextDateProvider
     */
    public function testCalculateNextDate($expected, $frequency, $nextDate)
    {
        $service = new Application_Service_ScheduledTransaction();
        $this->assertEquals($expected, $service->calculateNextDate($frequency, $nextDate));
    }
    
    public function nextDateProvider()
    {
        return array(
            array(NULL, 0, new DateTime('2011-01-01')),
            array(new DateTime('2011-01-02'), 1, new DateTime('2011-01-01')),
            array(new DateTime('2011-01-08'), 2, new DateTime('2011-01-01')),
            array(new DateTime('2011-01-15'), 3, new DateTime('2011-01-01')),
            array(new DateTime('2011-01-29'), 4, new DateTime('2011-01-01')),
            array(new DateTime('2011-02-01'), 5, new DateTime('2011-01-01')),
            array(new DateTime('2011-03-01'), 6, new DateTime('2011-01-01')),
            array(new DateTime('2011-04-01'), 7, new DateTime('2011-01-01')),
            array(new DateTime('2011-07-01'), 8, new DateTime('2011-01-01')),
            array(new DateTime('2012-01-01'), 9, new DateTime('2011-01-01')),
        );
    }
}
