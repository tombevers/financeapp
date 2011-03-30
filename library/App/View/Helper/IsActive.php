<?php

namespace App\View\Helper;

class IsActive extends \Zend_View_Helper_Abstract
{
    public function isActive($controller = NULL)
    {
        $request = \Zend_Controller_Front::getInstance()->getRequest();

        if ($controller == $request->getControllerName()) {
            return TRUE;
        }

        return FALSE;
    }
}
