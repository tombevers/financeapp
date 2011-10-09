<?php

class Application_Form_Transaction extends Zend_Form
{
    /**
     * @var \Application_Service_Account
     */
    protected $_accountService;
    
    /**
     * @var \Application_Service_AccountType
     */
    protected $_typeService;
    
    /**
     * @var \Application_Service_TransactionCategory
     */
    protected $_categoryService;
    
    public function init()
    {
        $typeService = $this->getTypeService();
        $typeOptions = $typeService->createOptions();
        $accountService = $this->getAccountService();
        $accountOptions = $accountService->createOptions();
        $categoryService = $this->getCategoryService();
        $categoryOptions = $categoryService->createOptions(FALSE);

        $this->addElements(
            array(
                $this->_createHiddenIdField(),
                $this->_createTypesDropDown($typeOptions),
                $this->_createAccountDropDown($accountOptions),
                $this->_createCategoryDropDown($categoryOptions),
                $this->_createAmountField(),
                $this->_createDateField(),
                $this->_createNoteField(),
                $this->_createSubmitButton()
            )
        );
    }
    
    /**
     * Sets the transaction type service
     * 
     * @param \Application_Service_TransactionType $typeService
     * @return Application_Form_Transaction
     */
    public function setTypeService(\Application_Service_TransactionType $typeService)
    {
        $this->_typeService = $typeService;
        return $this;
    }
    
    /**
     * Gets the transaction type service
     * 
     * @return Application_Service_TransactionType
     */
    public function getTypeService()
    {
        return $this->_typeService;
    }
    
    /**
     * Sets the account service
     * 
     * @param \Application_Service_Account $accountService
     * @return Application_Form_Transaction 
     */
    public function setAccountService(\Application_Service_Account $accountService)
    {
        $this->_accountService = $accountService;
        return $this;
    }

    /**
     * Gets the account service
     * 
     * @return Application_Service_Account
     */
    public function getAccountService()
    {
        return $this->_accountService;
    }

    /**
     * Sets the category service
     * 
     * @param \Application_Service_TransactionCategory $categoryService
     * @return Application_Form_Transaction
     */
    public function setCategoryService(\Application_Service_TransactionCategory $categoryService)
    {
        $this->_categoryService = $categoryService;
        return $this;
    }

    /**
     * Gets the category service
     * 
     * @return Application_Service_TransactionCategory
     */
    public function getCategoryService()
    {
        return $this->_categoryService;
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
            'category'  => $transaction->getCategory()->getId(),
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
     * Creates the category dropdown field
     *
     * @param array $categoryOptions
     * @return Zend_Form_Element_Select
     */
    private function _createCategoryDropDown(array $categoryOptions)
    {
        $category = new Zend_Form_Element_Select('category');
        $category->setLabel('transactionCategory')
            ->setMultiOptions($categoryOptions)
            ->setRequired();

       return $category;
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
