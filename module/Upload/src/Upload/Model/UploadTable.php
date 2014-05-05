<?php
namespace Upload\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class UploadTable
{
	protected $tableGateway;

	protected $adapter;

	public $id;
	public $file_id;
	public $file_path;
	public $file_name;
	public $file_size;
	public $application_id;
	public $application_labeltext;
	public $created_by;
	public $created_at;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getUpload($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveUpload(Upload $upload)
	{	
		$data = array(
		'id' => $upload->id,
		'file_id' => $upload->file_id,
		'file_path' => $upload->file_path,
		'file_name' => $upload->file_name,
		'file_size' => $upload->file_size,
		'application_id' => $upload->application_id,
		'application_labeltext' => $upload->application_labeltext,
		'created_by' => $upload->created_by,
		'created_at' => $upload->created_at				
		);

		$id = (int) $upload->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getUpload($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Upload id does not exist');
			}
		}
	}

	public function deleteUpload($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}