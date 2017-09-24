<?php
error_reporting(E_ALL);
require_once("functions.php");
require_once("dbobject.php");

class Product extends DBObject {
	
	protected $tableName  = "products";
	protected $innerTable = "brands";
	protected $tableImage = "images";
	
	protected $dbFields;
	public $multi =0;
	public $id;
  public $brandId;
	public $title;
	public $price;
	public $newPrice;
	public $newOne;
	public $quantity;
	public $visible;
	public $description;
	public $shortDescription;
	public $image;
	public $keywords;
  public $brandTitle;
	public $type;
	public $size;
	private $tempPath;
  public $caption;
	public $cartQuantity;
	
	// @ 'dbFields' used for select mysql command, 'dbFieldsJoin' used for insert/update/delete mysql commands
	// @ it's done to avoid error of different number of mysql table fields and object attributes
	// @ that's why u can find additional flag $join on some functions
	public function __construct(DB $db)         {
		$this->con      = $db;
		$this->dbFields = [ 
												'dbFields'     => $this->getFieldsName(false), 
												'dbFieldsJoin' =>	$this->getFieldsName()
		];
	}
	
//	public function save($file = 0)             {
//		$image = new Uploads($this->con);		
//		if($this->create() && $image->saveMultipleFile($file, $this->id)) 
//			return true;		
//		return false;		
//	}
	
	// @queries
	
	/* @dev */
	public static function findImages()         {
		$sql  = "SELECT * FROM ";
		$sql .=	"images";
		$sql .= " GROUP BY ";
		$sql .= "productId";
		
		return self::findBySql($sql);
	}
	
	public static function findAllImages()      {
		$sql  = "SELECT * FROM ";
		$sql .=	"images";
		
		return self::findBySql($sql);
	}	
	/* * */
	
	public function findAllPaginated($perPage = 1, $offset = 0, $sortArray = 0)                 {
    $sql = "SELECT "
	          .$this->tableName.".id,"
		        .$this->tableName.".title,"
						.$this->tableImage.".image,"
						.$this->tableImage.".caption,"
		        .$this->tableName.".price,"
						.$this->tableName.".newPrice,"
		        .$this->tableName.".newOne,"
		        .$this->tableName.".quantity,"
		        .$this->tableName.".visible,"
		        .$this->innerTable.".brandTitle
		        FROM ";
		$sql .= $this->tableName;
		
		// @images table
		$sql .=	" INNER JOIN ";
		$sql .=	$this->tableImage;
		$sql .=	" ON ";
		$sql .= $this->tableImage.".productId=".$this->tableName.".id";
		$sql .= " AND ";
		$sql .= $this->tableImage.".id=";
		$sql .= "(SELECT MIN(";
		$sql .= $this->tableImage.".id";
		$sql .= ")";
		$sql .= " FROM ";
		$sql .= $this->tableImage;
		$sql .= " WHERE ";
		$sql .= $this->tableImage.".productId=".$this->tableName.".id";
		$sql .= ") ";
		
		// @brands table		
		$sql .=	" INNER JOIN ";
		$sql .=	$this->innerTable;
		$sql .=	" ON ";
		$sql .= $this->innerTable.".id=".$this->tableName.".brandId";
		$sql .= $this->switcher($sortArray);
		$sql .= " LIMIT {$perPage} ";
		$sql .= "OFFSET {$offset}";
		return $this->findBySql($sql);
	}
	
	private function switcher($sortArray = 0)                                                   {
		switch($sortArray[0]) : 
      case 'price': 
        $sql  = " ORDER BY price";			
        break;
		  case 'title': 
        $sql  = " ORDER BY ".$this->tableName.".title";			
        break;  
      default:
		  	$sql  = "";
    endswitch;
		if($sortArray[1] == "desc" && $sortArray[0] !== 0)
			$sql .= " DESC";	

		return $sql;
	}
	
	/*TODO*/
	public function findAllItemsByBrand ($id = 0, $lim = 0, $rand = false)                      {		
    $sql = "SELECT "
	          .$this->tableName.".id,"
		        .$this->tableName.".title,"
						.$this->tableImage.".image,"
						.$this->tableImage.".caption,"
		        .$this->tableName.".price,"
						.$this->tableName.".newPrice,"
		        .$this->tableName.".newOne,"
		        .$this->tableName.".quantity,"
		        .$this->tableName.".visible,"
		        .$this->innerTable.".brandTitle
		        FROM ";
		$sql .= $this->tableName;
		
		// @images table	
		$sql .=	" INNER JOIN ";
		$sql .=	$this->tableImage;
		$sql .=	" ON ";
		$sql .= $this->tableImage.".productId=".$this->tableName.".id";
		$sql .= " AND ";
		$sql .= $this->tableImage.".id=";
		$sql .= "(SELECT MIN(";
		$sql .= $this->tableImage.".id";
		$sql .= ")";
		$sql .= " FROM ";
		$sql .= $this->tableImage;
		$sql .= " WHERE ";
		$sql .= $this->tableImage.".productId=".$this->tableName.".id";
		$sql .= ") ";
		
		// @brands table
		$sql .=	" INNER JOIN ";
		$sql .=	$this->innerTable;
		$sql .=	" ON ";
		$sql .= $this->innerTable.".id=".$this->tableName.".brandId";
		$sql .= " AND ";
		$sql .= $this->tableName.".brandId={$id}";
		if ($rand)
      $sql .= " ORDER BY RAND()";
    if ($lim)
      $sql .= " LIMIT 0, {$lim}"; 
		
		
		$resultArr = $this->findBySql($sql);
		return $resultArr;
  }
	
	public function findByPaginatedBrand($perPage = 1, $offset = 0, $brand = "", $rand = false) {
    $sql = "SELECT "
	          .$this->tableName.".id,"
		        .$this->tableName.".title,"
						.$this->tableImage.".image,"
						.$this->tableImage.".caption,"
		        .$this->tableName.".price,"
						.$this->tableName.".newPrice,"
		        .$this->tableName.".newOne,"
		        .$this->tableName.".quantity,"
		        .$this->tableName.".visible,"
		        .$this->innerTable.".brandTitle
		        FROM ";
		$sql .= $this->tableName;
		
		// @images table	
		$sql .=	" INNER JOIN ";
		$sql .=	$this->tableImage;
		$sql .=	" ON ";
		$sql .= $this->tableImage.".productId=".$this->tableName.".id";
		$sql .= " AND ";
		$sql .= $this->tableImage.".id=";
		$sql .= "(SELECT MIN(";
		$sql .= $this->tableImage.".id";
		$sql .= ")";
		$sql .= " FROM ";
		$sql .= $this->tableImage;
		$sql .= " WHERE ";
		$sql .= $this->tableImage.".productId=".$this->tableName.".id";
		$sql .= ") ";
		
		// @brands table	
		$sql .=	" INNER JOIN ";
		$sql .=	$this->innerTable;
		$sql .=	" ON ";
		$sql .= $this->innerTable.".id=".$this->tableName.".brandId";
		$sql .= " AND ";
		$sql .= $this->innerTable.".brandTitle=?";
		if ($rand)
      $sql .= " ORDER BY RAND()";
		$sql   .= " LIMIT {$perPage} ";
		$sql   .= "OFFSET {$offset}";
		
		$resultArr = $this->findBySql($sql, $brand);
		return $resultArr;
	}
	
	public function findBrands()                                                                {
		$sql  = "SELECT * FROM ";
		$sql .=	$this->innerTable;
		
		return $this->findBySql($sql);
	}
	
	public function findItemById($id = 0)                                                       {		
    $sql          = "SELECT "
	                  .$this->tableName.".id,"
		                .$this->tableName.".title,"
		                .$this->tableImage.".image,"
		                .$this->tableName.".price,"
						        .$this->tableName.".newPrice,"
		                .$this->tableName.".newOne,"
		                .$this->tableName.".quantity,"
		                .$this->tableName.".visible,"
						        .$this->tableName.".description,"
		                .$this->tableName.".shortDescription,"
		                .$this->tableImage.".caption,"
						        .$this->tableName.".keywords,"
		                .$this->innerTable.".brandTitle
		                FROM ";
		$sql         .= $this->tableName;
		
		// @images table	
		$sql         .=	" INNER JOIN ";
		$sql         .=	$this->tableImage;
		$sql         .=	" ON ";
		$sql         .= $this->tableName.".id=".$this->tableImage.".productId";
		
		// @brands table	
		$sql         .=	" INNER JOIN ";
		$sql         .=	$this->innerTable;
		$sql         .=	" ON ";
		$sql         .= $this->innerTable.".id=".$this->tableName.".brandId";
		$sql         .= " AND ";
		$sql         .= $this->tableName.".id=?";		
		$sql         .= " LIMIT 1";	  		
		
		$resultArr = $this->findBySql($sql, $id);
		return $resultArr;		
  }
	
	public function findItemByIds($ids = [])                                                    {		
		$placeholders = placeholders(count($ids));
		
    $sql = "SELECT "
		        .$this->tableName.".id,"
				    .$this->tableName.".title,"
				    .$this->tableImage.".image,"
						.$this->tableImage.".caption,"
				    .$this->tableName.".price,"
						.$this->tableName.".description,"
		        .$this->tableName.".shortDescription,"
				    .$this->innerTable.".brandTitle
				    FROM ";
		$sql .= $this->tableName;
		$sql .=	" INNER JOIN ";
		$sql .=	$this->tableImage;
		$sql .=	" ON ";
		$sql .= $this->tableImage.".productId=".$this->tableName.".id";
		$sql .= " AND ";
		$sql .= $this->tableImage.".id=";
		$sql .= "(SELECT MIN(";
		$sql .= $this->tableImage.".id";
		$sql .= ")";
		$sql .= " FROM ";
		$sql .= $this->tableImage;
		$sql .= " WHERE ";
		$sql .= $this->tableImage.".productId=".$this->tableName.".id";
		$sql .= ") ";
		$sql .=	" INNER JOIN ";
		$sql .=	$this->innerTable;
		$sql .=	" ON ";
		$sql .= $this->innerTable.".id=".$this->tableName.".brandId";
		$sql .= " AND ";
		$sql .= $this->tableName.".id IN ($placeholders)";
		
		return $this->findBySql($sql, $ids);
  }
	
	public function findItemByTitle($title = "")                                                {		
    $sql          = "SELECT "
	                  .$this->tableName.".id,"
		                .$this->tableName.".title,"
		                .$this->tableImage.".image,"
		                .$this->tableName.".price,"
						        .$this->tableName.".newPrice,"
		                .$this->tableName.".newOne,"
		                .$this->tableName.".quantity,"
		                .$this->tableName.".visible,"
						        .$this->tableName.".description,"
		                .$this->tableName.".shortDescription,"
		                .$this->tableImage.".caption,"
						        .$this->tableName.".keywords,"
		                .$this->innerTable.".brandTitle
		                FROM ";
		$sql         .= $this->tableName;
		
		// @images table	
		$sql         .=	" INNER JOIN ";
		$sql         .=	$this->tableImage;
		$sql         .=	" ON ";
		$sql         .= $this->tableName.".id=".$this->tableImage.".productId";
		
		// @brands table
		$sql         .=	" INNER JOIN ";
		$sql         .=	$this->innerTable;
		$sql         .=	" ON ";
		$sql         .= $this->innerTable.".id=".$this->tableName.".brandId";
		$sql         .= " AND ";		
		 $sql        .= $this->tableName.".title = ?";		
//		  $sql       .= " LIMIT 1";	  		
		
		$resultArr  = $this->findBySql($sql, $title);
		return $resultArr;		
  }	
	
	protected function getFieldsName($join = true)                                              {
	  $sql  = "SELECT * FROM ";
		$sql .= $this->tableName;
		if($join == true) :
		  $sql .=	" INNER JOIN ";
		  $sql .=	$this->tableImage;
			$sql .=	" ON ";
		  $sql .= $this->tableImage.".productId=".$this->tableName.".id";	
		  $sql .=	" INNER JOIN ";
		  $sql .=	$this->innerTable;
		  $sql .=	" ON ";
		  $sql .= $this->innerTable.".id=".$this->tableName.".brandId";	
		endif;
		
    $result = DB::$con2->query($sql);
		$finfo  = $this->con->fetchFields($result);
		
		$dbFields = [];
	  foreach($finfo as $val) {
      $dbFields[]= $val->name;
    }
		
		return $dbFields;
	}	
	
}

$product = new Product($database);