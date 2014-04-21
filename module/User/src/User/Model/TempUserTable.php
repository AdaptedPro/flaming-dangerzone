<?php
namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

class TempUserTable
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
	
	public function getTempUser($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function saveTempUser(TempUser $temp_user)
	{
	
		$salt = sha1($temp_user->email);
		$password = sha1($temp_user->password);
		$hash_password = sha1("Using ".$salt." on ".$password);
	
		$data = array(
				'email' => $temp_user->email,
				'first_name' => $temp_user->first_name,
				'last_name' => $temp_user->last_name,
				'username' => $temp_user->username,
				'hashed_password'  => $hash_password,
				'link' => $temp_user->link,
				'locale' => $temp_user->locale,
				'gender' => $temp_user->gender,
				'created_on' => $temp_user->created_on,
				'updated_on' => $temp_user->updated_on,
		);
	
		$id = (int) $temp_user->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getTempUser($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Temp User id does not exist');
			}
		}
	}

	public function deleteTempUser($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}	
	
}