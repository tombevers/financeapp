<?php

class FormTest extends PHPUnit_Framework_TestCase
{
    public function testIsValid()
    {
        $form = new \App\Form();
        $this->assertTrue($form->isValid(array()));
    }
    
    public function testIsNotValid()
    {
        $form = new \App\Form();
        $element = new Zend_Form_Element_Text('test');
        $element->setRequired();
        $form->addElement($element);
        $this->assertFalse($form->isValid(array()));
    }
}
