<?php

class BankControllerTest extends ControllerTestCase
{
    public function testRedirectIndexToListAction()
    {
        $this->dispatch('/bank');
        
        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('bank');
        $this->assertAction('list');
    }

    public function testAccessListAction()
    {
        $this->dispatch('/bank/list');
        
        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('bank');
        $this->assertAction('list');
        $this->assertResponseCode(200);
    }

    public function testAccessAddAction()
    {
        $this->dispatch('/bank/add');

        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('bank');
        $this->assertAction('add');
        $this->assertResponseCode(200);
    }
    
    public function testCanWeDisplayOurForm()
    {
        $this->dispatch('/bank/add');
        
        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('bank');
        $this->assertAction('add');
        $this->assertResponseCode(200);
        
        $this->assertQueryCount('form', 1);
        $this->assertQueryCount('input[type="text"]', 3);
        $this->assertQueryCount('textarea', 1);
        $this->assertQueryCount('input[type="submit"]', 1);
    }
    
    public function testCanWeSubmitABank()
    {
        $this->request->setMethod('post')
                      ->setPost(array(
                      	'name'       => 'Unit test bank',
                      	'address'    => 'street 1',
                      	'website'    => 'http://www.google.com',
                        'comment'    => 'A comment',
                      ));
        $this->dispatch('/bank/add');
        
        $this->assertNotController('error');
        $this->assertNotAction('error');

        $this->assertRedirectTo('/bank/list');
        $this->assertResponseCode(302);
    }

    /**
     * @dataProvider wrongDataProvider
     */
    public function testSubmitFailsWithWrongData($name, $address, $website, 
    $comment)
    {
        $this->request->setMethod('post')
                      ->setPost(array(
                      	'name'       => $name,
                      	'address'    => $address,
                      	'website'    => $website,
                        'comment'    => $comment,
                      ));
        $this->dispatch('/bank/add');

        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('bank');
        $this->assertAction('add');
        $this->assertResponseCode(200);
    }
    
    public static function wrongDataProvider()
    {
        return array(
            array('', '', '', ''),
            array('', 'bla', '', ''),
            array('blabla', '', 'www.google.com', ''),
        );
    }
    
    public function testAccessEditAction()
    {
        $this->dispatch('/bank/edit');
        
        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('bank');
        $this->assertAction('edit');
        $this->assertResponseCode(200);
    }

    public function testAccessDeleteAction()
    {
        $this->dispatch('/bank/delete');
        
        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('bank');
        $this->assertAction('delete');
        $this->assertResponseCode(200);
    }
}

