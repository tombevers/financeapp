<?php

class Application_Form_Account extends Zend_Form
{
    public function init()
    {
        $accountTypeService = App\ServiceLocator::getAccountTypeService();
        
        $idField = $this->_createHiddenIdField();
        $typeField = $this->_createTypesDropDown(
            $accountTypeService->fetchAll()
        );
        $name = $this->_createNameField();
        $number = $this->_createNumberField();
        $bank = $this->_createBankDropDown($this->_createBankOptions());
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

    public function setDefaultsFromEntity(\App\Entity\Account $account)
    {
        $values = array(
            'id'        => $account->getId(),
            'type'      => $account->getType(),
            'name'      => $account->getName(),
            'number'    => $account->getNumber(),
            'bank'      => $account->getBank()->getId(),
            'comment'   => $account->getComment(),
        );
        
        $this->setDefaults($values);
    }
    
    /**
     * Creates the bank options needed for the dropdown
     * 
     * @return array
     * @todo move to the service
     */
    private function _createBankOptions()
    {
        $bankService = App\ServiceLocator::getBankService();
        $banks = $bankService->fetchAll();
        $bankOptions = array();
        foreach ($banks as $bank) {
            $bankOptions[$bank->getId()] = $bank->getName();
        }
        
        return $bankOptions;
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
     * @param array $typeOptions
     * @return Zend_Form_Element_Select 
     */
    private function _createTypesDropDown($typeOptions)
    {
        $types = new Zend_Form_Element_Select('type');
        $types->setLabel('Type')
            ->setMultiOptions($typeOptions)
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
        $name->setLabel('Name')
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
        $number->setLabel('Number')
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
        $bank->setLabel('Bank')
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
        $comment->setLabel('Comment')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(array('min' => 5)));
        
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
        $submit->setLabel('Save');
        
        return $submit;
    }
}
