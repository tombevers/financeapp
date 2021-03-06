<?php

namespace App\Form\Decorator;

class FormErrors extends \Zend_Form_Decorator_Abstract
{
     /**
      * Renders the form errors
      *
      * @param string $content content of the form
      * @return string $content content of the form with the error messages
      */
    public function render($content)
    {
        $form = $this->getElement();
        if (!$form instanceof \Zend_Form) {
            return $content;
        }

        $message = $this->getOption('message');
        if (empty($message)) {
            $message = '';
        }

        $view = $form->getView();
        if (NULL === $view) {
            return $content;
        }

        $errors  = $form->getMessages();
        if (empty($errors)) {
            return $content;
        }

        $markup = '<div class="alert alert-message alert-error">';
        $markup .= '<a class="close" data-dismiss="alert" href="#">×</a>';

        if (!empty($message)) {
            $translator = $form->getTranslator();
            $markup .= '<p><strong>' . $translator->translate($message) . '</strong></p>';
        }
        $markup .= '<ul>';

        $markup = $this->_addErrorMessages($markup, $errors, $form, $view);

        $markup .= '</ul>';
        $markup .= '</div>';

        switch ($this->getPlacement()) {
            case self::APPEND:
                $content = $content . $this->getSeparator() . $markup;
            case self::PREPEND:
                $content = $markup . $this->getSeparator() . $content;
        }
        return $content;
    }
    
    /**
     * Add the error messages
     * 
     * @param string $markup
     * @param array $errors
     * @param \Zend_Form $form
     * @param string $view
     * @return string 
     */
    private function _addErrorMessages($markup, array $errors, \Zend_Form $form, $view)
    {
        foreach ($errors as $name => $list) {
            $element = $form->$name;

            if ($element instanceof \Zend_Form_Element) {
                $label = $element->getLabel();
                if (empty($label)) {
                    $label = $element->getName();
                }
                $label = trim($label);

                $errorMessage = '';
                foreach ($list as $error) {
                    $errorMessage = $view->escape($error);
                    break; // just do the first error message for a field
                }

                $markup .= '<li>' . $label . '&nbsp;' . $errorMessage . '</li>';
            } else if ($element instanceof Zend_Form) {
                foreach ($list as $label => $error) {
                    foreach ($error as $message) {
                        $markup .= '<li>' . ucfirst($label) . '&nbsp;';
                        $markup .= strtolower($view->escape($message));
                        $markup .= '</li>';
                        break; // just do the first error message for a field
                    }
                }
            } else if (is_string($list)) {
                $markup .= '<li>' . $list . '</li>';
            }
        }        
        
        return $markup;
    }
}
