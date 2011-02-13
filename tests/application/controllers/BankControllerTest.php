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

    public function testAccessCreateAction()
    {
        $this->dispatch('/bank/create');

        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('bank');
        $this->assertAction('create');
        $this->assertResponseCode(200);
    }
    
    public function testCanWeDisplayOurForm()
    {
        $this->dispatch('/bank/create');
        
        $this->assertNotController('error');
        $this->assertNotAction('error');
        
        $this->assertController('bank');
        $this->assertAction('create');
        $this->assertResponseCode(200);
        
        $this->assertQueryCount('form', 1);
        $this->assertQueryCount('input[type="text"]', 3);
        $this->assertQueryCount('textarea', 1);
        $this->assertQueryCount('input[type="submit"]', 1);
    }
    
    public function testSubmitFailsWhenNotPost()
    {
        $this->request->setMethod('get');
        $this->dispatch('/bank/save-bank');
        $this->assertResponseCode(302);
        $this->assertRedirectTo('/bank');
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
        $this->dispatch('/bank/save-bank');
        
        $this->assertQueryCount('dt', 3);
        $this->assertQueryCount('dd', 1);
        $this->assertQueryContentContains('dt#name', 'Unit test bank');
        $this->assertQueryContentContains('dt#address', 'street 1');
        $this->assertQueryContentContains('dt#website', 'http://www.google.com');
        $this->assertQueryContentContains('dd#comment', 'A comment');
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
        $this->dispatch('/bank/save-bank');
        
        $this->assertResponseCode(302);
        $this->assertRedirectTo('/bank/create');
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

