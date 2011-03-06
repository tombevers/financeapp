<?php

class PayeeController extends Zend_Controller_Action
{
	/**
	 * @var Application_Service_Payee
	 */
    private $_payeeService;
    
    public function init()
    {
        $this->_payeeService = \App\ServiceLocator::getPayeeService();
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $this->view->payees = $this->_payeeService->fetchAll();
    }

    public function addAction()
    {
        $form = new Application_Form_Payee();
        $this->view->form = $form;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_payeeService->savePayee(
                    new App\Entity\Payee(),
                    $form->getValues()
                );
                
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $payeeId = $request->getParam('id');
        $form = new Application_Form_Payee();
        
        if ($payeeId === NULL) {
            throw new Exception('Id must be provided for the edit action');
        }

        $payee = $this->_payeeService->fetchById($payeeId);

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_payeeService->savePayee($payee, $form->getValues());
                
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
            $form->setDefaultsFromEntity($payee);
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $payeeId = $request->getParam('id');

        if ($payeeId === NULL) {
            throw new Exception('Id must be provided for the delete action');
        }

        $this->_payeeService->removeById($payeeId);

        $this->_helper->_redirector('list');
    }

}
