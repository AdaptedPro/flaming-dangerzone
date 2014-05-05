<?php
namespace Upload\Form;

use Zend\Form\Form;

class UploadForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('upload');

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'file_id',
				'type' => 'Hidden',
		));		
		$this->add(array(
				'name' => 'file_path',
				'type' => 'Hidden',
		));	
		$this->add(array(
				'name' => 'file_name',
				'type' => 'Hidden',
		));	
		$this->add(array(
				'name' => 'file_size',
				'type' => 'Hidden',
		));				
		$this->add(array(
				'name' => 'application_id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'application_labeltext',
				'type' => 'text',
				'required' => true,
				'options' => array(
						'label' => 'Label.',
				),
		));
		$this->add(array(
				'name' => 'created_by',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'created_at',
				'type' => 'Hidden',
		));			
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Save',
						'id' => 'submitbutton',
				),
		));
	}
	
}