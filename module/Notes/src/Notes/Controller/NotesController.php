<?php
namespace Notes\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Notes\Model\Notes;
//use Notes\Form\NotesForm;

class NotesController extends AbstractActionController
{
	protected $notesTable;
	
    public function indexAction()
    {
         return new ViewModel(array(
             //'notes' => $this->getNotesTable()->fetchAll(),
         ));
    }

    public function addAction()
    {
    	$form = new NotesForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {

    	}
    	return array('form' => $form);    	
    }

    public function editAction()
    {
   	
    }

    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('notes');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getNotesTable()->deleteNotes($id);
    		}
    	
    		// Redirect to list of notes
    		return $this->redirect()->toRoute('notes');
    	}
    	
    	return array(
    			'id'    => $id,
    			'notes' => $this->getNotesTable()->getNotes($id)
    	);    	
    }
    
    
    
    
    public function getNotesTable()
    {
    	if (!$this->notesTable) {
//     		$sm = $this->getServiceLocator();
//     		$this->notesTable = $sm->get('Notes\Model\NotesTable');
    	}
    	return $this->notesTable;
    }    
}