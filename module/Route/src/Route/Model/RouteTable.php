<?php
namespace Route\Model;

use Zend\Db\TableGateway\TableGateway;

class RouteTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function get_routes_by_user_id($id)
	{
		$resultSet = $this->tableGateway->select(array('user_id' => $id));
		return $resultSet;	
	}	

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getRoute($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveRoute(Route $route)
	{
		$data = array(
				'user_id'     => $route->user_id,
				'route_name'  => $route->route_name,
				'origin'      => $route->origin,
				'destination' => $route->destination,
				'travel_mode' => $route->travel_mode,
		);

		$id = (int) $route->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getRoute($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Route id does not exist');
			}
		}
	}

	public function deleteRoute($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}	
}