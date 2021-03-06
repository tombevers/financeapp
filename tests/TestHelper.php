<?php

error_reporting(E_ALL | E_STRICT);

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
define('APPLICATION_ENV', 'testing');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path()
)));

/** Zend_Application */
require_once 'Zend/Application.php';
/** Zend_Controller_Test_Case */
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';
/** Include Helper Class */
require_once 'Helpers.php';
/** Parent test case classes */
require_once 'ModelTestCase.php';
require_once 'ControllerTestCase.php';
require_once 'AbstractManagerBase.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

clearstatcache();
