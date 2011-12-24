<?php

class Application_Form_Account extends \App\Form
{
    /**
     * @var \Application_Service_Bank
     */
    protected $_bankService;
    
    /**
     * @var \Application_Service_AccountType
     */
    protected $_typeService;

    public function init()
    {
        $typeService = $this->getTypeService();
        $typeOptions = $typeService->createOptions();

        $bankService = $this->getBankService();
        $bankOptions = $bankService->createOptions();

        $this->addElements(
            array(
                $this->_createHiddenIdField(),
                $this->_createTypesDropDown($typeOptions),
                $this->_createNameField(),
                $this->_createNumberField(),
                $this->_createBankDropDown($bankOptions),
                $this->_createCommentField(),
                $this->_createSubmitButton()
            )
        );
        
        parent::init();
    }

    /**
     * Sets the bank service
     * 
     * @param \Application_Service_Bank $bankService
     * @return Application_Form_Account 
     */
    public function setBankService(\Application_Service_Bank $bankService)
    {
        $this->_bankService = $bankService;
        return $this;
    }
    
    /**
     * Gets the bank service
     * 
     * @return \Application_Service_Bank
     */
    public function getBankService() 
    { 
        return $this->_bankService;
    }

    /**
     * Sets the account type service
     * 
     * @param \Application_Service_AccountType $typeService 
     */
    public function setTypeService(\Application_Service_AccountType $typeService)
    {
        $this->_typeService = $typeService;
    }
    
    /**
     * Gets the account type service
     * 
     * @return \Application_Service_AccountType
     */
    public function getTypeService()
    {
        return $this->_typeService;
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
