<?php

require_once("config.php");

class DB extends mysqli {
	
	public static $con2;
	
	public function __construct() 								 {		
		parent::__construct(DB_SERVER, DB_USER, DB_PASS, DB_NAME);		
		$this->checkConnection();
	}
	
	private function checkConnection()             {
		if ($this->connect_error)
		  die("Database connecion failed " . 
					$this->connect_error . " (" . 
					$this->connect_errno . ")"
			);
	}
	
	public  function closeConnection()             {
		$this->close();
	}
	
	public  function query($sql)                   {
		$result = parent::query($sql);	
		$this->confirmQuery($result);
		return $result;
	}
	
	public  function prepared($sql)                {
		$result = $this->prepare($sql);
		$this->confirmQuery($result);
		return $result;
	}
	
	public  function confirmQuery($result)         {
		if(!$result) :
			die("Database query failed " . 
					$this->connect_error . " (" . 
					$this->connect_errno . ")"
			);
		exit;
		endif;		
	}
	
	public  function escapeValue($string)          {
		$escapedString = $this->real_escape_string($string);
		return $escapedString;
	}
	
	// @ "database neutral" functions:
	
	public function fetchArray($resultSet)         {
		return $resultSet->fetch_array(MYSQLI_ASSOC);		
	}
	
	public function stmtExecute($stmt)             {
		return $stmt->execute();
	}
	
	public function resultMetadata($stmt)          {
		return $stmt->result_metadata();
	}
	
	public function fetchField($meta)              {
		return $meta->fetch_field();		
	}
	
	public function fetchFields($result)           {
		return $result->fetch_fields();
	}
	
	public function stmtFetch($stmt)               {
		return $stmt->fetch();
	}
	
	public function numRows($resultSet)            {
		return $resultSet->num_rows;
	}
	
	public function affectedRows()                 {
		return $this->affected_rows;
	}
	
	public function insertId()                     {
		return $this->insert_id;
	}
	
	public function closeStmt($stmt)               {
		return $stmt->close();
	}
	
	public function setAutoCommit() {
		$this->autocommit(FALSE);
	}
	
	public function setCommit() {
		$this->commit();
	}

}

$database = new DB;
DB::$con2 = new DB;