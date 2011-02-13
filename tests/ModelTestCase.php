<?php

class ModelTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Bisna\Application\Container\DoctrineContainer
     */
    protected $_doctrineContainer;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    protected function setUp()
    {
        global $application;
        $application->bootstrap();
        $this->_doctrineContainer = Zend_Registry::get('doctrine');
        $this->_em = $this->_doctrineContainer->getEntityManager();
        self::_dropSchema($this->_doctrineContainer->getConnection()->getParams());

        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->_doctrineContainer->getEntityManager());
        $metas = $this->_getClassMetas(APPLICATION_PATH . '/../library/App/Entity','App\Entity\\');
        $tool->createSchema($metas);
    }

    protected function tearDown()
    {
        self::_dropSchema($this->_doctrineContainer->getConnection()->getParams());
    }

    private static function _dropSchema($params)
    {
        if (file_exists($params['path'])) {
            unlink ($params['path']);
        }
    }

    private function _getClassMetas($path, $namespace)
    {
        $metas = array();
        $handle = opendir($path);
        if ($handle) {
            while(false !== ($file = readdir($handle))) {
                if(strstr($file,'.php')) {
                    list($class) = explode('.',$file);
                    $metas[] = $this->_doctrineContainer->getEntityManager()->getClassMetadata($namespace . $class);
                }
            }
        }
        return $metas;
    }
}
