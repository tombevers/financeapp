<?php

class SettingController extends Zend_Controller_Action
{
    /**
	 * @var Application_Service_AccountType
	 */
    private $_settingService;

    public function init()
    {       
        $this->_settingService = \App\ServiceLocator::getSettingService();
    }

    public function indexAction()
    {
        $this->_forward('update');
    }
    
    public function updateAction()
    {
        $this->view->pageTitle = $this->view->translate('settingsTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        $request = $this->getRequest();
        $form = new Application_Form_Setting(
            array(
                'settingService' => $this->_settingService,
            )
        );
        
        $settings = $this->_settingService->fetchAll();

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_settingService->saveSettings(
                    $form->getValues()
                );

                $this->_helper->flashMessenger->addMessage(
                    array('success' => 'saveSettingsMessage')
                );
                $this->_helper->_redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $form->setDefaultsFromEntities($settings);
        }

        $this->view->form = $form;
    }
}
