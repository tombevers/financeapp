<?php

class TransactionControllerTest extends ControllerTestCase
{
    public function testAccessAddAction()
    {
        $this->dispatch('/transaction/add');

        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('transaction');
        $this->assertAction('add');
        $this->assertResponseCode(200);
    }

    /**
     * @dataProvider wrongDataProvider
     */
    public function testSubmitFailsWithWrongData($account, $amount, $date, 
        $note)
    {
        $this->request->setMethod('post')
            ->setPost(
                array(
                    'account' => $account,
                    'amount'  => $amount,
                    'date'    => $date,
                    'note'    => $note,
                )
            );
        
        $this->dispatch('/transaction/add');

        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('transaction');
        $this->assertAction('add');
        $this->assertResponseCode(200);
    }
    
    public static function wrongDataProvider()
    {
        return array(
            array('', '', '', ''),
            array('1', '', '', ''),
            array('1', '200', '', ''),
            array('1', '200', '', 'foo'),
        );
    }
}
