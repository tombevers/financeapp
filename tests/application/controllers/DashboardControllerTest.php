<?php

class DashboardControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch('/');
        $this->assertAction('index');
        $this->assertController('dashboard');
    }
}

