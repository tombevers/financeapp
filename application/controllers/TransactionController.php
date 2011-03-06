<?php

class TransactionController extends Zend_Controller_Action
{
    /**
	 * @var Application_Service_Transaction
	 */
    private $_transactionService;
    
    public function init()
    {
        $this->_transactionService = 
            \App\ServiceLocator::getTransactionService();
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $this->view->transactions = $this->_transactionService->fetchAll();
    }

    public function addAction()
    {
        $form = new Application_Form_Transaction();
        $this->view->form = $form;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_transactionService->saveTransaction(
                    new App\Entity\Transaction(),
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
        $transactionId = $request->getParam('id');
        $form = new Application_Form_Transaction();
        
        if ($transactionId === NULL) {
            throw new Exception('Id must be provided for the edit action');
        }

        $transaction = $this->_transactionService->fetchById($transactionId);

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_transactionService->savePayee(
                    $transaction,
                    $form->getValues()
                );
                
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
            $form->setDefaultsFromEntity($transaction);
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $transactionId = $request->getParam('id');

        if ($transactionId === NULL) {
            throw new Exception('Id must be provided for the delete action');
        }

        $this->_transactionService->removeById($transactionId);

        $this->_helper->_redirector('list');
    }
}
