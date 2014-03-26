<?php
namespace Rover\Model;

use Zend\Db\TableGateway\TableGateway;

class RoverTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getRover($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveRover(Rover $rover)
	{
		$data = array(
				'email' => $rover->email,
				'password'  => $rover->password,
		);

		$id = (int) $rover->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getRover($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Rover id does not exist');
			}
		}
	}

	public function deleteRover($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}