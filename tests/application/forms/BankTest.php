<?php

class Application_Form_BankTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application_Form_Bank
     */
    protected $_form;

    public function setUp()
    {
        $this->_form = new Application_Form_Bank();
    }

    public function testSetDefaultsFromEntity()
    {
        $idStub = 1;
        $nameStub = 'name';
        $addressStub = 'address';
        $websiteStub = 'website';
        $commentStub = 'comment';

        $bank = new App\Entity\Bank();
        $bank->setId($idStub);
        $bank->setName($nameStub);
        $bank->setAddress($addressStub);
        $bank->setWebsite($websiteStub);
        $bank->setComment($commentStub);

        $this->_form->setDefaultsFromEntity($bank);
        $values = $this->_form->getValues();

        $this->assertEquals($idStub, $values['id']);
        $this->assertEquals($nameStub, $values['name']);
        $this->assertEquals($addressStub, $values['address']);
        $this->assertEquals($websiteStub, $values['website']);
        $this->assertEquals($commentStub, $values['comment']);
    }
}
