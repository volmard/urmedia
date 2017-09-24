<?php
require_once("product.php");

class Cart {
	
	public static $cart   = [];
	public static $amount = 0;
	public static $sum    = 0;	
	
 	public function __construct()                        {
		self::cartInit();
		self::addToCart();
	}
	
	private static function saveCart()                   {
		self::$cart = baseSerialize(self::$cart);
		/***@webhost***/
//		setcookie('cart', self::$cart, 0x7FFFFFFF, '/'); 		
		
		/***@dev***/
		setcookie('cart', self::$cart, 0x7FFFFFFF);
  }
	
	private static function cartInit()                   {
    if (!isset($_COOKIE['cart'])) :
			self::$cart['orderId'] = uniqid();
      self::saveCart();  
    else :
			self::$cart   = baseSerialize($_COOKIE['cart'], "decode");
      self::$amount = count(self::$cart) - 1;
    endif;
  }
	
  public static function addToCart($query = "addCart") { 	
		$id = $_GET[$query] ?? null;
		if($id) :
		  $id = (int) $id;  
			self::$cart[$id] = 1;
      self::saveCart();	
		
			$link = $_SERVER["REQUEST_URI"];
		  $link = strstr($link, '?'.$query, true);
			
			/***delete on the webhost***/
			if (isset($_GET['pid'])) :
				$link = $_SERVER["REQUEST_URI"];
		    $link = strstr($link, '&'.$query, true);
			else :
				$link = "index.php"; 
			endif;
			/***/
		  redirect_to($link);
		else:
		  //
		endif;
  }	
	
	public static function getIds()                      {
		$ids = array_keys(self::$cart);
    array_shift($ids); 		
		return $ids ? $ids : false;
	}
	
  public static function setItemQuantity($items)       {
		foreach ($items as $item) 
			$item->cartQuantity = self::$cart[$item->id];
		return $items;
  }
	    
	private static function updateItemQuantity($items)   {	  
    foreach ($items as $item) :
      $quantity                = "quantity".$item->id;       
      if (array_key_exists($item->id, Cart::$cart))
        Cart::$cart[$item->id] = (int)$_POST[$quantity];
    endforeach;
    Cart::saveCart();
    redirect_to($_SERVER['REQUEST_URI']); 
	}
	
  private static function deleteItem($id)              {	    
      $id = (int) $id;  
      unset(self::$cart[$id]);			 
      self::saveCart();			
      
		  //redirect_to("/cart/");	
		
			/***delete on the webhost***/		
      redirect_to("index.php?pid=cart");			
  }
	
	public static function updateCart($items)            {
		$id = $_GET["id"] ?? null;
		if($id) :
		  self::deleteItem($id);
		else :
       // 
    endif;
		
		if(isset($_POST["update"])) :
		  self::updateItemQuantity($items);
		else :
		//
		endif;				
	}
	
	public static function summary($item)                {	
		self::$sum       += $item->price * $item->cartQuantity;
	}
			
	public static function setSum($item = "")            {
		if($item) :
			self::summary($item);
			$_SESSION['summary'] = self::$sum;
		else :
		  self::$sum = $_SESSION['summary'];
		endif;
  }
	
	//@TODO
	public static function addLink($id = 0)              {
	  global $self;//@TODO
    if(isset($_GET["pid"])) :
      $link   = "{$self}&addCart={$id}";
      else :
        $link = "{$self}?addCart={$id}";  
    endif;
    return $link;   
   }		

}

$cart = new Cart();