<?php

class BankControllerTest extends ControllerTestCase
{

    public function testIndexAction()
    {
        $this->dispatch('/bank');
        $this->assertController('bank');
        $this->assertAction('list');
    }

    public function testListAction()
    {
        $this->dispatch('/bank/list');
        $this->assertController('bank');
        $this->assertAction('list');
    }

    public function testCreateAction()
    {
        $this->dispatch('/bank/create');
        $this->assertController('bank');
        $this->assertAction('create');
    }

    public function testEditAction()
    {
        $this->dispatch('/bank/edit');
        $this->assertController('bank');
        $this->assertAction('edit');
    }

    public function testDeleteAction()
    {
        $this->dispatch('/bank/delete');
        $this->assertController('bank');
        $this->assertAction('delete');
    }
}

