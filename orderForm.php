<?php 
  require_once("../includes/layouts/header.php");
  Cart::setSum();
  if(!Cart::$sum)
		redirect_to("index.php");

  if(isset($_POST['order'])) :
    $buyer->firstName  = $_POST['first-name'];
	  $buyer->lastName   = $_POST['last-name'];
    $buyer->email      = $_POST['email'];
    $buyer->phone      = $_POST['phone'];
    $buyer->adress     = $_POST['address'];
    $buyer->ip         = getIpAddress();
    $buyer->save();
    redirect_to("index.php");
  else :	
  endif;

require('orderForm.view.php');