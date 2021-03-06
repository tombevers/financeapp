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
        $extension = self::_getExtension($file);
        $loader = self::_getLoader($extension);
        $loader->load($file);
    }

    private static function _getExtension($file)
    {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION));
    }

    protected static function _getLoader($extension)
    {
        $loader = NULL;
        switch ($extension) {
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
            default:
                throw new \App\Exception(
                    "Invalid configuration file provided;" .
                    " unknown config type '$extension'"
                );
        }
        return $loader;
    }
}
