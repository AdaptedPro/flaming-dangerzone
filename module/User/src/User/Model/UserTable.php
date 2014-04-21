<?php
namespace User\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class UserTable
{
	protected $tableGateway;

	protected $adapter;

	protected $email;
	protected $password;
	protected $firstname;
	protected $middlename;
	protected $lastname;
	protected $username;
	

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
		
		$salt = sha1($user->email);
		$password = sha1($user->password);
		$hash_password = sha1("Using ".$salt." on ".$password);		
		
		$data = array(
				'email' => $user->email,
				'hashed_password'  => $hash_password,
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
	
	public function authenticateUser($DATA)
	{
		$email = $DATA['email'];
		$salt = sha1($DATA['email']);
		$password = sha1($DATA['password']);
		$hash_password = sha1("Using ".$salt." on ".$password);
		$rowset = $this->tableGateway->select(
				array(
					'email' => $DATA['email'],
					'hashed_password' => $hash_password
				)
		);
		$row = $rowset->current();
// 		if (!$row) {
// 			throw new \Exception("Could not find row with email {$email} and password {$hash_password}");
// 		}
		return $row;		
	}
	
	private function password_match()
	{
		
	}

	private function create_password_salt($email)
	{
		$date = date('Y-m-d');
		$output = "";
		$output .= "Using {$email} with {$date} to make salt";
		return $output;
	}	
	
	private function hash_with_salt($password='null',$salt='')
	{
		$output = "";
		return $output;	
	}	
	
	private function create_hashed_password($password)
	{
		$output = "";
		return $output;		
	}

	public function deleteUser($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}