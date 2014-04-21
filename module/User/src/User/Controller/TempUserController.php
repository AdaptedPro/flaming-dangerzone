<?php
namespace TempUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use TempUser\Model\TempUser;
use TempUser\Form\TempUserForm;

class TempUserController extends AbstractActionController
{
	protected $tempUserTable;
	
    public function indexAction()
    {
         return new ViewModel(array(
             'temp_users' => $this->getTempUserTable()->fetchAll(),
         ));
    }

    public function addAction()
    {
    	$form = new TempUserForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$user = new TempUser();
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$user->exchangeArray($form->getData());
    			$this->getTempUserTable()->saveTempUser($user);
    	
    			// Redirect to list of users
    			return $this->redirect()->toRoute('user');
    		}
    	}
    	return array('form' => $form);    	
    }

    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('user', array(
    				'action' => 'add'
    		));
    	}
    	
    	// Get the TempUser with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
    	try {
    		$user = $this->getTempUserTable()->getTempUser($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('user', array(
    				'action' => 'index'
    		));
    	}
    	
    	$form  = new TempUserForm();
    	$form->bind($user);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$this->getTempUserTable()->saveTempUser($user);
    	
    			// Redirect to list of users
    			return $this->redirect()->toRoute('user');
    		}
    	}
    	
    	return array(
    			'id' => $id,
    			'form' => $form,
    	);    	
    }

    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('user');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getTempUserTable()->deleteTempUser($id);
    		}
    	
    		// Redirect to list of users
    		return $this->redirect()->toRoute('user');
    	}
    	
    	return array(
    			'id'    => $id,
    			'user' => $this->getTempUserTable()->getTempUser($id)
    	);    	
    }
    
    public function getTempUserTable()
    {
    	if (!$this->tempUserTable) {
    		$sm = $this->getServiceLocator();
    		$this->tempUserTable = $sm->get('User\Model\TempUserTable');
    	}
    	return $this->tempUserTable;
    }  
}