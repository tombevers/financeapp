<?php

class IndexControllerTest extends ControllerTestCase
{
    public function testIndexRedirectsToDashboardController()
    {
        $this->dispatch('/');
        $this->assertAction('index');
        $this->assertController('dashboard');
    }
}
