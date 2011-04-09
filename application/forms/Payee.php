<?php

class Application_Form_Payee extends Zend_Form
{
    public function init()
    {
        $idField = $this->_createHiddenIdField();
        $name = $this->_createNameField();
        $address = $this->_createAddressField();
        $phone = $this->_createPhoneField();
        $email = $this->_createEmailField();
        $submit = $this->_createSubmitButton();

        $this->addElements(
            array(
                $idField,
                $name,
                $address,
                $phone,
                $email,
                $submit
            )
        );
    }

    /**
     * Set defaults from entity
     * 
     * @param \App\Entity\Payee $payee
     */
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
        $idField = new Zend_Form_Element_Hidden('id');
        $idField->removeDecorator('DtDdWrapper')
           ->removeDecorator('HtmlTag')
           ->removeDecorator('Label');

        return $idField;
    }

    /**
     * Creates the name field
     *
     * @return Zend_Form_Element_Text
     */
    private function _createNameField()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('payeeName')
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
        $address->setLabel('payeeAddress')
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
        $phone->setLabel('payeePhone')
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
        $email->setLabel('payeeEmail')
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
        $submit->setLabel('saveAction');

        return $submit;
    }
}

