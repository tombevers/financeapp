<?php

class Application_Form_Bank extends Zend_Form
{
    public function init()
    {
        $id = $this->_createHiddenIdField();
        $name = $this->_createNameField();
        $address = $this->_createAddressField();
        $website = $this->_createWebsiteField();
        $comment = $this->_createCommentField();
        $submit = $this->_createSubmitButton();

        $this->addElements(array(
                $id,
                $name,
                $address,
                $website,
                $comment,
                $submit
        ));
    }

    public function setDefaultsFromEntity(\App\Entity\Bank $bank)
    {
        $values = array(
            'id'        => $bank->getId(),
            'name'      => $bank->getName(),
            'address'   => $bank->getAddress(),
            'website'   => $bank->getWebsite(),
            'comment'   => $bank->getComment(),
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
     * Creates the website field
     * 
     * @return Zend_Form_Element_Text
     */
    private function _createWebsiteField()
    {
        $website = new Zend_Form_Element_Text('website');
        $website->setLabel('Website')
            ->addValidator(new \App\Validate\Url());
        return $website;
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
