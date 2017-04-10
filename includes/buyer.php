<?php

class Buyer extends DbObject {
	
	protected static $table_name  = "buyers";
	protected static $db_fields;	
	public $id;
	public $name;
	public $surname;
	public $email;
	public $phone;
	public $adress;
	public $ip;
	public $order_id;
	public $datetime;

	function __construct() {
		self::$db_fields = self::get_fields_name();
    $this->init_attributes();	
	}			
	
	public function init_attributes() {
		if(isset($_POST['order'])) {			
			$this->datetime  = time();
		  $this->order_id  = Order::save_order();
		}		
	}
	
	public static function find_buyers() {
    global $database;    
	  $sql          = "SELECT * FROM ";
		$sql         .= self::$table_name;
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? $result_array : false;
}

  protected static function get_fields_name() {
		global $database;
	  $sql = "SELECT * FROM ";
		$sql .= self::$table_name;
    $result = $database->query($sql);
		$finfo = $result->fetch_fields();
		$db_fields=[];
	  foreach($finfo as $val) {
      $db_fields[]= $val->name;
    }
		return $db_fields;
	}
}

$buyer = new Buyer();