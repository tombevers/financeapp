<?php

class Application_Form_ScheduledTransactionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application_Form_ScheduledTransaction
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

        $categoryServiceMock = $this->getMockBuilder('\Application_Service_TransactionCategory')
            ->disableOriginalConstructor()
            ->getMock();
        $categoryServiceMock->expects($this->once())
            ->method('createOptions')
            ->will($this->returnValue(array(1 => 'foo')));
        
        $this->_form = new Application_Form_ScheduledTransaction(
            array(
                'accountService' => $accountServiceMock,
                'typeService' => $typeServiceMock,
                'categoryService' => $categoryServiceMock,
            )
        );
    }

    public function testSetDefaultsFromEntity()
    {
        $idStub = 1;
        $amountStub = 123456789;
        $nextDateStub = new DateTime();
        $nextDateStub->setDate('2011', '2', '10');
        $frequencyStub = 'one time';
        $continuousStub = 0;
        $numberStub = 100;
        $automaticallyStub = 1;
        
        $typeStub = new \App\Entity\TransactionType();
        $typeStub->setId(1);
        
        $accountStub = new App\Entity\Account();
        $accountStub->setId(1);
        
        $categoryStub = new App\Entity\Account();
        $categoryStub->setId(1);

        $transaction = new App\Entity\ScheduledTransaction();
        $transaction->setId($idStub);
        $transaction->setAccount($accountStub);
        $transaction->setAmount($amountStub);
        $transaction->setType($typeStub);
        $transaction->setNextDate($nextDateStub);
        $transaction->setCategory($categoryStub);
        $transaction->setFrequency($frequencyStub);
        $transaction->setContinuous($continuousStub);
        $transaction->setNumber($numberStub);
        $transaction->setAutomatically($automaticallyStub);

        $this->_form->setDefaultsFromEntity($transaction);
        $values = $this->_form->getValues();

        $this->assertEquals($idStub, $values['id']);
        $this->assertEquals($amountStub, $values['amount']);
        $this->assertEquals($typeStub->getId(), $values['type']);
        $this->assertEquals($accountStub->getId(), $values['account']);
        $this->assertEquals($nextDateStub->format('Y-m-d'), $values['nextDate']);
        $this->assertEquals($categoryStub->getId(), $values['category']);
    }
}
