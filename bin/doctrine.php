<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment, (I am only running this in development)
define('APPLICATION_ENV', 'development');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Creating application
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// Bootstrapping resources
$bootstrap = $application->bootstrap()->getBootstrap();
// Symfony dependency injection container
$container = $bootstrap->getContainer();

// Retrieve entity manager from container
$entityManager = $container->get('doctrine.entitymanager');

// Console
$cli = new \Symfony\Component\Console\Application(
    'Doctrine Command Line Interface',
    \Doctrine\Common\Version::VERSION
);

try {
    // Bootstrapping Console HelperSet
    $helperSet = array();

    if ($entityManager->getConnection() !== null) {
        $helperSet['db'] = new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper(
            $entityManager->getConnection()
        );
    }

    if ($entityManager !== null) {
        $helperSet['em'] = new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
            $entityManager
        );
    }
} catch (\Exception $exc) {
    $cli->renderException(
        $exc,
        new \Symfony\Component\Console\Output\ConsoleOutput()
    );
}

$cli->setCatchExceptions(true);
$cli->setHelperSet(new \Symfony\Component\Console\Helper\HelperSet($helperSet));

$cli->addCommands(array(
    // DBAL Commands
    new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
    new \Doctrine\DBAL\Tools\Console\Command\ImportCommand(),

    // ORM Commands
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
    new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
    new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),

));

$cli->run();
