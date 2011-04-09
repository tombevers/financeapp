<?php

class Application_Form_Account extends Zend_Form
{
    public function init()
    {
        $typeService = App\ServiceLocator::getAccountTypeService();
        $typeOptions = $typeService->createOptions();

        $bankService = App\ServiceLocator::getBankService();
        $bankOptions = $bankService->createOptions();

        $idField = $this->_createHiddenIdField();
        $typeField = $this->_createTypesDropDown($typeOptions);
        $name = $this->_createNameField();
        $number = $this->_createNumberField();
        $bank = $this->_createBankDropDown($bankOptions);
        $comment = $this->_createCommentField();
        $submit = $this->_createSubmitButton();

        $this->addElements(
            array(
                $idField,
                $typeField,
                $name,
                $number,
                $bank,
                $comment,
                $submit
            )
        );
    }

    /**
     * Set defaults from entity
     *
     * @param \App\Entity\Account $account
     */
    public function setDefaultsFromEntity(\App\Entity\Account $account)
    {
        $values = array(
            'id'        => $account->getId(),
            'type'      => $account->getType()->getId(),
            'name'      => $account->getName(),
            'number'    => $account->getNumber(),
            'bank'      => $account->getBank()->getId(),
            'comment'   => $account->getComment(),
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
     * Creates the types dropdown field
     *
     * @param array $options
     * @return Zend_Form_Element_Select
     */
    private function _createTypesDropDown($options)
    {
        $types = new Zend_Form_Element_Select('type');
        $types->setLabel('accountType')
            ->setMultiOptions($options)
            ->setRequired();

       return $types;
    }

    /**
     * Creates the name field
     *
     * @return Zend_Form_Element_Text
     */
    private function _createNameField()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('accountName')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(array(2, 60)))
            ->setRequired();

        return $name;
    }

    /**
     * Creates the number field
     *
     * @return Zend_Form_Element_Text
     */
    private function _createNumberField()
    {
        $number = new Zend_Form_Element_Text('number');
        $number->setLabel('accountNumber')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(array(2, 60)))
            ->setRequired();

        return $number;
    }

    /**
     * Creates the bank dropdown field
     *
     * @param array $bankOptions
     * @return Zend_Form_Element_Select
     */
    private function _createBankDropDown(array $bankOptions)
    {
        $bank = new Zend_Form_Element_Select('bank');
        $bank->setLabel('accountBank')
            ->setMultiOptions($bankOptions)
            ->setRequired();

       return $bank;
    }


    /**
     * Creates the comment field
     *
     * @return Zend_Form_Element_Textarea
     */
    private function _createCommentField()
    {
        $comment = new Zend_Form_Element_Textarea('comment');
        $comment->setLabel('accountComment')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(array('min' => 5)))
            ->setAttribs(array('cols' => '60', 'rows' => '5'));

        return $comment;
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
