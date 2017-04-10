<?php

class Cart extends Product {
	
//  private 
	public static $cart   = [];
	public static $amount = 0;
	public static $sum    = 0;	
	
  private static function save_cart() {
		self::$cart = base_serialize(self::$cart);
		setcookie('cart', self::$cart, 0x7FFFFFFF, '/'); 		
  }
	
	function __construct() {
		$this->cart_init();
		self::add_to_cart();
	}
	
	private function cart_init() {
    if (!isset($_COOKIE['cart'])) {
			self::$cart['orderid'] = uniqid();
      $this->save_cart();  
    } else {
			self::$cart   = base_serialize($_COOKIE['cart'], "decode");
      self::$amount = count(self::$cart) - 1;
    }
  }
	
  public static function add_to_cart($link = "") { 		
    if(isset($_GET["add_cart"])){     
      $id              = (int)$_GET["add_cart"];
			self::$cart[$id] = 1;
      self::save_cart();
			$link = $_SERVER["REQUEST_URI"];
	    $link = substr($link, 0, strpos($link, '?a'));
      redirect_to($link);
    } else {
        //
    }
  }
	
	private static function find_card_item_by_ids($ids) {
		$placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT "
		        .self::$table_name.".id,"
				    .self::$table_name.".title,"
				    .self::$table_image.".image,"
						.self::$table_image.".caption,"
				    .self::$table_name.".price,"
						.self::$table_name.".description,"
		        .self::$table_name.".short_description,"
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
		$sql .= self::$table_name.".id IN ($placeholders)";
		return self::find_by_sql_prepared($sql, $ids);
  }
	
	private static function cart_ids() {
		$ids = array_keys(self::$cart);
    array_shift($ids); 		
		return !$ids ? false : $ids;
	}
	
  public static function my_cart() {
    global $database;
    $ids      = self::cart_ids();
		$products = self::find_card_item_by_ids($ids);
		foreach ($products as $product) {
//			 must decide do i need extra object attributes cart-quantity and total-price???
//			if no, then just set cookies vars directly into code
//			the same problem marked bellow as *
			$product->cart_quantity = self::$cart[$product->id];
		}	
		return $products;
  }
	    
  public static function delete_item_from_cart() {        
     if (isset($_GET["id"])) {
      $id = (int) $_GET["id"];  
      unset(self::$cart[$id]);			 
      self::save_cart();			
			redirect_to("/cart/");			 
     } else {
       // 
     }
  }
	
	public static function summary($item) {		
		$item->total_price = $item->price * $item->cart_quantity;//*
//		$item->total_price = $item->price * Cart::$cart[$item->id];//*
		self::$sum  += $item->total_price;
	}
	
	public static function update_cart($items) {
	  if(isset($_POST["update"])){
      foreach ($items as $item) {
         $quantity                = "quantity".$item->id;
         $item->cart_quantity     = $_POST[$quantity];         
         if (array_key_exists($item->id, Cart::$cart)) {
           Cart::$cart[$item->id] = (int)$item->cart_quantity;
         }
       }
       Cart::save_cart();
       redirect_to($_SERVER['REQUEST_URI']); 
     } else {
			 //
		 }
	}
		
//	WIP function
//	u can get order page outside of cart page
//	finish it or make another solution
//	for example user can't get the orderpage directly, only from cart page, then current function will be unneseccary
//	on that way you can release for example next one
//	if(!isset($_SESSION['summary']) {redirect to cart.php}
	
	public static function set_cart_sum($item = "") {
		$path     = $_SERVER['REQUEST_URI'];
		$pagename = basename($path, ".php");
		if(self::$amount != 0 && self::$sum == 0) {
			$items  = self::my_cart();
		  foreach($items as $item) :
		    self::summary($item);
		  endforeach;
			$_SESSION['summary'] = self::$sum;
	  } elseif(isset($_GET["pid"]) && $_GET['pid'] == "cart" || $pagename == "cart") {
		  self::summary($item);
	  } elseif(isset($_SESSION['summary'])) {
			self::$sum = $_SESSION['summary'];
		}
  }
	
	public static function add_link($id=0) {
	  global $self;
    if(isset($_GET["pid"])) :
      $link = "{$self}&add_cart={$id}";
      else :
        $link = "{$self}?add_cart={$id}";  
    endif;
    return $link;   
   }	

}

$cart = new Cart();