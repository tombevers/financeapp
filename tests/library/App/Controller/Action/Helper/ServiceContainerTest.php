<?php

require_once APPLICATION_PATH . '/controllers/IndexController.php';

class ServiceContainerTest extends ControllerTestCase
{
    public function testCanGetServiceContainerInstance()
    {
        $helper = new App\Controller\Action\Helper\ServiceContainer();
        $this->assertInstanceOf(
            'App\Controller\Action\Helper\ServiceContainer',
            $helper
        );
    }
}
