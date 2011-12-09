<?php

class Application_Form_ScheduledTransaction extends Zend_Form
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
                $this->_createFrequencyDropDown(),
                $this->_createNextDateField(),
                $this->_createContinuousRadioButton(),
                $this->_createNumberField(),
                $this->_createActiveCheckbox(),
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
     * @param \App\Entity\ScheduledTransaction $transaction
     */
    public function setDefaultsFromEntity(\App\Entity\ScheduledTransaction $transaction)
    {
        $values = array(
            'id'            => $transaction->getId(),
            'type'          => $transaction->getType()->getId(),
            'account'       => $transaction->getAccount()->getId(),
            'amount'        => $transaction->getAmount(),
            'category'      => $transaction->getCategory()->getId(),
            'frequency'     => $transaction->getFrequency(),
            'nextDate'      => $transaction->getNextDate()->format('Y-m-d'),
            'continuous'    => $transaction->getContinuous(),
            'number'        => $transaction->getNumber(),
            'active'        => $transaction->getActive(),
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
     * Creates the frequency dropdown field
     * 
     * @return Zend_Form_Element_Select 
     */
    private function _createFrequencyDropDown()
    {
        // @todo translate frequency options
        $options = array(
            0 => 'One time',
            1 => 'Every day',
            2 => 'Every week',
            3 => 'Every two weeks',
            4 => 'Every four weeks',
            5 => 'Monthly',
            6 => 'Every two months',
            7 => 'Quarterly',
            8 => 'Every six months',
            9 => 'Annually',
        );
        
        $frequency = new Zend_Form_Element_Select('frequency');
        $frequency->setLabel('scheduledTransactionFrequency')
            ->setMultiOptions($options)
            ->setRequired();

        return $frequency;
    }
    
    /**
     * Creates the date field
     *
     * @return Zend_Form_Element_Text
     */
    private function _createNextDateField()
    {
        $date = new ZendX_JQuery_Form_Element_DatePicker('nextDate');
        $date->setLabel('scheduledTransactionNextDate')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_Date())
            ->setRequired()
            ->setJQueryParam('dateFormat', 'yy-mm-dd');

        return $date;
    }
    
    /**
     * Creates the continuous radio button
     * 
     * @return Zend_Form_Element_Radio 
     */
    private function _createContinuousRadioButton()
    {
        $options = array(
            1 => 'scheduledTransactionContinuous',
            0 => 'scheduledTransactionNumbered',
        );
        $continuous = new Zend_Form_Element_Radio('continuous');
        $continuous->setMultiOptions($options)
            ->setValue(1);
        
        return $continuous;
    }
    
    /**
     * Creates the number field
     * 
     * @return Zend_Form_Element_Text 
     */
    private function _createNumberField()
    {
        $number = new Zend_Form_Element_Text('number');
        $number->setLabel('scheduledTransactionNumber')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_Int());
        
        return $number;
    }
    
    /**
     * Creates the active checkbox
     * 
     * @return Zend_Form_Element_Checkbox 
     */
    private function _createActiveCheckbox()
    {
        $active = new Zend_Form_Element_Checkbox('active');
        $active->setLabel('scheduledTransactionActive');
        
        return $active;
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
