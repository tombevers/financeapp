<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Config data
     * 
     * @var Zend_Config
     */
    protected $_config;

    /**
     * Load configuration and add to the registry
     */
    protected function _initConfig()
    {
        $this->_config = $this->getOptions();
        Zend_Registry::set('config', new Zend_Config($this->_config));
    }

    /**
     * Init the doctype
     */
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
    }
}

