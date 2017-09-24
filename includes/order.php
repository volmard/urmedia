<?php
require_once("initialize.php");

class Order extends DbObject {
	
	protected $tableName   = "orders";
	protected $innerTable  = "products";
	protected $innerTable2 = "brands";
	protected $dbFields;	
	public $id;
	public $prodId;
	public $quantity;
	public $orderId;
	public $title;
	public $price;
	private  $multi         = 1;

	public function __construct($db)       {
		$this->con         = $db;
		$this->dbFields      = [
			                      'dbFields'     => $this->getFieldsName(false), 
														'dbFieldsJoin' =>	$this->getFieldsName()
		];
	}		

	public static function saveOrder()               {
    $products         = Cart::myCart();
		$order = new self(static::$con);
		foreach($products as $item) :
			$order->prodId   = $item->id;
	    $order->quantity = Cart::$cart[$item->id];
	    $order->orderId  = Cart::$cart['orderId'];
		  
      $order->createPrepared();
    endforeach;		
    setcookie("cart", "", 1);
		return $order->orderId;
	}
 
  protected function getFieldsName($join = true) {
	  $sql      = "SELECT * FROM ";
		$sql     .= $this->tableName;
		if($join == true) :
		  $sql .=	" INNER JOIN ";
		  $sql .=	$this->innerTable;
		  $sql .=	" ON ";
		  $sql .= $this->innerTable.".id=".$this->tableName.".prodId";	
			$sql .=	" INNER JOIN ";
		  $sql .=	$this->innerTable2;
		  $sql .=	" ON ";
		  $sql .= $this->innerTable.".brandid=".$this->innerTable2.".Id";	
		endif;
    $result   = DB::$con2->query($sql);
		$finfo    = $this->con->fetchFields($result);
		
		$dbFields = [];
	  foreach($finfo as $val) {
      $dbFields[] = $val->name;
    }
		return $dbFields;
	}
	
	public function findOrders($orderid)      {
		$sql  = "SELECT "
		        .$this->innerTable.".title,"
//						.$this->innerTable.".image,"
						.$this->innerTable.".price,"
						.$this->tableName.".quantity,"
						.$this->tableName.".orderId,"
						.$this->innerTable2.".brandTitle
						FROM ";
		$sql .= $this->innerTable;
		$sql .=	" INNER JOIN ";
		$sql .=	$this->innerTable2;
		$sql .=	" ON ";
		$sql .= $this->innerTable2.".id=".$this->innerTable.".brandId";
	  $sql .=	" INNER JOIN ";
		$sql .=	$this->tableName;
		$sql .=	" ON ";
		$sql .= $this->tableName.".prodId=".$this->innerTable.".id";
	  $sql .=	" AND ";
		$sql .= $this->tableName.".orderId = ?";
		
    $resultArr = $this->findBySqlPrepared($sql, $orderid);
		return $resultArr;  
  }

}

$order = new Order($database);
//$orders = $order->findOrders("58d8eb1de6449");
//echo "<pre>";
//var_dump($orders[0]);