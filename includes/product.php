<?php

class Product extends DbObject {
	
	protected static $table_name  = "products";
	protected static $inner_table = "brands";
	protected static $table_image = "images";
	
	protected static $db_fields;	
	public $id;	
	public $brand_id;
	public $title;
	public $price;
	public $new_price;
	public $new_one;
	public $quantity;
	public $visible;
	public $description;
	public $short_description;
	public $image;
	public $keywords;
  public $brand_title;
  public $cat_id;
	public $type;
	public $size;
	private $temp_path;
  public $caption;
	public $cart_quantity;
	public $total_price;
	
	function __construct() {
		self::$db_fields = self::get_fields_name();
	}
	
	public function save($file = 0) {	
		$this->create_prepared();
		$images = new Uploads();
		$images->save_multiple_file($file, $this->id);
		return true;
	}
	
	public function image_path() {
		return $this->upload_dir.DS.$this->image;
	}	
	
	public static function find_with_brand() {
		$sql = "SELECT "
		        .self::$table_name.".id,"
						.self::$table_name.".brand_id,"
						.self::$table_name.".title,"
						.self::$table_name.".image,"
						.self::$table_name.".price,"
						.self::$inner_table.".brand_title
						FROM ";
		$sql .= self::$table_name;
		$sql .=	" INNER JOIN ";
		$sql .=	self::$inner_table;
		$sql .=	" ON ";
		$sql .= self::$inner_table.".id=".self::$table_name.".brand_id";
		return self::find_by_sql($sql);
	}
	
	public static function find_with_pagination($per_page=1, $offset=0, $sort_array=0) {
$sql = "SELECT "
	          .self::$table_name.".id,"
		        .self::$table_name.".title,"
						.self::$table_image.".image,"
						.self::$table_image.".caption,"
		        .self::$table_name.".price,"
						.self::$table_name.".new_price,"
		        .self::$table_name.".new_one,"
		        .self::$table_name.".quantity,"
		        .self::$table_name.".visible,"
		        .self::$inner_table.".brand_title
		        FROM ";
		$sql .= self::$table_name;
		$sql .=	" INNER JOIN ";
		$sql .=	self::$table_image;
		$sql .=	" ON ";
		$sql .= self::$table_image.".product_id=".self::$table_name.".id";
		$sql .= " AND ";
		$sql .= self::$table_image.".id=";
		$sql .= "(SELECT MIN(";
		$sql .= self::$table_image.".id";
		$sql .= ")";
		$sql .= " FROM ";
		$sql .= self::$table_image;
		$sql .= " WHERE ";
		$sql .= self::$table_image.".product_id=".self::$table_name.".id";
		$sql .= ") ";
		$sql .=	" INNER JOIN ";
		$sql .=	self::$inner_table;
		$sql .=	" ON ";
		$sql .= self::$inner_table.".id=".self::$table_name.".brand_id";
		$sql .= self::switcher($sort_array);
		$sql .= " LIMIT {$per_page} ";
		$sql .= "OFFSET {$offset}";
		return self::find_by_sql($sql);
	}
	
	private static function switcher($sort_array=0) {
		switch($sort_array[0]){ 
    case 'price': 
      $sql  = " ORDER BY price";			
    break;
		case 'title': 
      $sql  = " ORDER BY ".self::$table_name.".title";			
    break;  
    default:
			$sql  = "";
    }
		if($sort_array[1] == "desc" && $sort_array[0] !== 0){
			$sql .= " DESC";	
		}
		return $sql;
	}
	
	public static function find_and_sort_by_price($per_page=1, $offset=0) {
    $sql  = "SELECT "
	          .self::$table_name.".id,"
		        .self::$table_name.".title,"
						.self::$table_image.".image,"
						.self::$table_image.".caption,"
		        .self::$table_name.".price,"
						.self::$table_name.".new_price,"
		        .self::$table_name.".new_one,"
		        .self::$table_name.".quantity,"
		        .self::$table_name.".visible,"
		        .self::$inner_table.".brand_title
		        FROM ";
		$sql .= self::$table_name;
		$sql .=	" INNER JOIN ";
		$sql .=	self::$table_image;
		$sql .=	" ON ";
		$sql .= self::$table_image.".product_id=".self::$table_name.".id";
		$sql .= " AND ";
		$sql .= self::$table_image.".id=";
		$sql .= "(SELECT MIN(";
		$sql .= self::$table_image.".id";
		$sql .= ")";
		$sql .= " FROM ";
		$sql .= self::$table_image;
		$sql .= " WHERE ";
		$sql .= self::$table_image.".product_id=".self::$table_name.".id";
		$sql .= ") ";
		$sql .=	" INNER JOIN ";
		$sql .=	self::$inner_table;
		$sql .=	" ON ";
		$sql .= self::$inner_table.".id=".self::$table_name.".brand_id";
		$sql .= " ORDER BY price";
		$sql .= " LIMIT {$per_page} ";
		$sql .= "OFFSET {$offset}";		
		return self::find_by_sql($sql);
	}
	
	public static function find_by_brand_with_pagination($per_page=1, $offset=0, $brand=0) {
    $sql = "SELECT "
	          .self::$table_name.".id,"
		        .self::$table_name.".title,"
						.self::$table_image.".image,"
						.self::$table_image.".caption,"
		        .self::$table_name.".price,"
						.self::$table_name.".new_price,"
		        .self::$table_name.".new_one,"
		        .self::$table_name.".quantity,"
		        .self::$table_name.".visible,"
		        .self::$inner_table.".brand_title
		        FROM ";
		$sql .= self::$table_name;
		$sql .=	" INNER JOIN ";
		$sql .=	self::$table_image;
		$sql .=	" ON ";
		$sql .= self::$table_image.".product_id=".self::$table_name.".id";
		$sql .= " AND ";
		$sql .= self::$table_image.".id=";
		$sql .= "(SELECT MIN(";
		$sql .= self::$table_image.".id";
		$sql .= ")";
		$sql .= " FROM ";
		$sql .= self::$table_image;
		$sql .= " WHERE ";
		$sql .= self::$table_image.".product_id=".self::$table_name.".id";
		$sql .= ") ";
		$sql .=	" INNER JOIN ";
		$sql .=	self::$inner_table;
		$sql .=	" ON ";
			if($brand) :
			  $sql .= self::$inner_table.".id=".self::$table_name.".brand_id";
			  $sql .= " AND ";
		    $sql .= self::$inner_table.".brand_title=?";
			else :
			  $sql .= self::$inner_table.".id=".self::$table_name.".brand_id";
			endif;	
		$sql .= " LIMIT {$per_page} ";
		$sql .= "OFFSET {$offset}";
			if($brand) :
			  $result_array = self::find_by_sql_prepared($sql, $brand);
		    return !empty($result_array) ? $result_array : false;
			else :
			  return self::find_by_sql($sql);
			endif;		
	}
	
	
		public static function find_with_brand_and_pagination($per_page=1, $offset=0, $brand="") {
		global $database;
    $sql = "SELECT "
	          .self::$table_name.".id,"
		        .self::$table_name.".title,"
		        .self::$table_name.".image,"
		        .self::$table_name.".price,"
						.self::$table_name.".new_price,"
		        .self::$table_name.".new_one,"
		        .self::$table_name.".quantity,"
		        .self::$table_name.".visible,"
						.self::$table_name.".description,"
		        .self::$table_name.".short_description,"
		        .self::$table_name.".image,"
		        .self::$table_name.".caption,"
						.self::$table_name.".keywords,"
		        .self::$inner_table.".brand_title
		        FROM ";
		$sql .= self::$table_name;
		$sql .=	" INNER JOIN ";
		$sql .=	self::$inner_table;
		$sql .=	" ON ";
			if($brand) :
			  $sql .= self::$inner_table.".id=?";
			else :
			  $sql .= self::$inner_table.".id=".self::$table_name.".brand_id";
			endif;		
		$sql .= " LIMIT {$per_page} ";
		$sql .= "OFFSET {$offset}";	
		  if($brand) :
			  $result_array = self::find_by_sql_prepared($sql, $brand);
		    return !empty($result_array) ? $result_array : false;
			else :
			  return self::find_by_sql($sql);
			endif;		
  }
	
	public static function find_brands () {
		$sql = "SELECT * FROM ";
		$sql .=	self::$inner_table;
		return self::find_by_sql($sql);
	}
	
	//dev 
	
	public static function find_images() {
		$sql  = "SELECT * FROM ";
		$sql .=	"images";
		$sql .= " GROUP BY ";
		$sql .= "product_id";
		return self::find_by_sql($sql);
	}
	
	public static function find_all_images() {
		$sql  = "SELECT * FROM ";
		$sql .=	"images";
		return self::find_by_sql($sql);
	}
	
	//dev ends
	
	public static function find_item_by_id ($id=0) {
    $sql = "SELECT "
		        .self::$table_name.".id,"
				    .self::$table_name.".title,"
				    .self::$table_name.".image,"
				    .self::$table_name.".price,"
				    .self::$inner_table.".brand_title
				    FROM ";
		$sql .= self::$table_name;
		$sql .=	" INNER JOIN ";
		$sql .=	self::$inner_table;
		$sql .=	" ON ";
		$sql .= self::$inner_table.".id=".self::$table_name.".brand_id";
		$sql .= " AND ";
		$sql .= self::$table_name.".id={$id}";
		$sql .= " LIMIT 1";
		$result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;    
  }
	
	public static function find_item_by_id_stmt ($id=0) {
		global $database;
    $sql          = "SELECT "
	                  .self::$table_name.".id,"
		                .self::$table_name.".title,"
		                .self::$table_image.".image,"
		                .self::$table_name.".price,"
						        .self::$table_name.".new_price,"
		                .self::$table_name.".new_one,"
		                .self::$table_name.".quantity,"
		                .self::$table_name.".visible,"
						        .self::$table_name.".description,"
		                .self::$table_name.".short_description,"
		                .self::$table_image.".caption,"
						        .self::$table_name.".keywords,"
		                .self::$inner_table.".brand_title
		                FROM ";
		$sql         .= self::$table_name;
		$sql         .=	" INNER JOIN ";
		$sql         .=	self::$table_image;
		$sql         .=	" ON ";
		$sql         .= self::$table_name.".id=".self::$table_image.".product_id";
		$sql         .=	" INNER JOIN ";
		$sql         .=	self::$inner_table;
		$sql         .=	" ON ";
		$sql         .= self::$inner_table.".id=".self::$table_name.".brand_id";
		$sql         .= " AND ";
		$sql         .= self::$table_name.".id=?";
		$result_array = self::find_by_sql_prepared($sql, $id);
		return !empty($result_array) ? $result_array : false;		
  }
	
	public static function find_item_by_title ($id=0) {
		global $database;
    $sql          = "SELECT "
	                  .self::$table_name.".id,"
		                .self::$table_name.".title,"
		                .self::$table_image.".image,"
		                .self::$table_name.".price,"
						        .self::$table_name.".new_price,"
		                .self::$table_name.".new_one,"
		                .self::$table_name.".quantity,"
		                .self::$table_name.".visible,"
						        .self::$table_name.".description,"
		                .self::$table_name.".short_description,"
		                .self::$table_image.".caption,"
						        .self::$table_name.".keywords,"
		                .self::$inner_table.".brand_title
		                FROM ";
		$sql         .= self::$table_name;
		$sql         .=	" INNER JOIN ";
		$sql         .=	self::$table_image;
		$sql         .=	" ON ";
		$sql         .= self::$table_name.".id=".self::$table_image.".product_id";
		$sql         .=	" INNER JOIN ";
		$sql         .=	self::$inner_table;
		$sql         .=	" ON ";
		$sql         .= self::$inner_table.".id=".self::$table_name.".brand_id";
		$sql         .= " AND ";
		$sql         .= self::$table_name.".title=?";
		$result_array = self::find_by_sql_prepared($sql, $id);
		return !empty($result_array) ? $result_array : false;		
  }
	
  public static function find_all_items_by_brand ($id=0, $lim=0, $rand=false) {
		global $database;
    $sql = "SELECT "
	          .self::$table_name.".id,"
		        .self::$table_name.".title,"
						.self::$table_image.".image,"
						.self::$table_image.".caption,"
		        .self::$table_name.".price,"
						.self::$table_name.".new_price,"
		        .self::$table_name.".new_one,"
		        .self::$table_name.".quantity,"
		        .self::$table_name.".visible,"
		        .self::$inner_table.".brand_title
		        FROM ";
		$sql .= self::$table_name;
		$sql .=	" INNER JOIN ";
		$sql .=	self::$table_image;
		$sql .=	" ON ";
		$sql .= self::$table_image.".product_id=".self::$table_name.".id";
		$sql .= " AND ";
		$sql .= self::$table_image.".id=";
		$sql .= "(SELECT MIN(";
		$sql .= self::$table_image.".id";
		$sql .= ")";
		$sql .= " FROM ";
		$sql .= self::$table_image;
		$sql .= " WHERE ";
		$sql .= self::$table_image.".product_id=".self::$table_name.".id";
		$sql .= ") ";
		$sql .=	" INNER JOIN ";
		$sql .=	self::$inner_table;
		$sql .=	" ON ";
		$sql .= self::$inner_table.".id=".self::$table_name.".brand_id";
		$sql .= " AND ";
		$sql .= self::$table_name.".brand_id=?";
		if ($rand !== 0) {
      $sql .= " ORDER BY RAND()";        
    }
    if ($lim !== 0) {
      $sql .= " LIMIT 0, {$lim}";        
    }      
		$result_array = static::find_by_sql_prepared($sql, $id);
		return !empty($result_array) ? $result_array : false;
  }
	
	protected static function get_fields_name() {
		global $database;
	  $sql = "SELECT * FROM ";
		$sql .= self::$table_name;
		$sql .=	" INNER JOIN ";
		$sql .=	self::$inner_table;
		$sql .=	" ON ";
		$sql .= self::$inner_table.".id=".self::$table_name.".brand_id";
    $result = $database->query($sql);
		$finfo = $result->fetch_fields();
		$db_fields=[];
	  foreach($finfo as $val) {
      $db_fields[]= $val->name;
    }
				
		// maybe change $sql without id and cat_id key and delete the below code
		$arlen = count($db_fields);
		unset($db_fields[$arlen-2]);//deletes id key in brand table
		unset($db_fields[$arlen-3]);//deletes cat_id key in brand table
		return $db_fields;
	}	
}

$product = new Product();