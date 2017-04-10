<?php
require_once("initialize.php");

class Uploads extends DbObject {
	
	protected static $table_name = "images";
	protected static $db_fields;
//tmp solution to save images => look out on the dbobject class
	public  $multi_images         = 1; 
	public  $id;
	public  $product_id;
	public  $image;
	public  $type;
	public  $size;
	private $temp_path;
  public  $caption;
	
	function __construct() {
		self::$db_fields = self::get_fields_name();
	}
	
	private	function get_caption() {
	  $pos           = strpos($this->image, ".");
	  $this->caption = substr($this->image, 0, $pos);
  }
	
	//for uploading a single file first initialize attach_file function then save || update
	//but fo multiple it should be made in one function i guess atm
	public function save_multiple_file($file, $id) {
		foreach($file['tmp_name'] as $key => $tmp_name ) {
		  if(!$file || empty($file) || !is_array($file)) {
		  	self::$errors[] = "No file was uploaded.";
		  	return false;
		  } elseif($file['error'][$key] != 0) {
		  	self::$errors[] = self::$upload_errors[$file['error'][$key]];
		  	return false;
		  } else {
				$this->temp_path = $file['tmp_name'][$key];
		    $this->image     = basename($file['name'][$key]);
		    $this->type      = $file['type'][$key];
		    $this->size      = $file['size'][$key];	
				$this->get_caption();
				$this->product_id = $id;
				
//temporary smart save/update function unavailable
				
//				if(isset($this->id)) {
//			$this->update_prepared();
//		} else {
			if(!empty(self::$errors)) { return false; }
			
			if(strlen($this->caption) > 255) {
				self::$errors[] = "The caption can only be 255 characters long.";
				return false;
			}
			
			if(empty($this->image) || empty($this->temp_path)) {
				self::$errors[] = "The file location was not available.";
				return false;
			}
			
			$target_path = SITE_ROOT.DS.'public'.DS.'assets'.DS.$this->image_path();
				
			if(file_exists($target_path)) {
				self::$errors[] = "The file {$this->image} already exists.";
				return false;
			}
			
			if(move_uploaded_file($this->temp_path, $target_path)) {
				if($this->create_prepared()) {
					unset($this->temp_path);
					
				}
			} else {
				self::$error[]  = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
				return false;
			}
			
		}
		  }
//		}
		return true;
	}
	
	public function destroy() {
		if($this->delete()) {
			$target_path = SITE_ROOT.DS.'public'.DS.$this->image_path();
			return unlink($target_path) ? true : false;
		} else {
			return false;
		}
	}
	
	public function image_path() {
		return self::$upload_dir.DS.$this->image;
	}	
	
	public function size_as_text() {
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
	
	protected	static function get_fields_name() {
		global $database;
	  $sql       = "SELECT * FROM ";
		$sql      .= self::$table_name;
    $result    = $database->query($sql);
		$finfo     = $result->fetch_fields();
		$db_fields = [];
	  foreach($finfo as $val) {
      $db_fields[] = $val->name;
    }
		return $db_fields;
	}	

}

$images = new Uploads();