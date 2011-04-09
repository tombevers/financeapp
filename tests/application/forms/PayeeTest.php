<?php

class Application_Form_PayeeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application_Form_Payee
     */
    protected $_form;

    public function setUp()
    {
        $this->_form = new Application_Form_Payee();
    }

    public function testSetDefaultsFromEntity()
    {
        $idStub = 1;
        $nameStub = 'name';
        $emailStub = 'foo@bar.com';
        $phoneStub = '0123456789';
        $addressStub = 'address';

        $payee = new App\Entity\Payee();
        $payee->setId($idStub);
        $payee->setName($nameStub);
        $payee->setEmail($emailStub);
        $payee->setPhone($phoneStub);
        $payee->setAddress($addressStub);

        $this->_form->setDefaultsFromEntity($payee);
        $values = $this->_form->getValues();

        $this->assertEquals($idStub, $values['id']);
        $this->assertEquals($nameStub, $values['name']);
        $this->assertEquals($emailStub, $values['email']);
        $this->assertEquals($phoneStub, $values['phone']);
        $this->assertEquals($addressStub, $values['address']);
    }
}
