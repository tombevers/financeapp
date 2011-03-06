<?php

class Application_Form_Payee extends Zend_Form
{
    public function init()
    {
        $id = $this->_createHiddenIdField();
        $name = $this->_createNameField();
        $address = $this->_createAddressField();
        $phone = $this->_createPhoneField();
        $email = $this->_createEmailField();
        $submit = $this->_createSubmitButton();

        $this->addElements(
            array(
                $id,
                $name,
                $address,
                $phone,
                $email,
                $submit
            )
        );
    }

    public function setDefaultsFromEntity(\App\Entity\Payee $payee)
    {
        $values = array(
            'id'        => $payee->getId(),
            'name'      => $payee->getName(),
            'address'   => $payee->getAddress(),
            'phone'     => $payee->getPhone(),
            'email'     => $payee->getEmail(),
        );
        
        $this->setDefaults($values);
    }
    
    /**
     * Creates the hidden id field
     *
     * @return Zend_Form_Element_Hidden
     */
    private function _createHiddenIdField()
    {
        $id = new Zend_Form_Element_Hidden('id');
        $id->removeDecorator('DtDdWrapper')
           ->removeDecorator('HtmlTag')
           ->removeDecorator('Label');

        return $id;
    }

    /**
     * Creates the name field
     * 
     * @return Zend_Form_Element_Text
     */
    private function _createNameField()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(array(2, 60)))
            ->setRequired();
        
        return $name;
    }
    
    /**
     * Creates the address field
     * 
     * @return Zend_Form_Element_Text
     */
    private function _createAddressField()
    {
        $address = new Zend_Form_Element_Text('address');
        $address->setLabel('Address')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(array(2, 150)));
        
        return $address;
    }
    
    /**
     * Creates the phone field
     * 
     * @return Zend_Form_Element_Text
     */
    private function _createPhoneField()
    {
        $phone = new Zend_Form_Element_Text('phone');
        $phone->setLabel('Phone')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(array(2, 150)));
        
        return $phone;
    }
        
    /**
     * Creates the email field
     * 
     * @return Zend_Form_Element_Text
     */
    private function _createEmailField()
    {
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
            ->addValidator(new Zend_Validate_EmailAddress());
        
        return $email;
    }
    
    /**
     * Creates the submit button
     * 
     * @return Zend_Form_Element_Submit
     */
    private function _createSubmitButton()
    {
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Save');
        
        return $submit;
    }
}

