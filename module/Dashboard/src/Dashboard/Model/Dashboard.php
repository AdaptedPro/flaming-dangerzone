<?php

namespace Dashboard\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Dashboard
{
	public $id;
	public $dashboard_type;
	public $dashboard_name;
	protected $inputFilter;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->dashboard_type = (!empty($data['dashboard_type'])) ? $data['dashboard_type'] : null;
		$this->dashboard_name  = (!empty($data['dashboard_name'])) ? $data['dashboard_name'] : null;
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
					'name'     => 'dashboard_type',
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
											'max'      => 100,
									),
							),
					),
			));
	
			$inputFilter->add(array(
					'name'     => 'dashboard_name',
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
											'max'      => 100,
									),
							),
					),
			));
	
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}	
}