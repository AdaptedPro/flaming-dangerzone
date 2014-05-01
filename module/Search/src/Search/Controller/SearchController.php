<?php
namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Search\Model\Search;
use Search\Form\SearchForm;

class SearchController extends AbstractActionController
{
	protected $searchTable;
	protected $beatsInfo;
	protected $beatsKey;
	protected $beatsSecret;
	
    public function indexAction()
    {
    	$beats_info = $this->getBeatsInfo();
    	$this->beatsKey = $beats_info['api_key'];
    	$this->beatsSecret = $beats_info['api_secret'];
    	$result_set = $this->do_search();
    	$msg = isset($_SESSION['login_message'])?$_SESSION['login_message']:'';
    	return new ViewModel(array(
             //'searchs' => $this->getSearchTable()->fetchAll(),
         	 'displayname' => isset($_SESSION['auth_user']['email'])?$_SESSION['auth_user']['email']:'Guest',
    		 'message' => $msg,
    		 'results' => $result_set,
         ));
    }
    
    public function beatsAction()
    {
    	if (isset($_POST)) {
    		$query_string = isset($_POST['beats_q'])?urlencode($_POST['beats_q']):'';
    		$query_type = isset($_POST['beats_type'])?urlencode($_POST['beats_type']):'';
	    	$url = "https://partner.api.beatsmusic.com/v1/api/search?q={$query_string}&type={$query_type}&client_id={$this->beatsKey}";
	    	$data_set = file_get_contents($url);
	    	return $data_set;    	
    	}
    }
    
    public function instagramAction()
    {
    	 
    }    
    
    public function twitterAction()
    {
    
    }    
    
    public function facebookAction()
    {
    
    }    
    
    public function foursquareAction()
    {
    
    }   
    
    private function do_search()
    {
    	$url = "https://partner.api.beatsmusic.com/v1/api/search?q=rain&type=track&client_id={$this->beatsKey}";
    	$x = file_get_contents($url);
    	return $x;
    }
    
	/*
    public function addAction()
    {
    	$form = new SearchForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$search = new Search();
    		$form->setInputFilter($search->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$search->exchangeArray($form->getData());
    			$this->getSearchTable()->saveSearch($search);
    	
    			// Redirect to list of searchs
    			return $this->redirect()->toRoute('search');
    		}
    	}
    	return array('form' => $form);    	
    }

    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('search', array(
    				'action' => 'add'
    		));
    	}
    	
    	// Get the Search with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
    	try {
    		$search = $this->getSearchTable()->getSearch($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('search', array(
    				'action' => 'index'
    		));
    	}
    	
    	$form  = new SearchForm();
    	$form->bind($search);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($search->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$this->getSearchTable()->saveSearch($search);
    	
    			// Redirect to list of searchs
    			return $this->redirect()->toRoute('search');
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
    		return $this->redirect()->toRoute('search');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getSearchTable()->deleteSearch($id);
    		}
    	
    		// Redirect to list of searchs
    		return $this->redirect()->toRoute('search');
    	}
    	
    	return array(
    			'id'    => $id,
    			'search' => $this->getSearchTable()->getSearch($id)
    	);    	
    }
    */
    private function getBeatsInfo()
    {
    	$serviceLocator = $this->getServiceLocator();
    	$config         = $serviceLocator->get('config');
    	$this->beatsInfo        = $config['beats'];    	
    	return $this->beatsInfo;
    }
    
    /*
    public function getSearchTable()
    {
    	if (!$this->searchTable) {
    		$sm = $this->getServiceLocator();
    		$this->searchTable = $sm->get('Search\Model\SearchTable');
    	}
    	return $this->searchTable;
    }
    */    
}