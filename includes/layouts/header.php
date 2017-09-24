<?php  
  include("../includes/initialize.php");

  $image_src  = IMAGE_PATH."products/";

  // @cart initialization
  if(Cart::$amount) :
	  
    if(isset($_GET["pid"]) && $_GET["pid"] == 'cart') :
      $cartItems = $product->findItemByIds(Cart::getIds());
      Cart::setItemQuantity($cartItems);
      Cart::updateCart($cartItems);
    endif;

    $cartMsg = "";
  else: 
    $cartMsg = "U haven't added any item to this cart. Please, come back here later!";
	endif;

//  echo $message;
  $signinRef = substr($_SERVER['REQUEST_URI'],0,-11);
  $loginRef  = substr($_SERVER['REQUEST_URI'],0,-10);
//
//  if($session->isLoggedIn())
//		$user = Users::findByIdPrepared($session->userId);		

  if(isset($_POST['signin'])) :	
	  $user->login       = sanitizeInput($_POST['login']);
    if(Users::canUseLogin($user->login)) :
      $msg = "The name {$user->login} is busy. Please, try another one.";
			$session->message($msg);
      goto a;		
		endif;
	  $user->password   = $password = sanitizeInput($_POST['password']);
    $user->password   = $user->passwordHash();
    $user->firstName  = sanitizeInput($_POST['first-name']);
	  $user->lastName   = sanitizeInput($_POST['last-name']);
    $user->email      = sanitizeInput($_POST['email']);
    $user->phone      = sanitizeInput($_POST['phone']);
    $user->adress     = sanitizeInput($_POST['address']);
    $user->country    = sanitizeInput($_POST['countries']);
    $result           = $user->save();
    if($result) :
      $foundUser = Users::authenticate($user->login, $password);
      if($foundUser)
		    $session->login($foundUser);
    a: redirect_to($signinRef);   
    endif;
  else :	
    //
  endif;
  if(isset($_POST['login-btn'])) :
 	  $login     = sanitizeInput($_POST['login']);
	  $password  = sanitizeInput($_POST['password']); 
    $foundUser = Users::authenticate($login, $password);
    if($foundUser) :
		  $session->login($foundUser);
      redirect_to($loginRef);
		else: 
      $msg = "Login/password combination incorrect. Plese, try again";
			$session->message($msg);
    endif;
  else :
    //
  endif;

  if(isset($_GET['pid']) &&  $_GET['pid'] == 'logout') :
    $session->logout();
    redirect_to($main);
  endif;

  include("header.view.php");