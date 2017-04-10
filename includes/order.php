<?php
require_once("initialize.php");
class Order extends DbObject {
	
	protected static $table_name    = "orders";
	protected static $inner_table   = "products";
	protected static $inner_table_2 = "brands";
	protected static $db_fields;	
	public $id;
	public $prod_id;
	public $quantity;
	public $order_id;

	function __construct() {
		self::$db_fields = self::get_fields_name();
	}			

	public static function save_order() {
		global $database;
    $products          = Cart::my_cart();
		foreach($products as $item) {
			$order           = new self();
			$order->prod_id  = $item->id;
	    $order->quantity = Cart::$cart[$item->id];
	    $order->order_id = Cart::$cart['orderid'];
      $order->create_prepared();
    }		
    setcookie("cart", "", 1);
		return $order->order_id;
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
	
	public static function find_orders($orderid) {//WIP
    global $database;
//    $sql = "SELECT title, image, brand_title, price, orders.quantity, order_id
//              FROM products              
//              INNER JOIN brands
//              ON brands.id=products.brand_id
//              INNER JOIN orders
//              ON orders.prod_id=products.id and orders.order_id = ?";
		$sql  = "SELECT "
		        .self::$inner_table.".title,"
//						.self::$inner_table.".image,"
						.self::$inner_table.".price,"
						.self::$table_name.".quantity,"
						.self::$table_name.".order_id,"
						.self::$inner_table_2.".brand_title
						FROM ";
		$sql .= self::$inner_table;
		$sql .=	" INNER JOIN ";
		$sql .=	self::$inner_table_2;
		$sql .=	" ON ";
		$sql .= self::$inner_table_2.".id=".self::$inner_table.".brand_id";
	  $sql .=	" INNER JOIN ";
		$sql .=	self::$table_name;
		$sql .=	" ON ";
		$sql .= self::$table_name.".prod_id=".self::$inner_table.".id";
	  $sql .=	" AND ";
		$sql .= self::$table_name.".order_id=?";
    $result_array = self::find_by_sql_prepared($sql, $orderid);
		return !empty($result_array) ? $result_array : false;  
  }

}

$order = new Order();
//$orders = Order::find_orders("584043de8f513");
//var_dump($orders);