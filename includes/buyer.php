<?php

class Buyer extends dbObject {
	
	protected $tableName  = "buyers";
	protected $dbFields;	
	public $id;
	public $firstName;
	public $lastName;
	public $email;
	public $phone;
	public $adress;
//	public $ip;
	public $orderId;
	public $datetime;

	public function __construct($db)                 {
		$this->con                    = $db;
		$this->dbFields      = [
			                      'dbFields'     => $this->getFieldsName(false), 
														'dbFieldsJoin' =>	$this->getFieldsName()
		];
    $this->initAttributes();	
	}			
	
	public function initAttributes()          {
		if(isset($_POST['order'])) {			
			$this->datetime = time();			
		  $this->orderId  = Order::saveOrder();
		}		
	}
	
	public function fullName()                {
		return $this->firstName . " " . $this->lastName;
	}	
	
	public function findBuyers()              {   
	  $sql       = "SELECT * FROM ";
		$sql      .= $this->tableName;
		
		$resultArr = $this->findBySql($sql);
		return $resultArr;
  }

  protected function getFieldsName() {
	  $sql      = "SELECT * FROM ";
		$sql     .= $this->tableName;
		
    $result   = DB::$con2->query($sql);
		$finfo    = $this->con->fetchFields($result);
		
		$dbFields = [];
	  foreach($finfo as $val) {
      $dbFields[] = $val->name;
    }
		
		return $dbFields;
	}
}

$buyer = new Buyer($database);