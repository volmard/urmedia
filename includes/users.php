<?php
require_once("initialize.php");

class Users extends dbObject {
	
	protected $tableName = "users";		
	protected $dbFields;		
	
	public $id;	
	public $login;
	public $password;
	public $firstName;
	public $lastName;
	public $email;
	public $phone;
	public $adress;
	public $country;
	
	function __construct($db) {
		$this->con    = $db;
		$this->dbFields = $this->getFieldsName();
	}

	private function findUserByName($login = "") {		
		$sql  = "SELECT * FROM users ";
		$sql .= "WHERE  login  = ? ";
		$sql .= "LIMIT 1";
		
		$resultArray = $this->findBySqlPrepared($sql, $login);
		return !empty($resultArray) ? array_shift($resultArray) : false;
	}
	
	public function authenticate($login = "", $password = "") {
	  $user     = $this->findUserByName($login);
		
		if($user) :
		  $checkedPassword = $this->passwordVerify($password, $user->password);
		  if($checkedPassword)
				return $user;
		endif;
		
		return false;
	}
	
	public function passwordHash() {
		$hash = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 10]);
    return $hash;
  } 
	
	//check if it can be static!
  private function passwordVerify($password, $existingHash) {
    $hash = password_verify($password, $existingHash);
    if ($hash) return true;
    return false;
  } 
	
	public function canUseLogin($login = "") {		
		$sql   = "SELECT id FROM users ";
		$sql  .= "WHERE  login  = ? ";
		$sql  .= "LIMIT 1";
		
		$resultArray = $this->findBySqlPrepared($sql,$login);
		return !empty($resultArray) ? array_shift($resultArray) : false;
	}
	
	public function fullName() {
		return $this->firstName . " " . $this->lastName;
	}	
		
	protected function getFieldsName() {
		
	  $sql       = "SELECT * FROM ";
		$sql      .= $this->tableName;
		
    $result    = DB::$con2->query($sql);
		$finfo     = $this->con->fetchFields($result);
		$dbFields  = [];
	  foreach($finfo as $val)
      $dbFields[]= $val->name;
		
		return $dbFields;
	}	
	
}

$user = new Users($database);