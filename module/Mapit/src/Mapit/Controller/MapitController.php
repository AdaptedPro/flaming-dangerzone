<?php
namespace Mapit\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Mapit\Model\Mapit;
use Mapit\Form\MapitForm;

class MapitController extends AbstractActionController
{
	protected $mapitTable;
	protected $googleMapsKey;
		
    public function indexAction()
    {
    	$googleMaps_info = $this->getGoogleMapsInfo();
    	$this->googleMapsKey = $googleMaps_info['api_key'];
    	return new ViewModel(array(
             //'mapit' => $this->getMapitTable()->fetchAll(),
             'api_key' => $this->googleMapsKey,
         ));
    }

    public function addAction()
    {
    	$form = new MapitForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$mapit = new Mapit();
    		$form->setInputFilter($mapit->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$mapit->exchangeArray($form->getData());
    			$this->getMapitTable()->saveMapit($mapit);
    	
    			// Redirect to list of mapits
    			return $this->redirect()->toRoute('mapit');
    		}
    	}
    	return array('form' => $form);    	
    }

    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('mapit', array(
    				'action' => 'add'
    		));
    	}
    	
    	// Get the Mapit with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
    	try {
    		$mapit = $this->getMapitTable()->getMapit($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('mapit', array(
    				'action' => 'index'
    		));
    	}
    	
    	$form  = new MapitForm();
    	$form->bind($mapit);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($mapit->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$this->getMapitTable()->saveMapit($mapit);
    	
    			// Redirect to list of mapits
    			return $this->redirect()->toRoute('mapit');
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
    		return $this->redirect()->toRoute('mapit');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getMapitTable()->deleteMapit($id);
    		}
    	
    		// Redirect to list of mapits
    		return $this->redirect()->toRoute('mapit');
    	}
    	
    	return array(
    			'id'    => $id,
    			'mapit' => $this->getMapitTable()->getMapit($id)
    	);    	
    }
    
    private function getGoogleMapsInfo()
    {
    	$serviceLocator = $this->getServiceLocator();
    	$config         = $serviceLocator->get('config');
    	$this->googleMapsKey       = $config['google_maps'];
    	return $this->googleMapsKey;
    }    
    
    public function getMapitTable()
    {
    	/*
    	if (!$this->mapitTable) {
    		$sm = $this->getServiceLocator();
    		$this->mapitTable = $sm->get('Mapit\Model\MapitTable');
    	}
    	*/
    	return $this->mapitTable;
    }    
}