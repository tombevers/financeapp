<?php

class Helpers
{
    /**
     * This method will make protected or private method accessible so we can test them.
     *
     * @param string $className
     * @param string $methodName
     * @return object
     */
    public static function getMethod($className, $methodName)
    {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }
}
