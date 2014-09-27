<?php
namespace Route\Form;

use Zend\Form\Form;

class RouteForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('route');

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'user_id',
				'type' => 'Hidden',
		));		
		$this->add(array(
				'name' => 'route_name',
				'type' => 'Text',
				'options' => array(
						'label' => 'Route Name',
				),
		));
		$this->add(array(
				'name' => 'origin',
				'type' => 'Text',
				'options' => array(
						'label' => 'Origin',
				),
		));
		$this->add(array(
				'name' => 'destination',
				'type' => 'Text',
				'options' => array(
						'label' => 'Destination',
				),
		));		
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'travel_mode',
				'options' => array(
						'label' => 'Transit type',
						'value_options' => array(
								'DRIVING'   => 'Driving',
								'BICYCLING' => 'Bicycle',
								'TRANSIT' => 'Public transportation',
								'WALKING' => 'Walking',
						),
				)
		));						
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'class'=> 'btn btn-default',
				'attributes' => array(
						'value' => 'Go',
						'id' => 'submitbutton',
				),
		));
	}
}