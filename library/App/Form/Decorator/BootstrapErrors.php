<?php

namespace App\Form\Decorator;

class BootstrapErrors extends \Zend_Form_Decorator_HtmlTag
{
    /**
     * Render content wrapped in an HTML tag
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (NULL === $view) {
            return $content;
        }

        $errors = $element->getMessages();
        if (empty($errors)) {
            return $content;
        }

        // Add error class to the HtmlTag of the element
        $htmlTag = $element->getDecorator('HtmlTag');
        $htmlTag->setOption('class', 'clearfix error');
        
        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $formErrorHelper = $view->getHelper('formErrors');
        $formErrorHelper->setElementStart('<span%s>')
            ->setElementSeparator('<br />')
            ->setElementEnd('</span>');
        $errors = $formErrorHelper->formErrors($errors, array('class' => 'help-block'));

        switch ($placement) {
            case 'PREPEND':
                return $errors . $separator . $content;
            case 'APPEND':
            default:
                return $content . $separator . $errors;
        }
    }
}
