<?php
namespace App\Application\Bootstrap;
use Symfony\Component\DependencyInjection;
use App\Symfony\Component\ServiceContainerFactory;
use App\Controller\Action\Helper\ServiceContainer;

class Bootstrap extends \Zend_Application_Bootstrap_Bootstrap
{
    public function getContainer()
    {
        $options = $this->getOption('bootstrap');

        if (NULL === $this->_container
            && $options['container']['type'] == 'symfony') {
            $container = NULL;
            $name = 'Container'.md5($this->getEnvironment()).'ServiceContainer';
            $file = APPLICATION_PATH . '/../data/cache/'.$name.'.php';
            if ($this->getEnvironment() !== ('development' || 'testing')
                && file_exists($file)) {
                require_once $file;
                $container = new $name();
            } else {
                $container = ServiceContainerFactory::getContainer(
                    $options['container']
                );
                if ($this->getEnvironment() !== ('development' || 'testing')) {
                    $dumper = new DependencyInjection\Dumper\PhpDumper(
                        $container
                    );
                    file_put_contents(
                        $file,
                        $dumper->dump(array('class' => $name))
                    );
                }
            }
            $this->_container = $container;
            \Zend_Controller_Action_HelperBroker::addHelper(
                new ServiceContainer()
            );
        }
        return parent::getContainer();
    }
}
