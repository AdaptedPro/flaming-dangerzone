<?php
namespace Rover\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Rover\Model\Rover;
use Rover\Form\RoverForm;

class RoverController extends AbstractActionController
{
	protected $roverTable;
	
    public function indexAction()
    {
         return new ViewModel(array(
             'rovers' => $this->getRoverTable()->fetchAll(),
         ));
    }
    
    /*
    public function addAction()
    {
    	$form = new RoverForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$rover = new Rover();
    		$form->setInputFilter($rover->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$rover->exchangeArray($form->getData());
    			$this->getRoverTable()->saveRover($rover);
    	
    			// Redirect to list of rovers
    			return $this->redirect()->toRoute('rover');
    		}
    	}
    	return array('form' => $form);    	
    }

    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('rover', array(
    				'action' => 'add'
    		));
    	}
    	
    	// Get the Rover with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
    	try {
    		$rover = $this->getRoverTable()->getRover($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('rover', array(
    				'action' => 'index'
    		));
    	}
    	
    	$form  = new RoverForm();
    	$form->bind($rover);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($rover->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$this->getRoverTable()->saveRover($rover);
    	
    			// Redirect to list of rovers
    			return $this->redirect()->toRoute('rover');
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
    		return $this->redirect()->toRoute('rover');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getRoverTable()->deleteRover($id);
    		}
    	
    		// Redirect to list of rovers
    		return $this->redirect()->toRoute('rover');
    	}
    	
    	return array(
    			'id'    => $id,
    			'rover' => $this->getRoverTable()->getRover($id)
    	);    	
    }
    */
    
    public function getRoverTable()
    {
    	if (!$this->roverTable) {
    		$sm = $this->getServiceLocator();
    		$this->roverTable = $sm->get('Rover\Model\RoverTable');
    	}
    	return $this->roverTable;
    }    
}