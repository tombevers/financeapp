<?php

class Application_Form_TransactionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application_Form_Transaction
     */
    protected $_form;

    public function setUp()
    {
        $accountServiceMock = $this->getMockBuilder('\Application_Service_Account')
            ->disableOriginalConstructor()
            ->getMock();
        $accountServiceMock->expects($this->once())
            ->method('createOptions')
            ->will($this->returnValue(array(1 => 'foo')));
        
        $typeServiceMock = $this->getMockBuilder('\Application_Service_TransactionType')
            ->disableOriginalConstructor()
            ->getMock();
        $typeServiceMock->expects($this->once())
            ->method('createOptions')
            ->will($this->returnValue(array(1 => 'foo')));
        
        $this->_form = new Application_Form_Transaction(
            array(
                'accountService' => $accountServiceMock,
                'typeService' => $typeServiceMock,
            )
        );
    }

    public function testSetDefaultsFromEntity()
    {
        $idStub = 1;
        $amountStub = 123456789;
        $noteStub = 'note';
        $dateStub = new DateTime();
        $dateStub->setDate('2011', '2', '10');
        $typeStub = new \App\Entity\TransactionType();
        $typeStub->setId(1);
        
        $accountStub = new App\Entity\Account();
        $accountStub->setId(1);

        $transaction = new App\Entity\Transaction();
        $transaction->setId($idStub);
        $transaction->setAccount($accountStub);
        $transaction->setAmount($amountStub);
        $transaction->setType($typeStub);
        $transaction->setDate($dateStub);
        $transaction->setNote($noteStub);

        $this->_form->setDefaultsFromEntity($transaction);
        $values = $this->_form->getValues();

        $this->assertEquals($idStub, $values['id']);
        $this->assertEquals($amountStub, $values['amount']);
        $this->assertEquals($typeStub->getId(), $values['type']);
        $this->assertEquals($accountStub->getId(), $values['account']);
        $this->assertEquals($dateStub->format('Y-m-d'), $values['date']);
        $this->assertEquals($noteStub, $values['note']);
    }
}
