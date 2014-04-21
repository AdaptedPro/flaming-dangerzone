<?php
namespace FacebookUser\Form;

use Zend\Form\Form;

class FacebookUserForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('facebookuser');

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'email',
				'type' => 'Text',
				'options' => array(
						'label' => 'Email',
				),
		));
		$this->add(array(
				'name' => 'first_name',
				'type' => 'Text',
				'options' => array(
						'label' => 'First Name',
				),
		));	
		$this->add(array(
				'name' => 'last_name',
				'type' => 'Text',
				'options' => array(
						'label' => 'last Name',
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
				'type' => 'Text',
				'options' => array(
						'label' => 'Gender',
				),
		));	
		$this->add(array(
				'name' => 'locale',
				'type' => 'Text',
				'options' => array(
						'label' => 'Local',
				),
		));	
		$this->add(array(
				'name' => 'link',
				'type' => 'Text',
				'options' => array(
						'label' => 'Facebook Link',
				),
		));	
		$this->add(array(
				'name' => 'username',
				'type' => 'Text',
				'options' => array(
						'label' => 'Username',
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