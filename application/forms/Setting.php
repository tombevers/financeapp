<?php

class Application_Form_Setting extends \App\Form
{
    /**
     * @var \Application_Service_Setting
     */
    protected $_settingService;
    
    public function init()
    {
        $settingService = $this->getSettingService();
        $currencyOptions = $settingService->createCurrencyOptions();        
        
        $this->addElements(
            array(
                $this->_createCurrencyDropDown($currencyOptions),
                $this->_createSubmitButton()
            )
        );
        
        parent::init();
    }

    /**
     * Sets the setting service
     * 
     * @param \Application_Service_Setting $settingService
     * @return Application_Form_Setting 
     */
    public function setSettingService(\Application_Service_Setting $settingService)
    {
        $this->_settingService = $settingService;
        return $this;
    }
    
    /**
     * Gets the bank service
     * 
     * @return \Application_Service_Setting
     */
    public function getSettingService() 
    { 
        return $this->_settingService;
    }
    
    /**
     * Set defaults from entities
     *
     * @param array[\App\Entity\Setting] $settings
     */
    public function setDefaultsFromEntities(array $settings)
    {
        $values = array();
        foreach ($settings as $setting) {
            $values[$setting->getParameter()] = $setting->getValue();
        }
        
        $this->setDefaults($values);
    }    

    /**
     * Creates the currency dropdown field
     *
     * @param array $options
     * @return Zend_Form_Element_Select
     */
    private function _createCurrencyDropDown($options)
    {
        $currencies = new Zend_Form_Element_Select('currency');
        $currencies->setLabel('settingCurrency')
            ->setMultiOptions($options)
            ->setRequired();

       return $currencies;
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
