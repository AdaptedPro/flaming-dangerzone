<?php
namespace User\Form;

use Zend\Form\Form;

class UserForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('user');

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'facebook_id',
				'type' => 'text',
				'options' => array(
						'label' => 'Facebook ID.',
				),
		));		
		$this->add(array(
				'name' => 'first_name',
				'type' => 'text',
				'required' => true,
				'options' => array(
						'label' => 'First name.',
				),
		));
		$this->add(array(
				'name' => 'last_name',
				'type' => 'text',
				'required' => true,
				'options' => array(
						'label' => 'Last name.',
				),
		));
		$this->add(array(
				'name' => 'username',
				'type' => 'text',
				'options' => array(
						'label' => 'Username.',
				),
		));
		$this->add(array(
				'name' => 'link',
				'type' => 'text',
				'options' => array(
						'label' => 'Website',
				),
		));				
		$this->add(array(
				'name' => 'email',
				'type' => 'email',
				'options' => array(
						'label' => 'Email',
				),
		));
		$this->add(array(
				'name' => 'password',
				'type' => 'password',
				'options' => array(
						'label' => 'Password',
				),
		));
		$this->add(array(
				'name' => 'gender',
				'type' => 'text',
				'options' => array(
						'label' => 'Gender',
				),
		));		
		$this->add(array(
				'name' => 'locale',
				'type' => 'text',
				'options' => array(
						'label' => 'Locale',
				),
		));	
		$this->add(array(
				'name' => 'created_on',
				'type' => 'text',
				'options' => array(
						'label' => 'Created On',
				),
		));
		$this->add(array(
				'name' => 'updated_on',
				'type' => 'text',
				'options' => array(
						'label' => 'Updated On',
				),
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