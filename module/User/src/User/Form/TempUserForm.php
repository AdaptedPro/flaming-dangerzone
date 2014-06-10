<?php
namespace User\Form;

use Zend\Form\Form;

class TempUserForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('tempUser');

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'first_name',
				'type' => 'text',
				'required' => true,
				'options' => array(
						'label' => 'First name.',
				),
				'attributes' => array(
						'class' => 'form-control',
				),
		));
		$this->add(array(
				'name' => 'last_name',
				'type' => 'text',
				'required' => true,
				'options' => array(
						'label' => 'Last name.',
				),
				'attributes' => array(
						'class' => 'form-control',
				),				
		));	
		$this->add(array(
				'name' => 'username',
				'type' => 'text',
				'options' => array(
						'label' => 'Username.',
				),
				'attributes' => array(
						'class' => 'form-control',
				),				
		));					
		$this->add(array(
				'name' => 'email',
				'type' => 'email',
				'required' => true,
				'options' => array(
						'label' => 'Email',
				),
				'attributes' => array(
						'class' => 'form-control',
				),				
		));
		$this->add(array(
				'name' => 'link',
				'type' => 'text',
				'options' => array(
						'label' => 'Website',
				),
				'attributes' => array(
						'class' => 'form-control',
				),				
		));		
		$this->add(array(
				'name' => 'password',
				'type' => 'password',
				'required' => true,
				'options' => array(
						'label' => 'Password',
				),
				'attributes' => array(
						'class' => 'form-control',
				),				
		));
		$this->add(array(
				'name' => 'gender',
				'type' => 'text',
				'required' => false,
				'options' => array(
						'label' => 'Gender',
				),
				'attributes' => array(
						'class' => 'form-control',
				),				
		));		
		$this->add(array(
				'name' => 'locale',
				'type' => 'Hidden',
		));	
		$this->add(array(
				'name' => 'created_on',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'updated_on',
				'type' => 'Hidden',
		));			
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',				
				'attributes' => array(
						'value' => 'Save',
						'id' => 'submitbutton',
						'class' => 'btn btn-default',
				),
		));
	}
	
}