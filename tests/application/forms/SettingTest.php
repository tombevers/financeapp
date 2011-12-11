<?php

class Application_Form_SettingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application_Form_Setting
     */
    protected $_form;

    public function setUp()
    {
        $this->_form = new Application_Form_Setting(
            array(
                'settingService' => App\ServiceLocator::getSettingService()
            )
        );
    }

    public function testSetDefaultsFromEntities()
    {
        $parameterStub = 'currency';
        $valueStub = 'EUR';
        
        $setting = new App\Entity\Setting($parameterStub, $valueStub);
        $settings = array($setting);

        $this->_form->setDefaultsFromEntities($settings);
        $values = $this->_form->getValues();

        $this->assertEquals($valueStub, $values[$parameterStub]);
    }
}
