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
     * Set the error reporting in development environment
     */
    protected function _initConfiguration()
    {
        if (APPLICATION_ENV == 'development') {
            error_reporting(E_ALL | E_STRICT);
        }
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

    /**
     * Init Translations
     */
    public function _initTranslate()
    {
        $translate = new Zend_Translate(
                array(
                    'adapter' => Zend_Translate::AN_ARRAY,
                    'content' => APPLICATION_PATH . '/../languages/en.php',
                    'locale' => 'en',
                    'scan' => Zend_Translate::LOCALE_DIRECTORY,
                )
        );

        Zend_Registry::set('Zend_Translate', $translate);
    }

}
