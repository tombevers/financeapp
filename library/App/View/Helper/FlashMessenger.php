<?php

namespace App\View\Helper;

class FlashMessenger extends \Zend_View_Helper_Abstract
{
    public function flashMessenger()
    {
        $messages = \Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getMessages();
        $output = '';

        if (!empty($messages)) {
            $format = '<div class="alert-message %s" data-alert="alert">' . PHP_EOL;
            $format .= '<a class="close" href="#">×</a>' . PHP_EOL;
            $format .= '<p>%s</p>' . PHP_EOL;
            $format .= '</div>' . PHP_EOL;
            
            foreach ($messages as $message) {
                $classes = array('success', 'warning', 'error', 'info');
                $class = 'warning';
                if (is_string(key($message)) && in_array(key($message), $classes)) {
                    $class = key($message);
                }
                $output .= sprintf(
                    $format,
                    $class,
                    $this->view->escape($this->view->translate(current($message)))
                );
            }
        }

        return $output;
    }
}
