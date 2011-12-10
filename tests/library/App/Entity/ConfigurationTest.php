<?php

class ConfigurationTest extends ModelTestCase
{
    public function testCanSaveConfiguration()
    {
        $parameterStub = 'foo';
        $valueStub = 'bar';
        
        $configuration = new App\Entity\Configuration($parameterStub, $valueStub);

        $this->_em->persist($configuration);
        $this->_em->flush();

        $result = $this->_em->createQuery('SELECT c FROM \App\Entity\Configuration c')
            ->getSingleResult();
        
        $this->assertEquals($parameterStub, $result->getParameter());
        $this->assertEquals($valueStub, $result->getValue());
    }
}
