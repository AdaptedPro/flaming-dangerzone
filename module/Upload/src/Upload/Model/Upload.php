<?php

namespace Upload\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Upload
{
	public $id;
	public $file_id;
	public $file_path;
	public $file_name;
	public $file_size;
	public $application_id;
	public $application_labeltext;
	public $created_by;
	public $created_at;
	protected $inputFilter;

	public function exchangeArray($data)
	{
		$this->id = (!empty($data['id'])) ? $data['id'] : 0;
		$this->file_id = (!empty($data['file_id'])) ? $data['file_id'] : 0;
		$this->file_path = (!empty($data['file_path'])) ? $data['file_path'] : '/public/uploads';
		$this->file_name = (!empty($data['file_name'])) ? $data['file_name'] : 'dummy';
		$this->file_size = (!empty($data['file_size'])) ? $data['file_size'] : '###';
		$this->application_id = (!empty($data['application_id'])) ? $data['application_id'] : 0;
		$this->application_labeltext = (!empty($data['application_labeltext'])) ? $data['application_labeltext'] : null;
		$this->created_by = isset($_SESSION['auth_user']['email'])?$_SESSION['auth_user']['email']:'Guest';
		$this->created_at = date('H:m:s - m/d/Y');
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
					'name'     => 'file_id',
					'required' => false,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));			

			$inputFilter->add(array(
					'name'     => 'file_path',
					'required' => false,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
			));			
			
			$inputFilter->add(array(
					'name'     => 'file_name',
					'required' => false,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
			));
	
			$inputFilter->add(array(
					'name'     => 'file_size',
					'required' => false,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
			));
		
			$inputFilter->add(array(
					'name'     => 'application_id',
					'required' => false,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));	
	
			$inputFilter->add(array(
					'name'     => 'application_labeltext',
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
					'name'     => 'created_by',
					'required' => false,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
			));	
	
			$inputFilter->add(array(
					'name'     => 'created_at',
					'required' => false,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
			));		
	
			$this->inputFilter = $inputFilter;
		}	
		return $this->inputFilter;
	
	}

}