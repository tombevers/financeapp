<?php

namespace App\Controller\Plugin;

class Currency extends \Zend_Controller_Plugin_Abstract
{
    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {
        $this->_initCurrency();
    }
    
    /**
     * Initalize currency
     */
    protected function _initCurrency()
    {
        $settingService = \App\ServiceLocator::getSettingService();
        $setting = $settingService->fetchByParameter('currency');
        
        $currency = new \Zend_Currency();
        $format = array(
            'currency' => $setting->getValue(),
            'name' => $setting->getValue(),
            'symbol' => $settingService->getCurrenySymbol($setting->getValue())
        );
        $currency->setFormat($format);
          
        \Zend_Registry::set('Zend_Currency', $currency);
    }
}