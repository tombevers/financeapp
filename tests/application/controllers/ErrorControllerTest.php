<?php

class ErrorControllerTest extends ControllerTestCase
{
    public function testCallingBogusTriggers404Error()
    {
        $this->dispatch('/bogus');
        $this->assertController('error');
        $this->assertAction('error');
        $this->assertResponseCode(404);
    }
}
