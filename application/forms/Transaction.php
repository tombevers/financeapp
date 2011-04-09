<?php

class Application_Form_Transaction extends Zend_Form
{
    public function init()
    {
        $typeService = App\ServiceLocator::getTransactionTypeService();
        $typeOptions = $typeService->createOptions();
        $accountService = App\ServiceLocator::getAccountService();
        $accountOptions = $accountService->createOptions();

        $idField = $this->_createHiddenIdField();
        $typeField = $this->_createTypesDropDown($typeOptions);
        $account = $this->_createAccountDropDown($accountOptions);
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

    /**
     * Set defaults from entity
     * 
     * @param \App\Entity\Transaction $transaction
     */
    public function setDefaultsFromEntity(\App\Entity\Transaction $transaction)
    {
        $values = array(
            'id'        => $transaction->getId(),
            'type'      => $transaction->getType()->getId(),
            'account'   => $transaction->getAccount()->getId(),
            'amount'    => $transaction->getAmount(),
            'date'      => $transaction->getDate()->format('Y-m-d'),
            'note'      => $transaction->getNote(),
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
        $types->setLabel('transactionType')
            ->setMultiOptions($options)
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
        $date = new ZendX_JQuery_Form_Element_DatePicker('date');
        $date->setLabel('transactionDate')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_Date())
            ->setRequired()
            ->setJQueryParam('dateFormat', 'yy-mm-dd');

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
            ->addValidator(new Zend_Validate_StringLength(array('min' => 3)))
            ->setAttribs(array('cols' => '60', 'rows' => '5'));

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
