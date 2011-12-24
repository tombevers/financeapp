<?php

class Application_Form_TransactionCategory extends \App\Form
{
    /**
     * @var \Application_Service_TransactionCategory
     */
    protected $_categoryService;
    
    public function init()
    {
        $categoryService = $this->getCategoryService();
        
        $this->addElements(
            array(
                $this->_createHiddenIdField(),
                $this->_createParentDropDown($categoryService->createOptions(TRUE, FALSE)),
                $this->_createNameField(),
                $this->_createSubmitButton()
            )
        );
        
        parent::init();
    }
    
    /**
     * Sets the transaction category service
     * 
     * @param \Application_Service_TransactionType $categoryService
     * @return Application_Form_Transaction
     */
    public function setCategoryService(\Application_Service_TransactionCategory $categoryService)
    {
        $this->_categoryService = $categoryService;
        return $this;
    }
    
    /**
     * Gets the transaction category service
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
     * @param \App\Entity\TransactionCategory $category
     */
    public function setDefaultsFromEntity(\App\Entity\TransactionCategory $category)
    {
        $values = array(
            'id'        => $category->getId(),
            'name'      => $category->getName()
        );
        
        if (!is_null($category->getParent())) {
            $values['parent'] = $category->getParent()->getId();
        }

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
        $ammount = new Zend_Form_Element_Text('name');
        $ammount->setLabel('transactionCategoryName')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addFilter(new Zend_Filter_StripTags())
            ->setRequired();

        return $ammount;
    }

    /**
     * Creates the parent category dropdown field
     *
     * @param array $categoryOptions
     * @return Zend_Form_Element_Select
     */
    private function _createParentDropDown(array $categoryOptions)
    {
        $parent = new Zend_Form_Element_Select('parent');
        $parent->setLabel('transactionCategoryParent')
            ->setMultiOptions($categoryOptions)
            ->setRequired();

       return $parent;
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
