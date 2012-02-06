<?php

namespace App;

class Form extends \Zend_Form
{
    public function init()
    {
        $decorator = new Form\Decorator();
        $decorator->setFormDecorator($this);
        $this->addDecorator(
            new Form\Decorator\FormErrors(
                array(
                    'placement' => \Zend_Form_Decorator_Abstract::PREPEND,
                    'message'   => 'actionErrorsOccured',
                )
            )
        );
    }
    
    /**
     * Validates the data and build the error decorators
     *
     * @param  array $data
     * @return boolean
     */
    public function isValid($values)
    {
        $validCheck = parent::isValid($values);
        if ($validCheck === FALSE) {
            $this->buildErrorDecorators();
        }
        return $validCheck;
    }

    /**
     * Build Error Decorators
     */
    public function buildErrorDecorators()
    {
        foreach ($this->getErrors() as $key => $errors) {
            $htmlTagDecorator = $this->getElement($key)->getDecorator('HtmlTag');
            if (empty($htmlTagDecorator)) {
                continue;
            }
            if (empty($errors)) {
                continue;
            }
            $class = $htmlTagDecorator->getOption('class');
            $htmlTagDecorator->setOption('class', $class . ' error');
        }
    }
}
