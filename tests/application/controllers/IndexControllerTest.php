<?php

class IndexControllerTest extends ControllerTestCase
{
    public function testIndexRedirectsToDashboardController()
    {
        $this->dispatch('/');

        $this->assertNotController('error');
        $this->assertNotAction('error');

        $this->assertController('dashboard');
        $this->assertAction('index');
        $this->assertResponseCode(200);
    }
}
