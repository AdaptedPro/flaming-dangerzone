<?php
namespace Dashboard\Model;

use Zend\Db\TableGateway\TableGateway;

class DashboardTable
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

	public function getDashboard($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveDashboard(Dashboard $dashboard)
	{
		$data = array(
				'dashboard_type' => $dashboard->dashboard_type,
				'dashboard_name'  => $dashboard->dashboard_name,
		);

		$id = (int) $dashboard->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getDashboard($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Dashboard id does not exist');
			}
		}
	}

	public function deleteDashboard($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}