<?php

class Bootstrap extends App\Application\Bootstrap\Bootstrap
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
    protected function _initView()
    {
        $resources = $this->getOption('resources');
        $options = array();
        if (isset($resources['view'])) {
            $options = $resources['view'];
        }
        $view = new Zend_View($options);

        if (isset($options['doctype'])) {
            $view->doctype()->setDoctype(strtoupper($options['doctype']));
            if (isset($options['charset']) && $view->doctype()->isHtml5()) {
                $view->headMeta()->setCharset($options['charset']);
            }
        }
        if (isset($options['contentType'])) {
            $view->headMeta()->appendHttpEquiv(
                'Content-Type',
                $options['contentType']
            );
        }

        $view->headTitle()->setSeparator(' - ');
        $view->headTitle('financeapp');

        $view->headLink()->appendStylesheet('/css/screen.css');

        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

        Zend_Registry::set('view', $view);
        return $view;
    }
    
    protected function _initDoctrine()
    {
        $config = $this->getContainer()->get('doctrine.configuration');
        $driverImpl = $config->newDefaultAnnotationDriver($this->getContainer()->getParameter('doctrine.entity.path'));
        $config->setMetadataDriverImpl($driverImpl);
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

    /**
     * Init nested layout
     */
    protected function _initNestedLayout()
    {
        $this->bootstrap('layout');
        // @var $layout Zend_Layout
        $layout = $this->getResource('layout');
        // Set default layouts
        $layout->assign('nestedLayout', 'default');
        $layout->assign('variation', 'variation/default');
    }

    /**
     * Initalize currency
     */
    protected function _initCurrency()
    {
        Zend_Registry::set('Zend_Currency', new Zend_Currency('nl_BE'));
    }
}
