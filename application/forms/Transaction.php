<?php

class Application_Form_Transaction extends Zend_Form
{
    public function init()
    {
        $transactionTypeService = App\ServiceLocator::getTransactionTypeService();
        
        $idField = $this->_createHiddenIdField();
        $typeField = $this->_createTypesDropDown(
            $transactionTypeService->fetchAll()
        );
        $account = $this->_createAccountDropDown(
            $this->_createAccountOptions()
        );
        $amount = $this->_createAmountField();
        $date = $this->_createDateField();
        $note = $this->_createNoteField();
        $submit = $this->_createSubmitButton();

        $this->addElements(
            array(
                $idField,
                $typeField,
                $account,
                $amount,
                $date,
                $note,
                $submit
            )
        );
    }

    public function setDefaultsFromEntity(\App\Entity\Transaction $transaction)
    {
        $values = array(
            'id'        => $transaction->getId(),
            'type'      => $transaction->getType(),
            'account'   => $transaction->getAccount()->getId(),
            'amount'    => $transaction->getAmount(),
            'date'      => $transaction->getDate()->format('Y-m-d'),
            'note'      => $transaction->getNote(),
        );
        
        $this->setDefaults($values);
    }
    
    /**
     * Creates the account options needed for the dropdown
     * 
     * @return array
     */
    private function _createAccountOptions()
    {
        $accountService = App\ServiceLocator::getAccountService();
        $accounts = $accountService->fetchAll();
        $accountOptions = array();
        foreach ($accounts as $account) {
            $accountOptions[$account->getId()] = $account->getName();
        }
        
        return $accountOptions;
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
        $types->setLabel('transactionType')
            ->setMultiOptions($typeOptions)
            ->setRequired();
       
       return $types;
    }
    
    /**
     * Creates the amount field
     * 
     * @return Zend_Form_Element_Text
     */
    private function _createAmountField()
    {
        $ammount = new Zend_Form_Element_Text('amount');
        $ammount->setLabel('transactionAmount')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->setRequired();
        
        return $ammount;
    }
    
    /**
     * Creates the date field
     * 
     * @return Zend_Form_Element_Text
     */
    private function _createDateField()
    {
        $date = new Zend_Form_Element_Text('date');
        $date->setLabel('transactionDate')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_Date())
            ->setRequired();
        
        return $date;
    }
    
    /**
     * Creates the account dropdown field
     * 
     * @param array $accountOptions
     * @return Zend_Form_Element_Select 
     */
    private function _createAccountDropDown(array $accountOptions)
    {
        $account = new Zend_Form_Element_Select('account');
        $account->setLabel('transactionAccount')
            ->setMultiOptions($accountOptions)
            ->setRequired();
       
       return $account;
    }

    /**
     * Creates the note field
     * 
     * @return Zend_Form_Element_Textarea
     */
    private function _createNoteField()
    {
        $note = new Zend_Form_Element_Textarea('note');
        $note->setLabel('transactionNote')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(array('min' => 3)));
        
        return $note;
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
