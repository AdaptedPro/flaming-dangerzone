<?php

namespace Route\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Route
{
	public $id;
	public $user_id;
	public $route_name;
	public $origin;
	public $destination;
	public $travel_mode;
	protected $inputFilter;

	public function exchangeArray($data)
	{
		$this->id           = (!empty($data['id'])) ? $data['id'] : null;
		$this->user_id      = (!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->route_name   = (!empty($data['route_name'])) ? $data['route_name'] : null;
		$this->origin       = (!empty($data['origin'])) ? $data['origin'] : null;
		$this->destination  = (!empty($data['destination'])) ? $data['destination'] : null;
		$this->travel_mode  = (!empty($data['travel_mode'])) ? $data['travel_mode'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
					'name'     => 'id',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));
			
			$inputFilter->add(array(
					'name'     => 'user_id',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));			

			$inputFilter->add(array(
					'name'     => 'route_name',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 40,
									),
							),
					),
			));
			
			$inputFilter->add(array(
					'name'     => 'origin',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 40,
									),
							),
					),
			));

			$inputFilter->add(array(
					'name'     => 'destination',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 40,
									),
							),
					),
			));	

			$inputFilter->add(array(
					'name'     => 'travel_mode',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 40,
									),
							),
					),
			));			

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}