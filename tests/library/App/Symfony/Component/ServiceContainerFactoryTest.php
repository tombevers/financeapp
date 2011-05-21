<?php

class ServiceContainerFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $_containerFactory;

    public function setUp()
    {
        $this->_containerFactory =
            new App\Symfony\Component\ServiceContainerFactory();
    }

    public static function fileProvider()
    {
        return array(
            array('foo.ini', 'ini'),
            array('foo.xml', 'xml'),
            array('foo.php', 'php'),
            array('foo.yml', 'yml'),
            array('foo.bar', 'bar'),
        );
    }

    /**
     * @dataProvider fileProvider
     */
    public function testGetExtension($file, $extension)
    {
        $getExtension = Helpers::getMethod(
            'App\Symfony\Component\ServiceContainerFactory',
            '_getExtension'
        );

        $this->assertEquals(
            $extension,
            $getExtension->invokeArgs($this->_containerFactory, array($file))
        );
    }

    /**
     * @expectedException \App\Exception
     */
    public function testGetNotExistingLoader()
    {
        $getLoader = Helpers::getMethod(
            'App\Symfony\Component\ServiceContainerFactory',
            '_getLoader'
        );

        $getLoader->invokeArgs(
            $this->_containerFactory,
            array('foo')
        );
    }
}
