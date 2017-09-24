<?php
require_once("database.php");

// @check function instantiate($record), cleanText($value) row; is't database issue or text?

//abstract 

class dbObject {
	
	protected $con;	
	protected $multiArr     = [];
	public    $uploadDir    = 'images/products';	
	public   static $errors = [];	
	protected $uploadErrors = [
	  UPLOAD_ERR_OK 				=> "No errors.",
	  UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
    UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
    UPLOAD_ERR_NO_FILE 		=> "No file.",
    UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
    UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
    UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
  ];	
	
	public    function instantiate($record)           {
		$object       = new static($this->con);
		foreach($record as $attribute => $value) :
			if($object->hasAttribute($attribute)) {
				$value              = cleanText($value);
			  $object->$attribute = $value;
			}
		endforeach;
		return $object;
	}
	
	private   function hasAttribute($attribute)       {
//		$objectVars = get_object_vars($this);
		$objectVars = $this->attributes();
		return array_key_exists($attribute, $objectVars);
	}
	
	protected function attributes(bool $join = false) {
		$attributes = [];	
		$dbFields   = $this->dbFields['dbFieldsJoin'];
		if($join) 
			$dbFields = $this->dbFields['dbFields'];
		
		foreach($dbFields as $field) :
		  if(property_exists($this, $field))
				$attributes[$field] = $this->$field;
		endforeach;
		return $attributes;
	}
	
	private   function sanitizedAttributes()          {
		$cleanAttributes = [];
		foreach($this->attributes(true) as $key => $value)
		  $cleanAttributes[$key] = $this->con->escapeValue($value);
		return $cleanAttributes;
	}	
	
	/*	
	  @ function findBySqlPrepare
		@ Using checkVarType because of expected error, mysql try to handle recognizing $id type		
	*/	
	
	private static function updateAttr($params, $attr, $id) {		
		$attrPairs    = [];
	  foreach($attr as $key => $value)
		 $attrPairs[] = "{$key} = ?";
		$types[]      = implode('', self::checkVarType($attr)) . "i";
		$values       = array_merge($types, $params);
		$values[]     = &$id;		
		$arr          = [$attr, $attrPairs, $values];
		return $arr;
	}
	
  private function createAttr($params, $attr)             {		 
		$types         = [];
		$placeholders  = placeholders(count($attr));
		$types[]       = implode('', self::checkVarType($attr));
		
		if(isset($this->attrArr)) :
			$values = [];
			foreach($params as $param) 
		    $values[]        = array_merge($types, $param);
		else :
			$values        = array_merge($types, $params);
		endif;				
			
		$arr           = [$attr, $placeholders, $values];
		return $arr;
	}
	
	private	function prepareSaveValues()                    {
		// @init input
		$attr      = $this->attributes(true);		
		$id        = $this->id;			
		$params    = [];
		array_shift($attr); // @deletes id
		
		// @case for multi queries
		if(isset($this->attrArr)) :
		  foreach ($this->attrArr as &$arr) :
		  	$param = [];
		    foreach ($arr as &$value)
          $param[] = &$value;
		  	$params[] = $param;		
		  endforeach;	
		// @case for single query
		else :
		  foreach ($attr as &$value) 
        $params[] = &$value;	
		endif;

		if($id) :	
      return self::updateAttr($params, $attr, $id);
		else :
      return self::createAttr($params, $attr);
		endif;
	}		
	
	private static function prepareSelectValues($id)        {
		$id          = !is_array($id) ? (array)$id : $id;
		$params      = [];		
		foreach($id as &$value)
			$params[]  = &$value;		
		$typeString  = implode('', self::checkVarType($id));		
		$types       = (array)$typeString;
		$values      = array_merge($types, $params);
		return $values;
	}
	
	private function prepareValues($id = 0)                 {
		if($id)
			return self::prepareSelectValues($id);
		return $this->prepareSaveValues();
	}
	
	private static function checkVarType($array)            {
		$checkedArray       = [];
		
		foreach ($array as $val) :
			if (is_string($val)) :
				$checkedArray[] = 's';
			elseif(is_numeric($val)) :
				$checkedArray[] = 'i';
			endif; 
	  endforeach;
		
		return $checkedArray;
	}
	
	private function findBySqlPrepare($sql, $id)            {
		// @init input
		$objectArray = [];
		$parameters  = [];
		$values      = self::prepareValues($id);
		
		// @prepare stmt
		$stmt        = $this->con->prepared($sql);
		
		// @bind_param and execute stmt
		call_user_func_array([$stmt, 'bind_param'], $values);
		$this->con->stmtExecute($stmt);	
		
		// @bind_result stmt
		$meta   = $this->con->resultMetadata($stmt);
		while($field = $this->con->fetchField($meta))	
			$parameters[] = &$row[$field->name];
		call_user_func_array([$stmt, 'bind_result'], $parameters);	
		
		// @fetch stmt
		while($this->con->stmtFetch($stmt))
		  $objectArray[] = $this->instantiate($row, true);		
		
		// @close stmt
		$this->con->closeStmt($stmt);
		return !empty($objectArray) ? $objectArray : false;		
	}
	
	private function findBySqlQuery($sql)                   {
		$resultSet   = $this->con->query($sql);
		$objectArray = [];		
		while($row = $this->con->fetchArray($resultSet)) :		
			$objectArray[] = $this->instantiate($row);
	  endwhile;		 
		return !empty($objectArray) ? $objectArray : false;
	}
	
	public function findBySql($sql = "", $id = 0)           {
		if($id)
		  return $this->findBySqlPrepare($sql, $id);
		return $this->findBySqlQuery($sql);		
	}	
	
	public function findAll($rand = 0, $lim = 0)            {
		$sql  = "SELECT * FROM ";
		$sql .= $this->tableName;
		if($rand !== 0)
			$sql .= " ORDER BY RAND()";
		if($lim !== 0)
			$sql .= " LIMIT 0, {$lim}";
		
		$resultArray = $this->findBySql($sql);
		return $resultArray;
	}	

	/*
	  This function works in two ways:
		@1 if $id !== 0 the function will call ordinary sql query;
	  @2 if $id = '?' and $id2 !== 0 the function will call prepared statement
	*/
	public function findByid($id = 0, $id2 = 0)             {
		$sql  = "SELECT * FROM ";
		$sql .= $this->tableName;		
		$sql .= " WHERE id = {$id} ";
		$sql .= "LIMIT 1";
		
		$resultArray = $this->findBySql($sql, $id2);
		return !empty($resultArray) ? array_shift($resultArray) : false;		
	}		
		
	/*@for testing, will be deleted in the future*/
	public function createByQuery()                         {
		$attributes = $this->sanitizedAttributes();
		array_shift($attributes); //deletes id
		
		$sql  = "INSERT INTO ";
		$sql .= $this->tableName;
		$sql .= " (";
		$sql .= implode(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
    $sql .= implode("', '", array_values($attributes));
		$sql .= "')";
		
		$this->con->query($sql);
		$affectedRows = $this->con->affectedRows();
		if($affectedRows == 1) {
			$this->id = $this->con->insertId();//#conflict with multi queries
			return true;
		} 
		return false;
	}
	
	public function runStmt($sql, $values)                  {
		// @prepare stmt
		if(isset($this->attrArr)) 
		  $this->con->setAutoCommit();		
		$stmt = $this->con->prepared($sql);
		
		// @bind_param and execute stmt
		if(isset($this->attrArr)) :
		  foreach($values as $value) {
		    call_user_func_array(array($stmt, 'bind_param'), $value); 
        $this->con->stmtExecute($stmt);	
      }
		else :
			call_user_func_array(array($stmt, 'bind_param'), $values); 
      $this->con->stmtExecute($stmt);	
		endif;
		
		$affectedRows = $this->con->affectedRows();
		
		// @close stmt		
		if(isset($this->attrArr)) 
		  $this->con->setCommit();		
		$this->con->closeStmt($stmt);
		
		return $affectedRows;    
	}

  public function create()                                {
    [$attr, $placeholders, $values] = $this->prepareValues();
	  $sql           = "INSERT INTO ";
	  $sql          .= $this->tableName;
	  $sql          .= " (";
	  $sql          .= implode(", ", array_keys($attr));
	  $sql          .= ") VALUES (";
    $sql          .= $placeholders;
	  $sql          .= ")";	      
    $affectedRows  = $this->runStmt($sql, $values);	
      
    if ($affectedRows == 1) : 
	    $this->id    = $this->con->insertId();
	    return true;
	  endif;		
	  return false;
  }
	
	//	public function update() {}		
		
	// @ $input is temporary used to avoid conflict with the same product class function
	public function save($input = 0)                        {
		return isset($this->id) ? $this->update() : $this->create();
	}
	
//	public function delete()                                      {}
		
	public function countAll($id=0)                         {		
		$sql       = "SELECT COUNT(*) FROM ".$this->tableName;
		if($id) 
			$sql    .= " INNER JOIN brands ON brands.id=products.brandId WHERE brandTitle='$id'";
		
		$resultSet = $this->con->query($sql);
		$row       = $this->con->fetchArray($resultSet);
		
		return array_shift($row);
	}

			
//	abstract 
//		protected static function getFieldsName();
	
}
