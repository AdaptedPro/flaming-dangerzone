<?php
namespace Upload\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Upload\Model\Upload;
use Upload\Form\UploadForm;

class UploadController extends AbstractActionController
{
	protected $uploadTable;
	
    public function indexAction()
    {	
    	#If not referred by an application requiring an upload
    	$DATA['app_id'] = 1;
    	
    	$referred = isset($DATA['app_id'])?true:false;
    	if ($referred) {
    		$msg = "Upload";
    	} else {
	    	$msg = 'Choose an application for upload.';
    	}
    	
    	return new ViewModel(array(
             //'uploads' => $this->getUploadTable()->fetchAll(),
         	 'displayname' => isset($_SESSION['auth_user']['email'])?$_SESSION['auth_user']['email']:'Guest',
    		 'msg' => $msg,
    		 //'results' => $result_set,
         ));
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
    
    private function do_upload()
    {
//     	$json_url = "";
//     	$json = file_get_contents($json_url);
//     	return $json;
    }
    

    public function addAction()
    {
    	$form = new UploadForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$upload = new Upload();
    		$form->setInputFilter($upload->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$upload->exchangeArray($form->getData());
    			$this->getUploadTable()->saveUpload($upload);
    	
    			// Redirect to list of uploads
    			return $this->redirect()->toRoute('upload');
    		}
    	}
    	return array('form' => $form);    	
    }

    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('upload', array(
    				'action' => 'add'
    		));
    	}
    	
    	// Get the Upload with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
    	try {
    		$upload = $this->getUploadTable()->getUpload($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('upload', array(
    				'action' => 'index'
    		));
    	}
    	
    	$form  = new UploadForm();
    	$form->bind($upload);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($upload->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$this->getUploadTable()->saveUpload($upload);
    	
    			// Redirect to list of uploads
    			return $this->redirect()->toRoute('upload');
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
    		return $this->redirect()->toRoute('upload');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getUploadTable()->deleteUpload($id);
    		}
    	
    		// Redirect to list of uploads
    		return $this->redirect()->toRoute('upload');
    	}
    	
    	return array(
    			'id'    => $id,
    			'upload' => $this->getUploadTable()->getUpload($id)
    	);    	
    }

    public function getUploadTable()
    {
    	if (!$this->uploadTable) {
    		$sm = $this->getServiceLocator();
    		$this->uploadTable = $sm->get('Upload\Model\UploadTable');
    	}
    	return $this->uploadTable;
    } 
}