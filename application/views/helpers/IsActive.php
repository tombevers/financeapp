<?php

class Zend_View_Helper_IsActive extends Zend_View_Helper_Abstract
{   
    public function isActive($controller)
    {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        
        if ($controller == $request->getControllerName()) {
            return TRUE;
        }
        
        return FALSE;
    }
}
