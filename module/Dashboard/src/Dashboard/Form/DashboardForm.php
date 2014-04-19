<?php
namespace Dashboard\Form;

use Zend\Form\Form;

class DashboardForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('dashboard');

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'dashboard_type',
				'type' => 'Text',
				'options' => array(
						'label' => 'Dashboard Type',
				),
		));
		$this->add(array(
				'name' => 'dashboard_name',
				'type' => 'Text',
				'options' => array(
						'label' => 'Dashboard Name',
				),
		));
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Go',
						'id' => 'submitbutton',
				),
		));
	}
}