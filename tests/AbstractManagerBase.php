<?php

class AbstractManagerBase extends \PHPUnit_Framework_TestCase
{
    protected function getEmMock()
    {
        $emMock = $this->getMock(
            '\Doctrine\ORM\EntityManager',
            array(
                'persist',
                'flush',
                'remove',
                'clear',
                'refresh',
                'getClassMetadata',
            ),
            array(),
            '',
            FALSE
        );
        $emMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(NULL));
        $emMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(NULL));
        $emMock->expects($this->any())
            ->method('remove')
            ->will($this->returnValue(NULL));
        $emMock->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(NULL));
        $emMock->expects($this->any())
            ->method('refresh')
            ->will($this->returnValue(NULL));        
        $emMock->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue((object) array('name' => 'aClass')));

        return $emMock;
     }
}
