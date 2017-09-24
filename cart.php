<?php 
require_once("../includes/layouts/header.php");

//Temporary solution for the case when there is no item added
  if($cartMsg) :
?>
  
	  <main class="cart-page">
	    <div class="cart-page__container">
	      <p class="cart-page__text  message">
	        <?=$cartMsg?>
	      </p>
	    </div>
	  </main>
	  
<?php
	  require_once("../includes/layouts/footer.php");
	  unset($_SESSION['summary']);
	  exit;
  endif;

require('cart.view.php');