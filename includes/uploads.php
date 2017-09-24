<?php
require_once("initialize.php");

class Uploads extends dbObject {
	
	protected $tableName = "images";
	protected $dbFields;
//tmp solution to save images => look out on the dbobject class
//	protected  $multi         = 1; 
	public  $attrArr = [];
	public  $id;
	public  $productId;
	public  $image;
	public  $type;
	public  $size;
	private $tempPath;
  public  $caption;
	
	public function __construct($db) {
		$this->con    = $db;
		$this->dbFields      = [
			                      'dbFields'     => $this->getFieldsName(false), 
														'dbFieldsJoin' =>	$this->getFieldsName()
		];
	}
	
	
	
	

	
	
//	public function runStmt($sql, $values)                  {	
//		$this->con->myCommit();
//		// @prepare stmt
//		$stmt          = $this->con->prepared($sql);
//		// @bind_param stmt
//		foreach($values as $value) {
//		call_user_func_array(array($stmt, 'bind_param'), $value); 
//		
//		
//		
//		// @execute stmt
//    $this->con->stmtExecute($stmt);	
//		$affectedRows = $this->con->affectedRows();
//		}
//		// @close stmt
//		$this->con->closeStmt($stmt);
//		$this->con->commit();
//		return $affectedRows;    
//	}
	
//	public function create($paramts=0)                                {
//		[$attr, $placeholders, $values] = $this->prepareValues(0,$paramts);
//		
//		$sql           = "INSERT INTO ";
//		$sql          .= $this->tableName;
//		$sql          .= " (";
//		$sql          .= implode(", ", array_keys($attr));
//		$sql          .= ") VALUES (";
//    $sql          .= $placeholders;
//		$sql          .= ")";
//		
//		$affectedRows  = $this->runStmt($sql, $values);		
//		if ($affectedRows == 1) : 
//	    $this->id    = $this->con->insertId();//#conflict with multi queries
//	  	return true;
//		endif;		
//	  return false;
//  }
	
	
	//improve this one!
	private	function getCaption() {
	  $pos           = strpos($this->image, ".");
	  $this->caption = substr($this->image, 0, $pos);
  }
	
	//for uploading a single file first initialize attach_file function then save || update
	//but fo multiple it should be made in one function i guess atm
	public function saveMultipleFile($file, $id) {
		$paramts = [];
		
		foreach($file['tmp_name'] as $key => $tmpName ) :
		  if(!$file || empty($file) || !is_array($file)) {
		  	self::$errors[] = "No file was uploaded.";
		  	return false;
		  } elseif($file['error'][$key] != 0) {
		  	self::$errors[] = $this->uploadErrors[$file['error'][$key]];
		  	return false;
		  } else {
				$this->tempPath  = $file['tmp_name'][$key];
		    $this->image     = basename($file['name'][$key]);
		    $this->type      = $file['type'][$key];
		    $this->size      = $file['size'][$key];	
				$this->getCaption();
				$this->productId = $id;
				
					
			if(!empty(self::$errors)) 
					return false;
			
			if(strlen($this->caption) > 255) {
				self::$errors[] = "The caption can only be 255 characters long.";
				return false;
			}
			
			if(empty($this->image) || empty($this->tempPath)) {
				self::$errors[] = "The file location was not available.";
				return false;
			}
			
			$targetPath = SITE_ROOT.DS.'public'.DS.'assets'.DS.$this->imagePath();
				
			if(file_exists($targetPath)) {
				self::$errors[] = "The file {$this->image} already exists.";
				return false;
			}
			
			if(move_uploaded_file($this->tempPath, $targetPath)) {

				$this->attrArr[] = [
					          $this->productId, 
					          $this->image, 
					          $this->caption, 
					          $this->type, 
					          $this->size
				];
				unset($this->tempPath);					
				
			} else {
				$this->error[]  = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
				return false;
			}
			
		}
		  endforeach;
		
		if($this->save())  return true;
//		}
		return true;
	}
	
	public function destroy() {
		if($this->delete()) {
			$targetPath = SITE_ROOT.DS.'public'.DS.$this->imagePath();
			return unlink($targetPath) ? true : false;
		} else {
			return false;
		}
	}
	
	public function imagePath() {
		return $this->uploadDir.DS.$this->image;
	}	
	
	public function sizeAsText() {
		if($this->size < 1024) {
			return "{$this->size} bytes";
		} elseif($this->size < 1048576) {
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($this->size/1048576, 1);
			return "{$size_mb} MB";
		}
	}
	
	protected	function getFieldsName() {
	  $sql       = "SELECT * FROM ";
		$sql      .= $this->tableName;
    $result    = DB::$con2->query($sql);
		$finfo     = $this->con->fetchFields($result);
		$dbFields = [];
	  foreach($finfo as $val) {
      $dbFields[] = $val->name;
    }
		return $dbFields;
	}	

}

$images = new Uploads($database);
//
//$img = $images->findAll();
//echo "<pre>";
//var_dump($img[0]);