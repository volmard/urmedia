<?php

abstract class DbObject {
	
	public static $upload_dir       = 'images/products';
	public static $errors           = [];	
	protected static $upload_errors = [
	  UPLOAD_ERR_OK 				=> "No errors.",
	  UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
    UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
    UPLOAD_ERR_NO_FILE 		=> "No file.",
    UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
    UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
    UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
  ];	
	
	public static function find_all($rand = 0, $lim = 0) {
    $sql  = "SELECT * FROM ";
    $sql .= static::$table_name;
    if ($rand !== 0) {
       $sql .= " ORDER BY RAND()";        
    }
    if ($lim !== 0) {
       $sql .= " LIMIT 0, {$lim}";        
    }
		return static::find_by_sql($sql);
  }
	
	public static function find_by_id($id = 0) {
    global $database;    
    $sql  = "SELECT * FROM ";
    $sql .= static::$table_name;
    $sql .= " WHERE id = {$id} ";
    $sql .= "LIMIT 1";
    $result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;    
  }
	
	public static function find_by_id_prepared($id = 0) {
		  global $database;
      $sql  = "SELECT * FROM ";
      $sql .= static::$table_name;
      $sql .= " WHERE id = ? ";
      $sql .= "LIMIT 1";
			$result_array = static::find_by_sql_prepared($sql, $id);
		  return !empty($result_array) ? array_shift($result_array) : false;
  }
	
	public static function find_by_sql($sql = "") {
    global $database;  
    $result_set   = $database->query($sql);
		$object_array = [];		
		while($row = $result_set->fetch_array()) {
      $object_array[] = static::instantiate($row);			
    }
		return $object_array;
  }
	
	public static function find_by_sql_prepared ($sql = "", $id = 0) {
    global $database;	
		$id         = !is_array($id) ? (array)$id : $id;
    $stmt       = $database->prepare($sql);
		$params     = []; 
		foreach ($id as &$value) { 
      $params[] = &$value;
    }
//		expected error, because mysql tried to handle recognazing $id type by itself
//		marked with * means improvements
//		$types[]    = str_repeat('i', count($params));
		
		$new          = new static();//*
		$types_string = implode('', $new->check_var_type($id));//*
		$types        = (array)$types_string;//*
    $values       = array_merge($types, $params);
    call_user_func_array(array($stmt, 'bind_param'), $values); 
    $stmt->execute();
    $meta         = $stmt->result_metadata();
    while ($field = $meta->fetch_field()) { 
      $parameters[] = &$row[$field->name]; 
    } 
    call_user_func_array(array($stmt, 'bind_result'), $parameters);
    while ($stmt->fetch()) {
		  $object_array[] = static::instantiate($row);
    }
		$stmt->close();	
		return $object_array;
  }
	
	/*not-styled function*/
	public static function count_all($id=0) {
		global $database;
		$query      = "SELECT COUNT(*) FROM ".static::$table_name;
		if($id) {
			$query    .= " INNER JOIN brands ON brands.id=products.brand_id WHERE brand_title='$id'";			
		}
		$result_set = $database->query($query);
		$row        = $result_set->fetch_array();
		return array_shift($row);
	}
	
	private static function instantiate($record) {
		$object = new static;		
		foreach($record as $attribute => $value) {
			if($object->has_attribute($attribute)) {
				$object->$attribute = clean_text($value);
			}						
		}		
		return $object;
	}
	
  private function has_attribute($attribute) {
		$object_vars = $this->attributes();
		return $object_vars;//temporary solution
	  return array_key_exists($attribute, $object_vars);
	}
	
	protected function attributes() {
	  $attributes = [];
		$object_vars = get_object_vars($this);	 foreach(static::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
		return $attributes;
	}
 
	protected function sanitized_attributes() {
		global $database;
		$clean_attributes = [];
		foreach($this->attributes() as $key => $value):
			if (!is_numeric($value)) {
				$clean_attributes[$key] = $database->escape_value($value);
			} else {
				$clean_attributes[$key] = $value;
			}			
		endforeach;
		return $clean_attributes;
	}
	
	public function save($input = 0) {
		return isset($this->id) ? $this->update() : $this->create_prepared();
	}
	
	public function create() {
		global $database;
		$attributes = $this->sanitized_attributes();
		array_shift($attributes); //deletes id
		array_pop($attributes); //deletes brand_title
		$sql  = "INSERT INTO ".static::$table_name." (";
		$sql .= implode(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
    $sql .= implode("', '", array_values($attributes));
		$sql .= "')";
		if($database->query($sql)) {
			$this->id = $database->insert_id();
			return true;
		} else {
			return false;
		}
	}
	
	private function check_var_type($array) {
		$checked_array       = [];
		foreach ($array as $val) {
			if (is_string($val)) {
				$checked_array[] = 's';
			} elseif(is_numeric($val)) {
				$checked_array[] = 'i';
			} 
	  }
		return $checked_array;
	}
	
	public function init_prepared_stmt() {
		$attributes = $this->sanitized_attributes();
		array_shift($attributes); //deletes id
//  temporary solution, unfortunately not flexible
		if(static::$table_name == "products") {
			array_pop($attributes); //deletes brand_title
		}
		if($this->id && !$this->multi_images) {		
//&& !$this->multi_images	tmp solution for multi image loading
			$attributes_pairs    = [];
		  foreach($attributes as $key => $value) {
			  $attribute_pairs[] = "{$key} = ?";
		  }
			$array        = ["attributes"=>$attributes, "values"=>$attribute_pairs];
		} else {
		  $placeholders = array_fill(0, count($attributes), '?');
			$array        = ["attributes"=>$attributes, "values"=>$placeholders];
		}	
		return $array;
	}
	
	public function create_prepared() {
	  global $database;
		$array         = $this->init_prepared_stmt();
		$attributes    = $array["attributes"];
		$placeholders  = $array["values"];		
		$sql           = "INSERT INTO ".static::$table_name." (";
		$sql          .= implode(", ", array_keys($attributes));
		$sql          .= ") VALUES (";
    $sql          .= implode(", ", $placeholders);
		$sql          .= ")";
//		echo $sql;
		$affected_rows = $this->prepared_stmt($sql, $attributes);
		if ($affected_rows == 1) { 
	    $this->id    = $database->insert_id;
//	  	return true;
	  } else { 
	  	echo "it did not work...";
	  	return false;
	  }
  }
		
	public function prepared_stmt($sql, $attributes) {
		global $database;
		$stmt         = $database->prepare($sql);
		$database->confirm_query($stmt);
    $params       = []; 
    foreach ($attributes as &$value) { 
      $params[]   = &$value;
    }
    if($this->id && !$this->multi_images) {
//&& !$this->multi_images	tmp solution for multi image loading
			$id           = $database->escape_value($this->id);
      $types_string = implode('', $this->check_var_type($attributes)) . "i";
		  $types        = (array)$types_string;
		  $values       = array_merge($types, $params);
      $values[]     = &$id;
    } else {      	
      $types[]      = implode('', $this->check_var_type($attributes));
      $values       = array_merge($types, $params);
    }
		
//		$types[]      = implode('', $this->check_var_type($attributes));
//      $values       = array_merge($types, $params);
//		var_dump($types);
    call_user_func_array(array($stmt, 'bind_param'), $values); 
    $stmt->execute();
		$affected_rows  = $stmt->affected_rows;
		$stmt->close();
		return $affected_rows;    
	}
	
	public function update() {
		global $database;
		$attributes = $this->sanitized_attributes();
		array_shift($attributes); //deletes id
		array_pop($attributes); //deletes brand_title
		$attributes_pairs = [];
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql  = "UPDATE ".static::$table_name." SET ";
    $sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function update_prepared() {
		global $database;
		$array           = $this->init_prepared_stmt();
		$attributes      = $array["attributes"];
		$attribute_pairs = $array["values"];		
    $sql             = "UPDATE ".static::$table_name." SET ";
    $sql            .= join(", ", $attribute_pairs);
		$sql            .= " WHERE id = ?";
		$sql            .= " LIMIT 1";
		$affected_rows   = $this->prepared_stmt($sql, $attributes);
		if ($affected_rows == 1) {
	  	return true;
	  } else { 
	  	echo "it did not work...";
	  	return false;
	  }
	}
	
	public function delete() {
		global $database;
		$sql  = "DELETE FROM ".static::$table_name;
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);
//		echo $database->affected_rows();
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function delete_prepared() {
		global $database;
    $id   = $database->escape_value($this->id);
		$sql  = "DELETE FROM ".static::$table_name;
		$sql .= " WHERE id = ? ";
		$sql .= " LIMIT 1";  
    $stmt = $database->prepare($sql);
	  $stmt->bind_param("i", $id);
    $stmt->execute();     
		$affected_rows = $stmt->affected_rows;
		$stmt->close();
		if ($affected_rows == 1) {
			$this->reset_id();//will be deleted
			return true;
		} else {
			return false;
		}		
//		return ($database->affected_rows == 1) ? true : false;
	}
	
	public function reset_id() {		
	  global $database;
		$sql  = "SET @count = 0;";
		$sql .= "UPDATE products SET products.id = @count:= @count + 1;";
		$sql .= "ALTER TABLE products AUTO_INCREMENT = 1;";
    $database->multi_query($sql);		
		return true;
  }
	
  abstract protected static function get_fields_name();	
}