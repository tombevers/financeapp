<?php

class SettingTest extends ModelTestCase
{
    public function testCanSaveSetting()
    {
        $parameterStub = 'foo';
        $valueStub = 'bar';
        
        $setting = new App\Entity\Setting($parameterStub, $valueStub);

        $this->_em->persist($setting);
        $this->_em->flush();

        $result = $this->_em->createQuery('SELECT s FROM \App\Entity\Setting s')
            ->getSingleResult();
        
        $this->assertEquals($parameterStub, $result->getParameter());
        $this->assertEquals($valueStub, $result->getValue());
    }
}
