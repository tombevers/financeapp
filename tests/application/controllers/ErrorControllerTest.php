<?php

class ErrorControllerTest extends ControllerTestCase
{
    public function testNonExistingPageReturnsPageNotFoundError()
    {
        $this->dispatch('/bogus');
        $this->assertController('error');
        $this->assertAction('error');
        $this->assertResponseCode(404);
    }
}
