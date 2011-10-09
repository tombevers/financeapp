<?php

class Application_Form_TransactionCategoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application_Form_TransactionCategory
     */
    protected $_form;

    public function setUp()
    {       
        $categoryServiceMock = $this->getMockBuilder('\Application_Service_TransactionCategory')
            ->disableOriginalConstructor()
            ->getMock();
        $categoryServiceMock->expects($this->once())
            ->method('createOptions')
            ->will($this->returnValue(array(1 => 'foo')));
        
        $this->_form = new Application_Form_TransactionCategory(
            array(
                'categoryService' => $categoryServiceMock,
            )
        );
    }

    public function testSetDefaultsFromEntity()
    {
        $idStub = 1;
        $nameStub = 'foobar';
        $parentStub = new \App\Entity\TransactionCategory();
        $parentStub->setId(1);

        $category = new App\Entity\TransactionCategory();
        $category->setId($idStub);
        $category->setName($nameStub);
        $category->setParent($parentStub);
        

        $this->_form->setDefaultsFromEntity($category);
        $values = $this->_form->getValues();

        $this->assertEquals($idStub, $values['id']);
        $this->assertEquals($nameStub, $values['name']);
        $this->assertEquals($parentStub->getId(), $values['parent']);
    }
}
