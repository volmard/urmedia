<?php

class MySQLDatabase extends mysqli {
	
	private $connection;
	
	function __construct() {
		$this->open_connection();
		parent::__construct(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	}
	
	public function open_connection() {
	  $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno()) {
      die("Database connection failed " .
           mysqli_connect_error() . 
           " (" . mysqli_connect_errno() . ")"
      );  
    }
	}
	
	public function close_connection() {
		if(isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}
	
	public function query($sql) {
		$result = mysqli_query($this->connection, $sql);
//		$result = $this->query($sql);
		$this->confirm_query($result);
		return $result;
	}

	 function confirm_query($result) {
    if (!$result) {
      die ("Database query failed " . 
            mysqli_connect_error() . 
            " (" . mysqli_connect_errno() . ")"         
      );
      exit;
    } 
  }
	
  public function escape_value($string) {
		$escaped_string = $this->real_escape_string(($string));
    return $escaped_string;
  }
	
	// "database neutral" functions
	
  public function fetch_array($result_set) {
		 return mysqli_fetch_array($result_set);
	}
	
	public function num_rows($result_set) {
		return mysqli_num_rows($result_set);
	}
	
//	public function insert_id() {
//		return mysqli_insert_id($this->connection);
//	}
	
	public function affected_rows() {
		return mysqli_affected_rows($this->connection);
	}
	
	public function fetch_fields($result) {
		return mysqli_fetch_fields($result);
	}
	
}

$database = new MySQLDatabase();