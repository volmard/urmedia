<main class="cart-page">
  <div class="cart-page__container">		
    <form class="cart-page__form" action="<?=$_SERVER['REQUEST_URI'];?>" method="post">
      <div class="cart-page__left-column">
        <b class="cart-page__items-amount"><?=Cart::$amount?> Items</b>  
        <ul class="cart-page__list">
				<?php
				  foreach($cartItems as $item) :
					  Cart::setSum($item);
					  $shortDescr = getSerializedData($item->shortDescription, $descrKeys);
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
                <span><?=$item->brandTitle?></span> <?=$item->title?>
              </h2>
              <b class="cart-page__item-price">$<?=$item->price?></b>  
            </div>         
						<ul class="cart-page__features-list">
			      <?php	      
			        foreach($shortDescr as $attr => $value) :
			      		if($attr == $descrKeys[4]) :
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
              <input class="cart-page__input" type="number" step="1" min="1" max="100" name="quantity<?=$item->id?>" value="<?=$item->cartQuantity?>">
            </label> 
              <a class="cart-page__btn  btn" href="<?=$_SERVER['REQUEST_URI']?>&id=<?=$item->id?>">Remove</a>  
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
      <a class="order-summary__btn  btn" href="index.php?pid=orderForm">ORDER</a>
    </div>
  </form>    
</div>
</main>