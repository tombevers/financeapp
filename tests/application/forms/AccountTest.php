<?php

class Application_Form_AccountTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application_Form_Bank
     */
    protected $_form;

    public function setUp()
    {
        $bankServiceMock = $this->getMockBuilder('\Application_Service_Bank')
            ->disableOriginalConstructor()
            ->getMock();
        $bankServiceMock->expects($this->once())
            ->method('createOptions')
            ->will($this->returnValue(array(1 => 'foo')));
        
        $typeServiceMock = $this->getMockBuilder('\Application_Service_AccountType')
            ->disableOriginalConstructor()
            ->getMock();
        $typeServiceMock->expects($this->once())
            ->method('createOptions')
            ->will($this->returnValue(array(1 => 'foo')));
        
        $this->_form = new Application_Form_Account(
            array(
                'bankService' => $bankServiceMock,
                'typeService' => $typeServiceMock,
            )
        );
    }

    public function testSetDefaultsFromEntity()
    {
        $idStub = 1;
        $nameStub = 'name';
        $numberStub = '123456789';
        $commentStub = 'comment';
        $bankStub = new App\Entity\Bank();
        $bankStub->setId(1);
        
        $typeStub = new App\Entity\AccountType();
        $typeStub->setId(1);

        $account = new App\Entity\Account();
        $account->setId($idStub);       
        $account->setName($nameStub);
        $account->setNumber($numberStub);
        $account->setBank($bankStub);
        $account->setType($typeStub);
        $account->setComment($commentStub);

        $this->_form->setDefaultsFromEntity($account);
        $values = $this->_form->getValues();

        $this->assertEquals($idStub, $values['id']);
        $this->assertEquals($nameStub, $values['name']);
        $this->assertEquals($numberStub, $values['number']);
        $this->assertEquals($bankStub->getId(), $values['bank']);
        $this->assertEquals($typeStub->getId(), $values['type']);
        $this->assertEquals($commentStub, $values['comment']);
    }
}
