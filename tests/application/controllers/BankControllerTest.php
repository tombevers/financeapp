<?php

class BankControllerTest extends ControllerTestCase
{
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

    /**
     * @dataProvider wrongDataProvider
     */
    public function testSubmitFailsWithWrongData($name, $address, $website,
    $comment)
    {
        $this->request->setMethod('post')
            ->setPost(
                array(
                    'name'       => $name,
                    'address'    => $address,
                    'website'    => $website,
                    'comment'    => $comment,
                )
            );

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
}

