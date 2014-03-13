<?php
namespace Project\Form;

use Zend\Form\Form;

class ProjectForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('project');

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'project_type',
				'type' => 'Text',
				'options' => array(
						'label' => 'Project Type',
				),
		));
		$this->add(array(
				'name' => 'project_name',
				'type' => 'Text',
				'options' => array(
						'label' => 'Project Name',
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