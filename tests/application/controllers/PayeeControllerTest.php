<?php

class PayeeControllerTest extends ControllerTestCase
{
    public function testAccessAddAction()
    {
        $this->dispatch('/payee/add');

        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('payee');
        $this->assertAction('add');
        $this->assertResponseCode(200);
    }
    
    public function testCanWeDisplayOurForm()
    {
        $this->dispatch('/payee/add');
        
        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('payee');
        $this->assertAction('add');
        $this->assertResponseCode(200);
        
        $this->assertQueryCount('form', 1);
        $this->assertQueryCount('input[type="text"]', 4);
        $this->assertQueryCount('input[type="submit"]', 1);
    }
    
    /**
     * @dataProvider wrongDataProvider
     */
    public function testSubmitFailsWithWrongData($name, $address, $phone, 
    $email)
    {
        $this->request->setMethod('post')
            ->setPost(
                array(
                    'name'      => $name,
                    'address'   => $address,
                    'phone'     => $phone,
                    'email'     => $email,
                )
            );
        
        $this->dispatch('/payee/add');

        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('payee');
        $this->assertAction('add');
        $this->assertResponseCode(200);
    }
    
    public static function wrongDataProvider()
    {
        return array(
            array('', '', '', ''),
            array('', 'bla', '', ''),
            array('blabla', '', '', 'test'),
            array('blabla', '', '', 'test@test'),
        );
    }
}
