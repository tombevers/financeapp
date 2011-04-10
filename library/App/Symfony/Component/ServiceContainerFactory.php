<?php
namespace App\Symfony\Component;
use Symfony\Component\DependencyInjection;
use Symfony\Component\Config\FileLocator;

class ServiceContainerFactory
{
    protected static $_container;

    public static function getContainer(array $options)
    {
        self::$_container = new DependencyInjection\ContainerBuilder();
        foreach ($options['configFiles'] as $file) {
            self::_loadConfigFile($file);
        }

        return self::$_container;
    }

    protected static function _loadConfigFile($file)
    {
        $suffix = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $loader = null;
        switch ($suffix) {
            case 'ini':
                $loader = new DependencyInjection\Loader\IniFileLoader(
                    self::$_container,
                    new \Symfony\Component\Config\FileLocator()
                );
                break;
            case 'php':
                $loader = new DependencyInjection\Loader\PhpFileLoader(
                    self::$_container,
                    new \Symfony\Component\Config\FileLocator()
                );
                break;
            case 'xml':
                $loader = new DependencyInjection\Loader\XmlFileLoader(
                    self::$_container,
                    new \Symfony\Component\Config\FileLocator()
                );
                break;
            case 'yml':
                $loader = new DependencyInjection\Loader\YamlFileLoader(
                    self::$_container,
                    new \Symfony\Component\Config\FileLocator()
                );
                break;
          default:
                throw new \App\Exception(
                    "Invalid configuration file provided;" .
                    " unknown config type '$suffix'"
                );
        }
        $loader->load($file);
    }
}
