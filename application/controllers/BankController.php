<?php

class BankController extends Zend_Controller_Action
{
	/**
	 * @var Bisna\Application\Container\DoctrineContainer
	 */
    protected $_doctrineContiainer;

    /**
	 * @var Doctrine\ORM\EntityManager
	 */
    protected $_entityManager;
    
    /**
     * @var App\Entity\Repository\BankRepository
     */
    protected $_bankRepository;
    
    public function init()
    {
        $this->_doctrineContainer = Zend_Registry::get('doctrine');
        $this->_entityManager = $this->_doctrineContainer->getEntityManager();
        $this->_bankRepository = $this->_entityManager->getRepository('\App\Entity\Bank');
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $banks = $this->_bankRepository->findAll();
        $this->view->banks = $banks;
    }

    public function addAction()
    {
        $form = new Application_Form_Bank();
        $this->view->form = $form;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $bank = new App\Entity\Bank();
                $this->_bankRepository->saveBank($bank, $form->getValues());
                $this->_entityManager->flush();
                
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $form = new Application_Form_Bank();
        
        
        if ($id === NULL) {
            throw new Exception('Id must be provided for the edit action');
        }

        $bank = $this->_bankRepository->find($id);

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_bankRepository->saveBank($bank, $form->getValues());
                $this->_entityManager->flush();

                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
            $form->setDefaultsFromEntity($bank);
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');

        if ($id === NULL) {
            throw new Exception('Id must be provided for the delete action');
        }

        $this->_bankRepository->removeBank($id);
        $this->_entityManager->flush();

        $this->_helper->_redirector('list');
    }
}
