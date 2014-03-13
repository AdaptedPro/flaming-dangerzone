<?php
namespace Project\Model;

use Zend\Db\TableGateway\TableGateway;

class ProjectTable
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

	public function getProject($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveProject(Project $project)
	{
		$data = array(
				'project_type' => $project->project_type,
				'project_name'  => $project->project_name,
		);

		$id = (int) $project->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getProject($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Project id does not exist');
			}
		}
	}

	public function deleteProject($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}