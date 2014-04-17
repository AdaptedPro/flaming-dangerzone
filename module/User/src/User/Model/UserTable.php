<?php
namespace User\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class UserTable
{
	protected $tableGateway;
	protected $adapter;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	
	public function getAuthUser($DATA)
	{
		//$adapter = new Zend\Db\Adapter\Adapter($configArray);
		$adapter = new Adapter(array(
				'driver' => 'Pdo_Mysql',
				'database' => 'ajdata',
				'username' => 'root',
				'password' => 'root'
		));
		
//
		$sql = "SELECT * FROM `user`";
		//$statement = $adapter->createStatement($sql, $optionalParameters);
		$statement = $adapter->createStatement($sql);
		$result = $statement->execute();
		return $result;
	}

	public function getUser($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveUser(User $user)
	{
		$data = array(
				'email' => $user->email,
				'password'  => $user->password,
		);

		$id = (int) $user->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getUser($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('User id does not exist');
			}
		}
	}

	public function deleteUser($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
	
	public function authenticateUser($DATA)
	{
		$data = array(
				'email' => isset($DATA['user_email'])?$DATA['user_email']:'',
				'password'  => isset($DATA['user_password'])?$DATA['user_password']:'',
		);
	}
}