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
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Save',
						'id' => 'submitbutton',
				),
		));
	}
	
}