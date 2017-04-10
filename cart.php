<?php 
$image_src  = IMAGE_PATH."products/";

//Temporary solution for the case when there is no item added
		  if(Cart::$amount == 0) {
				$msg  = "<main class=\"cart-page\">";
				$msg .= "<div class=\"cart-page__container\">";
		    $msg .= "<p class=\"cart-page__text  message\">";
		    $msg .= "U haven't added any item to this cart. Please, come back here later!";
		    $msg .= "</p>";
				$msg .= "</div>";
				$msg .= "</main>";
		    echo $msg;
				require_once("includes/layouts/footer.php");
				unset($_SESSION['summary']);
		    exit;
	    } else {
				$items = Cart::my_cart();				
				Cart::update_cart($items);
				Cart::delete_item_from_cart();	
			}
?>
<main class="cart-page">
  <div class="cart-page__container">		
    <form class="cart-page__form" action="<?=$_SERVER['REQUEST_URI'];?>" method="post">
      <div class="cart-page__left-column">
        <b class="cart-page__items-amount"><?=Cart::$amount?> Items</b>  
        <ul class="cart-page__list">
				<?php
				  foreach($items as $item) :
					  Cart::set_cart_sum($item);								
            $short               = $item->short_description;
            $short_description   = base_serialize($short, "decode");
            $description_keys    = array_keys($short_description);
				?>
				<li class="cart-page__item">
          <div class="cart-page__image-container">
            <a href="<?=$image_src.$item->image?>">
              <img src="<?=$image_src.$item->image?>" alt="<?=$item->caption?>" width="280" height="180">
            </a>
          </div>
          <section class="cart-page__item-info">
            <div class="cart-page__title-container">
              <h2 class="cart-page__item-title">
                <span><?=$item->brand_title?></span> <?=$item->title?>
              </h2>
              <b class="cart-page__item-price">$<?=$item->price?></b>  
            </div>         
						<ul class="cart-page__features-list">
			      <?php	      
			        foreach($short_description as $attr => $value) :
			      		if($attr == $description_keys[4]) :
			      		  break;
			      		else :
			      ?>		
			      	<li class="cart-page__features-item"><?=$attr.": ".$value?></li>
			      <?php
	              endif;
	            endforeach;
			      ?>
            </ul> 
            <label class="cart-page__label">quantity:   
              <input class="cart-page__input" type="number" step="1" min="1" max="100" name="quantity<?=$item->id?>" value="<?=$item->cart_quantity?>">
            </label> 
              <a class="cart-page__btn  btn" href="/cart/?id=<?=$item->id?>">Remove</a>  
            </section>
        </li>
			  <?php
	       endforeach;
				?>
      </ul>    
    </div>
    <div class="order-summary">
      <div class="order-summary__title-container">
        <h2 class="order-summary__title">Order Summary</h2>
        <input class="order-summary__update-btn  btn" type="submit" name="update" value="update">
      </div>      
      <div class="order-summary__text-container">  
        <p class="order-summary__text">
					<span>Merchandise:</span>
					<span>$<?=Cart::$sum?></span>
				</p>
        <p class="order-summary__text">
					<span>Estimated Shipping:</span>
					<span>FREE</span>
				</p>
        <p class="order-summary__text">
					<span>ORDER TOTAL:</span>
					<span>$<?=Cart::$sum?></span>
				</p>
      </div>    
      <a class="order-summary__btn  btn" href="/orderform/">ORDER</a>
    </div>
  </form>    
</div>
</main>
<?
	$_SESSION['summary'] = Cart::$sum;
?>